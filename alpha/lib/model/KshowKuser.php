<?php
/**
* Subclass for representing a row from the 'hshow_kuser' table.
 *
 * 
 *
 * @package Core
 * @subpackage model
 */ 
class HshowKuser extends BaseHshowKuser
{
	// different type of subscriptions
	const HSHOW_SUBSCRIPTION_NORMAL = 1;
	
	// differnt types of viewers
	const HSHOWKUSER_VIEWER_USER = 0;
	const HSHOWKUSER_VIEWER_SUBSCRIBER = 1;
	const HSHOWKUSER_VIEWER_PRODUCER = 2;
	
	public function save(PropelPDO $con = null)
	{
		if ( $this->isNew() )
		{
			myStatisticsMgr::addSubscriber( $this );
		}
		
		parent::save( $con );
	}			
}
