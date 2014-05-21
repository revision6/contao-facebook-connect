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
$GLOBALS['TL_DCA']['tl_member']['palettes']['default'] .= ';{facebook_legend},facebook_id,facebook_link';

/**
 * Fields
 */
$GLOBALS['TL_DCA']['tl_member']['fields']['facebook_id']               = array(
	'label'     => &$GLOBALS['TL_LANG']['tl_member']['facebook_id'],
	'inputType' => 'text',
	'eval'      => array('tl_class' => 'w50', 'maxlength' => 255, 'doNotCopy' => true),
	'sql'       => 'varchar(255) NOT NULL default \'\''
);
$GLOBALS['TL_DCA']['tl_member']['fields']['facebook_link']             = array(
	'label'     => &$GLOBALS['TL_LANG']['tl_member']['facebook_link'],
	'inputType' => 'text',
	'eval'      => array('tl_class' => 'w50', 'maxlength' => 255, 'doNotCopy' => true),
	'sql'       => 'varchar(255) NOT NULL default \'\''
);
$GLOBALS['TL_DCA']['tl_member']['fields']['facebook_access_token']     = array(
	'label' => &$GLOBALS['TL_LANG']['tl_member']['facebook_access_token'],
	'eval'  => array('doNotCopy' => true, 'doNotShow' => true),
	'sql'   => 'varchar(255) NOT NULL default \'\''
);
$GLOBALS['TL_DCA']['tl_member']['fields']['facebook_access_token_ttl'] = array(
	'label' => &$GLOBALS['TL_LANG']['tl_member']['facebook_access_token_ttl'],
	'eval'  => array('doNotCopy' => true),
	'sql'   => 'int(10) NOT NULL default \'0\''
);
