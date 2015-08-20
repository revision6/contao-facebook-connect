<?php

/**
 * This file is part of the Facebook Connect extension for Contao Open Source CMS.
 *
 * (c) 2014 Tristan Lins <tristan.lins@bit3.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package    bit3/contao-facebook-connect
 * @author     Tristan Lins <tristan.lins@bit3.de>
 * @copyright  2014 Tristan Lins <tristan.lins@bit3.de>
 * @link       https://bit3.de
 * @license    MIT
 * @filesource
 */

namespace Bit3\Contao\FacebookConnect;

use Bit3\Contao\FacebookConnect\Event\FaultyAuthenticateEvent;
use Bit3\Contao\FacebookConnect\Event\FaultyConnectEvent;
use Bit3\Contao\FacebookConnect\Event\InitConnectEvent;
use Bit3\Contao\FacebookConnect\Event\PostAuthenticateEvent;
use Bit3\Contao\FacebookConnect\Event\PostConnectEvent;
use Bit3\Contao\FacebookConnect\Event\PreAuthenticateEvent;
use Bit3\Contao\FacebookConnect\Event\PreConnectEvent;
use Guzzle\Http\Client;
use Guzzle\Http\Exception\BadResponseException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * The Facebook Connect module / content element that handle the whole connect and authentication process.
 */
class FacebookConnect extends \TwigSimpleHybrid
{

	protected $strTemplate = 'mod_facebook_connect';

	/**
	 * {@inheritdoc}
	 */
	protected function compile()
	{
		if (TL_MODE == 'BE') {
			return;
		}

		if (empty($this->facebook_connect_app_id)) {
			throw new \RuntimeException('No APP ID is defined!');
		}

		$code = \Input::get('code');

		// The state in the session does not match the passed state -> XSS attack
		if (isset($_SESSION['FACEBOOK_CONNECT_STATE']) && $_SESSION['FACEBOOK_CONNECT_STATE'] != \Input::get('state')) {
			unset($_SESSION['FACEBOOK_CONNECT_STATE']);
		}

		// Form submit -> initiate connect
		if (\Input::post('TL_FORM') == 'facebook_connect_' . $this->id) {
			$this->init();
		}

		// state is valid and code is provided -> connect success
		else if ($code && isset($_SESSION['FACEBOOK_CONNECT_STATE'])) {
			$this->connect($code);
		}

		// FB login success, now authenticate the member
		else if (isset($_SESSION['FACEBOOK_CONNECT_LOGIN'])) {
			list($username, $accessToken) = $_SESSION['FACEBOOK_CONNECT_LOGIN'];
			unset($_SESSION['FACEBOOK_CONNECT_LOGIN']);

			$referer = $_SESSION['FACEBOOK_CONNECT_REFERER'];
			unset($_SESSION['FACEBOOK_CONNECT_REFERER']);

			$this->authenticateUser($username, $accessToken, $referer ? base64_decode($referer) : null);
		}
	}

	/**
	 * Initiate the facebook connect.
	 */
	protected function init()
	{
		$referer = \Input::get('redirect', true, true);
		$state   = md5(uniqid(rand(), true));
		$url     = 'https://www.facebook.com/dialog/oauth?' .
			http_build_query(
				array(
					'client_id'    => $this->facebook_connect_app_id,
					'redirect_uri' => \Environment::get('base') .
						\Controller::generateFrontendUrl($GLOBALS['objPage']->row()),
					'state'        => $state,
					'scope'        => $this->facebook_connect_scope,
				)
			);

		/** @var EventDispatcherInterface $eventDispatcher */
		$eventDispatcher = $GLOBALS['container']['event-dispatcher'];

		$event = new InitConnectEvent($referer, $state, $url);
		$eventDispatcher->dispatch(FacebookConnectEvents::INIT_CONNECT, $event);

		$_SESSION['FACEBOOK_CONNECT_REFERER'] = $event->getReferer();
		$_SESSION['FACEBOOK_CONNECT_STATE']   = $event->getState();
		$url                                  = $event->getUrl();

		\Controller::redirect($url);
	}

