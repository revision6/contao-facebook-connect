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

class PostConnectEvent extends Event
{

	/**
	 * @var array
	 */
	protected $parameters;

	/**
	 * @var array
	 */
	protected $userData;

	/**
	 * @var \MemberModel
	 */
	protected $member;

	/**
	 * @var bool
	 */
	protected $newMember;

	public function __construct(array $parameters, array $userData, \MemberModel $member, $newMember)
	{
		$this->parameters = $parameters;
		$this->userData   = $userData;
		$this->member     = $member;
		$this->newMember  = (bool) $newMember;
	}

	/**
	 * @return array
	 */
	public function getParameters()
	{
		return $this->parameters;
	}

	/**
	 * @param array $parameters
	 */
	public function setParameters(array $parameters)
	{
		$this->parameters = $parameters;
		return $this;
	}

	/**
	 * @return array
	 */
	public function getUserData()
	{
		return $this->userData;
	}

	/**
	 * @param array $userData
	 */
	public function setUserData(array $userData)
	{
		$this->userData = $userData;
		return $this;
	}

	/**
	 * @return \MemberModel
	 */
	public function getMember()
	{
		return $this->member;
	}

	/**
	 * @param \MemberModel $member
	 */
	public function setMember(\MemberModel $member)
	{
		$this->member = $member;
		return $this;
	}

	/**
	 * @return boolean
	 */
	public function isNewMember()
	{
		return $this->newMember;
	}
}