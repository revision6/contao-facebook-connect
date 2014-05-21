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

namespace Bit3\Contao\FacebookConnect\DataContainer;

class Callbacks
{
	public function loadScope($value)
	{
		$value = explode(',', $value);
		$value = array_map('trim', $value);
		$value = array_filter($value);

		if (!in_array('public_profile', $value)) {
			$value[] = 'public_profile';
		}
		if (!in_array('email', $value)) {
			$value[] = 'email';
		}

		return $value;
	}

	public function saveScope($value)
	{
		$value = deserialize($value, true);
		$value = array_map('trim', $value);
		$value = array_filter($value);

		if (!in_array('public_profile', $value)) {
			$value[] = 'public_profile';
		}
		if (!in_array('email', $value)) {
			$value[] = 'email';
		}

		return implode(',', $value);
	}
}