	/**
	 * Process the connect against facebook.
	 *
	 * @param string $code
	 *
	 * @throws \Exception
	 */
	protected function connect($code)
	{
		/** @var EventDispatcherInterface $eventDispatcher */
		$eventDispatcher = $GLOBALS['container']['event-dispatcher'];

		$redirectUrl = \Environment::get('base') .
			\Controller::generateFrontendUrl($GLOBALS['objPage']->row());

		$event = new PreConnectEvent($code);
		$eventDispatcher->dispatch(FacebookConnectEvents::PRE_CONNECT, $event);
		$code = $event->getCode();

		try {
			// receive a new access token
			$url = 'https://graph.facebook.com/oauth/access_token?' .
				http_build_query(
					array(
						'client_id'     => $this->facebook_connect_app_id,
						'redirect_uri'  => $redirectUrl,
						'client_secret' => $this->facebook_connect_app_secret,
						'code'          => $code
					)
				);

			$client = new Client();

			$request  = $client->get($url);
			$response = $request->send();

			parse_str($response->getBody(true), $params);

			// fetch user profile
			$url = 'https://graph.facebook.com/me?' . http_build_query(
					array(
						'access_token' => $params['access_token'],
						'fields'       => 'id,name,first_name,last_name,gender,email,locale,link'
					)
			);

			$request  = $client->get($url);
			$response = $request->send();

			$userData = json_decode($response->getBody(true), true);

			// faulty connect
			if (empty($userData['id'])) {
				$event = new FaultyConnectEvent($params, $userData);
				$eventDispatcher->dispatch(FacebookConnectEvents::FAULTY_CONNECT, $event);

				\Controller::redirect(\Environment::get('base'));
			}

			$member    = \MemberModel::findOneBy('facebook_id', $userData['id']);
			$newMember = false;

			if (!$member) {
				$newMember = true;

				// generate username
				$username = standardize($userData['name']);
				for ($n = 1; \MemberModel::findBy('username', $username); $n++) {
					$username = standardize($userData['name'] . '-' . $n);
				}

				$member              = new \MemberModel();
				$member->tstamp      = time();
				$member->groups      = deserialize($this->facebook_connect_groups, true);
				$member->dateAdded   = time();
				$member->createdOn   = time();
				$member->firstname   = $userData['first_name'];
				$member->lastname    = $userData['last_name'];
				$member->gender      = $userData['gender'];
				$member->email       = strtolower($userData['email']);
				$member->login       = 1;
				$member->username    = $username;
				$member->language    = $userData['locale'];
				$member->facebook_id = $userData['id'];
			}

			$member->password                  = \Encryption::hash($params['access_token']);
			$member->facebook_link             = $userData['link'];
			$member->facebook_access_token     = $params['access_token'];
			$member->facebook_access_token_ttl = time() + $params['expires'];

			$event = new PostConnectEvent($params, $userData, $member, $newMember);
			$eventDispatcher->dispatch(FacebookConnectEvents::POST_CONNECT, $event);

			$event->getMember()->save();

			unset($_SESSION['FACEBOOK_CONNECT_STATE']);
			$_SESSION['FACEBOOK_CONNECT_LOGIN'] = array($member->username, $params['access_token']);

			\Controller::redirect($redirectUrl);
		}
		catch (BadResponseException $exception) {
			$redirectUrl .= '?' . http_build_query(
				array(
					'status_code'    => $exception->getResponse()->getStatusCode(),
					'status_message' => $exception->getResponse()->getReasonPhrase(),
				)
			);
			\Controller::redirect($redirectUrl);
		}
	}

	/**
	 * Authenticate the user after successfully connect to facebook.
	 *
	 * @param string $username
	 * @param string $accessToken
	 * @param string $referer
	 *
	 * @throws \RuntimeException
	 */
	protected function authenticateUser($username, $accessToken, $referer = null)
	{
		/** @var EventDispatcherInterface $eventDispatcher */
		$eventDispatcher = $GLOBALS['container']['event-dispatcher'];

		$frontendUser = \FrontendUser::getInstance();

		$event = new PreAuthenticateEvent($frontendUser, $username, $accessToken, $referer);
		$eventDispatcher->dispatch(FacebookConnectEvents::PRE_AUTHENTICATE, $event);

		$frontendUser = $event->getFrontendUser();
		$username     = $event->getUsername();
		$accessToken  = $event->getAccessToken();
		$referer      = $event->getReferer();

		// set credentials
		\Input::setPost('username', $username);
		\Input::setPost('password', $accessToken);

		if ($frontendUser->login()) {
			$event = new PostAuthenticateEvent($frontendUser, $username, $accessToken, $referer);
			$eventDispatcher->dispatch(FacebookConnectEvents::POST_AUTHENTICATE, $event);

			$referer = $event->getReferer();

			// redirect to referer page
			if ($referer) {
				\Controller::redirect($referer);
			}

			// redirect to jump to page
			if ($this->facebook_connect_jumpTo) {
				$page = \PageModel::findByPk($this->facebook_connect_jumpTo);

				if (!$page) {
					throw new \RuntimeException('Page ID ' . $this->facebook_connect_jumpTo . ' was not found');
				}

				\Controller::redirect($this->generateFrontendUrl($page->row()));
			}

			// redirect to start page
			\Controller::redirect(\Environment::get('base'));
		}
		else {
			$event = new FaultyAuthenticateEvent($frontendUser, $username, $accessToken, $referer);
			$eventDispatcher->dispatch(FacebookConnectEvents::FAULTY_AUTHENTICATE, $event);

			// redirect to start page
			\Controller::redirect(\Environment::get('base'));
		}
	}
}
