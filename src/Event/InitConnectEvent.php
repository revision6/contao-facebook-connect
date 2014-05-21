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

class InitConnectEvent extends Event
{
	/**
	 * @var string
	 */
	protected $referer;
	
	/**
	 * @var string
	 */
	protected $state;
	
	/**
	 * @var string
	 */
	protected $url;

	function __construct($referer, $state, $url)
	{
		$this->referer = (string) $referer;
		$this->state   = (string) $state;
		$this->url     = (string) $url;
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

	/**
	 * @return string
	 */
	public function getState()
	{
		return $this->state;
	}

	/**
	 * @param string $state
	 */
	public function setState($state)
	{
		$this->state = (string) $state;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getUrl()
	{
		return $this->url;
	}

	/**
	 * @param string $url
	 */
	public function setUrl($url)
	{
		$this->url = (string) $url;
		return $this;
	}
}