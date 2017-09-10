<?php
/**
 * @package api
 * @subpackage objects
 */
class KalturaStartWidgetSessionResponse extends KalturaObject
{
	/**
	 * @var int
	 * @readonly
	 */
	public $partnerId;
	
	/**
	 * @var string
	 * @readonly
	 */
	public $hs;
	
	/**
	 * @var string
	 * @readonly
	 */
	public $userId;
}