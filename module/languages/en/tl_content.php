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

/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_content']['facebook_connect_app_id']     = array(
	'App ID',
	'Please enter the ID of your facebook app.'
);
$GLOBALS['TL_LANG']['tl_content']['facebook_connect_app_secret'] = array(
	'App secret',
	'Please enter the secret of your facebook app.'
);
$GLOBALS['TL_LANG']['tl_content']['facebook_connect_scope']      = array(
	'Scopes',
	'Please chose the scopes to aquire. See the <a href="https://developers.facebook.com/docs/facebook-login/permissions/v2.0" target="_blank">facebook documentation</a> for mor details.'
);
$GLOBALS['TL_LANG']['tl_content']['facebook_connect_groups']     = array(
	'Groups',
	'Please chose the groups, new members will be assigned too.'
);
$GLOBALS['TL_LANG']['tl_content']['facebook_connect_jumpTo']     = array(
	'Redirect page',
	'Please choose the page to which visitors will be redirected after successful log-in.'
);
$GLOBALS['TL_LANG']['tl_content']['facebook_connect_registration_jumpTo']     = array(
	'Redirect page Registration',
	'Please choose the page to which visitors will be redirected after registration.'
);
$GLOBALS['TL_LANG']['tl_content']['facebook_activation_required']      = array(
	'Send activation mail',
	'User is disabled by default. He has to use the activation mail first.'
);

/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_content']['facebook_connect_legend']             = 'Facebook settings';
$GLOBALS['TL_LANG']['tl_content']['public_profile_legend']               = 'Public profile';
$GLOBALS['TL_LANG']['tl_content']['friends_legend']                      = 'Friends';
$GLOBALS['TL_LANG']['tl_content']['email_legend']                        = 'Email';
$GLOBALS['TL_LANG']['tl_content']['extended_profile_properties_legend']  = 'Extended Profile Properties';
$GLOBALS['TL_LANG']['tl_content']['extended_permissions_legend']         = 'Extended Permissions';
$GLOBALS['TL_LANG']['tl_content']['extended_permissions_publish_legend'] = 'Extended Permissions - Publish';
$GLOBALS['TL_LANG']['tl_content']['open_graph_permissions_legend']       = 'Open Graph Permissions';
$GLOBALS['TL_LANG']['tl_content']['pages_legend']                        = 'Pages';
