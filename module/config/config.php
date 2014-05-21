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
 * System settings
 */
$GLOBALS['TL_CONFIG']['facebook_connect_app_id'] = '';
$GLOBALS['TL_CONFIG']['facebook_connect_app_secret'] = '';
$GLOBALS['TL_CONFIG']['facebook_connect_groups'] = '';


/**
 * Content elements and frontend modules
 */
$GLOBALS['FE_MOD']['user']['facebook_connect'] = 'Bit3\Contao\FacebookConnect\FacebookConnect';
$GLOBALS['TL_CTE']['user']['facebook_connect'] = 'Bit3\Contao\FacebookConnect\FacebookConnect';
