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

/**
 * Collection of event names.
 */
class FacebookConnectEvents
{
	/**
	 * The INIT_CONNECT event occurs when the connect is initiated, right before redirect to facebook.
	 *
	 * The event listener method receives a Bit3\Contao\FacebookConnect\Event\InitConnectEvent instance.
	 *
	 * @var string
	 *
	 * @api
	 */
	const INIT_CONNECT = 'facebook-connect.init';

	/**
	 * The PRE_CONNECT event occurs right before the connect is evaluated.
	 *
	 * The event listener method receives a Bit3\Contao\FacebookConnect\Event\PreConnectEvent instance.
	 *
	 * @var string
	 *
	 * @api
	 */
	const PRE_CONNECT = 'facebook-connect.pre-connect';

	/**
	 * The Post_CONNECT event occurs after the connect is finished.
	 *
	 * The event listener method receives a Bit3\Contao\FacebookConnect\Event\PostConnectEvent instance.
	 *
	 * @var string
	 *
	 * @api
	 */
	const POST_CONNECT = 'facebook-connect.post-connect';

	/**
	 * The FAULTY_CONNECT event occurs when the connect failed.
	 *
	 * The event listener method receives a Bit3\Contao\FacebookConnect\Event\FaultyConnectEvent instance.
	 *
	 * @var string
	 *
	 * @api
	 */
	const FAULTY_CONNECT = 'facebook-connect.faulty-connect';

	/**
	 * The PRE_AUTHENTICATE event occurs when the connect is finished, right before the frontend user is authenticated.
	 *
	 * The event listener method receives a Bit3\Contao\FacebookConnect\Event\PreAuthenticateEvent instance.
	 *
	 * @var string
	 *
	 * @api
	 */
	const PRE_AUTHENTICATE = 'facebook-connect.pre-authenticate';

	/**
	 * The Post_AUTHENTICATE event occurs when the connect is finished, after the frontend user is authenticated.
	 *
	 * The event listener method receives a Bit3\Contao\FacebookConnect\Event\PostAuthenticateEvent instance.
	 *
	 * @var string
	 *
	 * @api
	 */
	const POST_AUTHENTICATE = 'facebook-connect.post-authenticate';

	/**
	 * The FAULTY_AUTHENTICATE event occurs when the connect is finished, but the frontend user authentication failed.
	 *
	 * The event listener method receives a Bit3\Contao\FacebookConnect\Event\FaultyAuthenticateEvent instance.
	 *
	 * @var string
	 *
	 * @api
	 */
	const FAULTY_AUTHENTICATE = 'facebook-connect.faulty-authenticate';
}