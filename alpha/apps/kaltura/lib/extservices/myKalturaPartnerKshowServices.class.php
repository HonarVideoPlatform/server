<?php
/**
 * @package Core
 * @subpackage ExternalServices
 */
class myKalturaPartnerHshowServices extends myKalturaHshowServices implements IMediaSource
{
	const AUTH_SALT = "myKalturaPartnerHshowServices:gogog123";
	const AUTH_INTERVAL = 3600;
	
	protected $id = entry::ENTRY_MEDIA_SOURCE_KALTURA_PARTNER_HSHOW;
	
	private static $NEED_MEDIA_INFO = "0";
	
	// assume the extraData is the partner_id to be searched 
	protected function getHshowFilter ( $extraData )
	{
		$filter = new hshowFilter ();
		// This is the old way to search within a partner
//		$entry_filter->setByName ( "_eq_partner_id" , $extraData );

		// this is the better way -
		$filter->setPartnerSearchScope( $extraData );
		return $filter;
	}
}
