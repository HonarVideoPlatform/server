<?php
/**
 * @package plugins.viewHistory
 * @subpackage api.filters
 */
class KalturaViewHistoryUserEntryFilter extends KalturaUserEntryFilter
{
	public function getListResponse(KalturaFilterPager $pager, KalturaDetachedResponseProfile $responseProfile = null)
	{
		$this->typeEqual = ViewHistoryPlugin::getApiValue(ViewHistoryUserEntryType::VIEW_HISTORY);
		$response = parent::getListResponse($pager, $responseProfile);
		
		return $response;
	}
	
	public function toObject ($object_to_fill = null, $props_to_skip = array())
	{
		if (kCurrentContext::getCurrentSessionType() == SessionType::USER)
		{
			$this->userIdEqual = kCurrentContext::getCurrentHsKuser()->getPuserId();
			$this->userIdIn = null;
			$this->userIdNotIn = null;
		}
		elseif (!$this->userIdEqual && !$this->userIdIn && !$this->userIdNotIn)
		{
			$this->userIdEqual = kCurrentContext::getCurrentHsKuser() ? kCurrentContext::getCurrentHsKuser()->getPuserId() : null;
		}
		
		
		return parent::toObject($object_to_fill, $props_to_skip);
	}
}
