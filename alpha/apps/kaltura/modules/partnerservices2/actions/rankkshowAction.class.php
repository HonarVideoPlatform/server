<?php
/**
 * After making sure the ticket is a valid admin ticket - the setrvice is allowed and no other validations should be done
 * 
 * @package api
 * @subpackage ps2
 */
class rankhshowAction extends defPartnerservices2Action
{
	public function describe()
	{
		return 	
			array (
				"display_name" => "rankHShow",
				"desc" => "" ,
				"in" => array (
					"mandatory" => array ( 
						"hshow_id" => array ("type" => "string", "desc" => ""),
						"rank" => array ("type" => "integer", "desc" => "")
						),
					"optional" => array ()
					),
				"out" => array (
					"rank" => array ("type" => "array", "desc" => "")
					),
				"errors" => array (
					APIErrors::INVALID_RANK ,
					APIErrors::INVALID_HSHOW_ID , 
					APIErrors::USER_ALREADY_RANKED_HSHOW , 
					
				)
			); 
	}
	
	protected function ticketType()	{		return self::REQUIED_TICKET_REGULAR;	}
	// ask to fetch the kuser from puser_kuser - so we can tel the difference between a 
	public function needKuserFromPuser ( )	{		return self::KUSER_DATA_KUSER_ID_ONLY; 	}
	
	public function executeImpl ( $partner_id , $subp_id , $puser_id , $partner_prefix , $puser_kuser )
	{
		$hshow_id = $this->getPM ( "hshow_id" );
		$rank = $this->getPM ( "rank" );
		
		$hshow = hshowPeer::retrieveByPK( $hshow_id );
		
		if ( ! $hshow )
		{
			$this->addError( APIErrors::INVALID_HSHOW_ID , $hshow_id  );
			return;		
		}
		
		if ( $rank > entry::MAX_NORMALIZED_RANK || $rank < 0 || ! is_numeric( $rank ))
		{
			$this->addError( APIErrors::INVALID_RANK , $rank );
			return;					
		}

		$kuser_id = $puser_kuser->getKuserId();
		$entry_id = $hshow->getShowEntryId();
		
		$partner = PartnerPeer::retrieveByPK($partner_id);

		if (!$partner->getAllowAnonymousRanking()) 
		{
			// prevent duplicate votes
			$c = new Criteria ();
			$c->add ( kvotePeer::KUSER_ID , $kuser_id);
			$c->add ( kvotePeer::ENTRY_ID , $entry_id);
			$c->add ( kvotePeer::HSHOW_ID , $hshow_id);
			
			$kvote = kvotePeer::doSelectOne( $c );
			if ( $kvote != NULL )
			{
				$this->addError( APIErrors::USER_ALREADY_RANKED_HSHOW , $puser_id  , $hshow_id );
				return;						
			}
		}
		
		$kvote = new kvote();
		$kvote->setHshowId($hshow_id);
		$kvote->setEntryId($entry_id);
		$kvote->setKuserId($kuser_id);
		$kvote->setRank($rank);
		$kvote->save();

		$statistics_results = $kvote->getStatisticsResults();
		$updated_hshow = @$statistics_results["hshow"];
		
		if ( $updated_hshow )
		{
			myNotificationMgr::createNotification( kNotificationJobData::NOTIFICATION_TYPE_HSHOW_RANK , $updated_hshow );
			
			$data = array ( "hshow_id" => $hshow_id , 
				"uid" => $puser_id ,
				"rank" => $updated_hshow->getRank() ,
				"votes" => $updated_hshow->getVotes() );
				
			//$this->addMsg ( "hshow" , objectWrapperBase::getWrapperClass( $updated_hshow , objectWrapperBase::DETAIL_LEVEL_DETAILED) );
			$this->addMsg ( "rank" , $data ); 
		}

	}
}
?>