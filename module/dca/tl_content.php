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
 * Palettes
 */
$GLOBALS['TL_DCA']['tl_content']['metapalettes']['facebook_connect'] = array(
	'type'             => array('type', 'headline'),
	'facebook_connect' => array(
		'facebook_connect_app_id',
		'facebook_connect_app_secret',
		'facebook_connect_scope',
		'facebook_activation_required',
		'facebook_connect_groups',
		'facebook_connect_jumpTo'
	),
	'protected'        => array(':hide', 'protected'),
	'expert'           => array(':hide', 'guests', 'cssID', 'space'),
	'invisible'        => array(':hide', 'invisible', 'start', 'stop'),
);

$GLOBALS['TL_DCA']['tl_content']['metasubpalettes']['facebook_activation_required'] = array(
	'nc_notification'
);

/**
 * Fields
 */
$GLOBALS['TL_DCA']['tl_content']['fields']['facebook_connect_app_id']     = array(
	'label'     => &$GLOBALS['TL_LANG']['tl_content']['facebook_connect_app_id'],
	'inputType' => 'text',
	'eval'      => array(
		'mandatory' => true,
		'tl_class'  => 'w50',
		'maxlength' => 255,
		'doNotCopy' => true,
		'doNotShow' => true,
	),
	'sql'       => 'varchar(255) NOT NULL default \'\'',
);
$GLOBALS['TL_DCA']['tl_content']['fields']['facebook_connect_app_secret'] = array(
	'label'     => &$GLOBALS['TL_LANG']['tl_content']['facebook_connect_app_secret'],
	'inputType' => 'text',
	'eval'      => array(
		'mandatory' => true,
		'tl_class'  => 'w50',
		'maxlength' => 255,
		'doNotCopy' => true,
		'doNotShow' => true,
	),
	'sql'       => 'varchar(255) NOT NULL default \'\'',
);
$GLOBALS['TL_DCA']['tl_content']['fields']['facebook_connect_scope']      = array(
	'label'         => &$GLOBALS['TL_LANG']['tl_content']['facebook_connect_scope'],
	'default'       => 'public_profile,email',
	'inputType'     => 'checkbox',
	'options'       => array(
		'public_profile_legend'               => array(
			'public_profile',
		),
		'friends_legend'                      => array(
			'user_friends',
		),
		'email_legend'                        => array(
			'email',
		),
		'extended_profile_properties_legend'  => array(
			'user_about_me',
			'user_activities',
			'user_birthday',
			'user_education_history',
			'user_events',
			'user_groups',
			'user_hometown',
			'user_interests',
			'user_likes',
			'user_location',
			'user_photos',
			'user_relationships',
			'user_relationship_details',
			'user_religion_politics',
			'user_status',
			'user_tagged_places',
			'user_videos',
			'user_website',
			'user_work_history',
		),
		'extended_permissions_legend'         => array(
			'read_friendlists',
			'read_insights',
			'read_mailbox',
			'read_stream',
		),
		'extended_permissions_publish_legend' => array(
			'create_event',
			'manage_notifications',
			'publish_actions',
			'rsvp_event',
		),
		'open_graph_permissions_legend'       => array(
			'publish_actions',
			'user_actions.books',
			'user_actions.fitness',
			'user_actions.music',
			'user_actions.news',
			'user_actions.video',
			'user_games_activity',
		),
		'pages_legend'                        => array(
			'manage_pages',
			'read_page_mailboxes',
		),
	),
	'reference'     => &$GLOBALS['TL_LANG']['tl_content'],
	'eval'          => array(
		'multiple'  => true,
		'tl_class'  => 'clr',
	),
	'load_callback' => array(array('Bit3\Contao\FacebookConnect\DataContainer\Callbacks', 'loadScope')),
	'save_callback' => array(array('Bit3\Contao\FacebookConnect\DataContainer\Callbacks', 'saveScope')),
	'sql'           => 'varchar(255) NOT NULL default \'\'',
);
$GLOBALS['TL_DCA']['tl_content']['fields']['facebook_connect_groups']     = array(
	'label'      => &$GLOBALS['TL_LANG']['tl_content']['facebook_connect_groups'],
	'inputType'  => 'checkbox',
	'foreignKey' => 'tl_member_group.name',
	'eval'       => array(
		'mandatory' => true,
		'multiple'  => true,
		'tl_class'  => 'clr',
	),
	'sql'        => 'varchar(255) NOT NULL default \'\''
);
$GLOBALS['TL_DCA']['tl_content']['fields']['facebook_connect_jumpTo']     = array(
	'label'     => &$GLOBALS['TL_LANG']['tl_content']['facebook_connect_jumpTo'],
	'inputType' => 'pageTree',
	'eval'      => array(
		'tl_class' => 'clr',
	),
	'sql'       => 'int(10) NOT NULL default \'0\'',
);
$GLOBALS['TL_DCA']['tl_content']['fields']['facebook_activation_required']     = array(
	'label'      => &$GLOBALS['TL_LANG']['tl_content']['facebook_activation_required'],
	'inputType'  => 'checkbox',
	'eval'       => array(
		'multiple'  => false,
		'tl_class'  => 'clr',
		'submitOnChange' => true,
	),
	'sql'        => 'char(1) NOT NULL default \'\''
);

if (in_array('notification_center', \ModuleLoader::getActive())) {
	$GLOBALS['TL_DCA']['tl_content']['fields']['nc_notification'] = array
	(
		'label'                     => &$GLOBALS['TL_LANG']['tl_content']['nc_notification'],
		'exclude'                   => true,
		'inputType'                 => 'select',
		'options_callback'          => array('NotificationCenter\tl_module', 'getNotificationChoices'),
		'eval'                      => array('includeBlankOption'=>true, 'chosen'=>true, 'tl_class'=>'w50'),
		'sql'                       => "int(10) unsigned NOT NULL default '0'",
		'relation'                  => array('type'=>'hasOne', 'load'=>'lazy', 'table'=>'tl_nc_notification'),
	);
}
