<?php
/**
 * @package api
 * @subpackage objects
 */
class KalturaScope extends KalturaObject
{
	public function toObject($objectToFill = null, $propsToSkip = array())
	{
		if (is_null($objectToFill))
			$objectToFill = new hScope();

		return parent::toObject($objectToFill, $propsToSkip);
	}
}