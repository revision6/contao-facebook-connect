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

namespace Bit3\Contao\FacebookConnect\Event;

use Symfony\Component\EventDispatcher\Event;

class PostAuthenticateEvent extends Event
{
	/**
	 * @var \FrontendUser
	 */
	protected $frontendUser;

	/**
	 * @var string
	 */
	protected $username;

	/**
	 * @var string
	 */
	protected $accessToken;

	/**
	 * @var string
	 */
	protected $referer;

	public function __construct(\FrontendUser $frontendUser, $username, $accessToken, $referer = null)
	{
		$this->frontendUser = $frontendUser;
		$this->username     = (string) $username;
		$this->accessToken  = (string) $accessToken;
		$this->referer      = (string) $referer;
	}

	/**
	 * @return \FrontendUser
	 */
	public function getFrontendUser()
	{
		return $this->frontendUser;
	}

	/**
	 * @param \FrontendUser $frontendUser
	 */
	public function setFrontendUser(\FrontendUser $frontendUser)
	{
		$this->frontendUser = $frontendUser;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getUsername()
	{
		return $this->username;
	}

	/**
	 * @param string $username
	 */
	public function setUsername($username)
	{
		$this->username = (string) $username;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getAccessToken()
	{
		return $this->accessToken;
	}

	/**
	 * @param string $accessToken
	 */
	public function setAccessToken($accessToken)
	{
		$this->accessToken = (string) $accessToken;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getReferer()
	{
		return $this->referer;
	}

	/**
	 * @param string $referer
	 */
	public function setReferer($referer)
	{
		$this->referer = (string) $referer;
		return $this;
	}
}