<?php
/**
 * @package plugins.elasticSearch
 * @subpackage api.objects
 */
class KalturaESearchEntryItem extends KalturaESearchItem
{

	/**
	 * @var KalturaESearchEntryFieldName
	 */
	public $fieldName;

	private static $map_between_objects = array(
		'fieldName'
	);

	protected function getMapBetweenObjects()
	{
		return array_merge(parent::getMapBetweenObjects(), self::$map_between_objects);
	}

	public function toObject($object_to_fill = null, $props_to_skip = array())
	{
		if (!$object_to_fill)
			$object_to_fill = new ESearchEntryItem();
		return parent::toObject($object_to_fill, $props_to_skip);
	}


}
