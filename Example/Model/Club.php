<?php
/**
 * Club Model
 *
 * @package		MicroMVC
 * @author		David Pennington
 * @copyright	(c) 2011 MicroMVC Framework
 * @license		http://micromvc.com/license
 ********************************** 80 Columns *********************************
 */
namespace Example\Model;

class Club extends ORM
{
	public static $table = 'club';
	public static $foreign_key = 'club_id';

	public static $has = array(
		'memberships' => '\Example\Model\Membership'
	);

	public static $has_many_through = array(
		'students' => array('Example\Model\Membership' => 'Example\Model\Student'),
	);
}