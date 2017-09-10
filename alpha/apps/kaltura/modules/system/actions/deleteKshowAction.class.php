<?php
/**
 * @package    Core
 * @subpackage system
 * @deprecated
 */
require_once ( __DIR__ . "/kalturaSystemAction.class.php" );

/**
 * @package    Core
 * @subpackage system
 * @deprecated
 */
class deleteHshowAction extends kalturaSystemAction
{
	/**
	 * 
select hshow.id,concat('http://www.kaltura.com/index.php/browse/bands?band_id=',indexed_custom_data_1),concat('http://profile.myspace.com/index.cfm?fuseaction=user.viewpr
ofile&friendID=',indexed_custom_data_1) ,  kuser.screen_name , indexed_custom_data_1  from hshow ,kuser where hshow.partner_id=5 AND kuser.id=hshow.producer_id AND hshow.
id>=10815  order by hshow.id ;
~

	 */
	public function execute()
	{
		$this->forceSystemAuthentication();
		
		$hshow_id = $this->getRequestParameter( "hshow_id" , null );
		$band_id = $this->getRequestParameter( "band_id" , null );
		$kuser_name = $this->getRequestParameter( "kuser_name" , null );
		
		$this->other_hshows_by_producer = null;
		
		$error = "";
		
		$hshow = null;
		$kuser = null;
		$entries = null;
		
		$this->kuser_count = 0;
		
		$should_delete = $this->getRequestParameter( "deleteme" , "false" ) == "true" ;
		if ( $kuser_name )
		{
			$c = new Criteria();
			$c->add ( kuserPeer::SCREEN_NAME , "%" . $kuser_name . "%" , Criteria::LIKE );
			$this->kuser_count = kuserPeer::doCount ( $c );
			$kuser = kuserPeer::doSelectOne ( $c );
			
			if ( $kuser )
			{
				$this->other_hshows_by_producer = $this->getHshowsForKuser ( $kuser , null );
			}
			else
			{
				$error .= "Cannot find kuser with name [$kuser_name]<br>";
			}
			
			$other_hshow_count = count ( $this->other_hshows_by_producer );
			if (  $other_hshow_count < 1 )
			{
				// kuser has no hshow - delete him !
				if ( $should_delete )
				{
					$kuser->delete();
				}
			}
			else if ( $other_hshow_count == 1 )
			{
				$hshow_id = $this->other_hshows_by_producer[0]->getId();
			}
			else
			{
				// kuser has more than one hshow - let user choose 
				$error .= "[$kuser_name] has ($other_hshow_count) shows.<br>";
			}
		}
		
		if ( $band_id )
		{
			$c = new Criteria();
			$c->add ( hshowPeer::INDEXED_CUSTOM_DATA_1 , $band_id );
			$c->add ( hshowPeer::PARTNER_ID , 5 );
			$hshow = hshowPeer::doSelectOne( $c );
		}
		else if ( $hshow_id )
		{
			$hshow = hshowPeer::retrieveByPK( $hshow_id ); 
		}
		
		if ( $hshow )
		{
			if ( ! $kuser )		$kuser = kuserPeer::retrieveByPK( $hshow->getProducerId() );
			if ( $kuser )
			{
				$this->other_hshows_by_producer = $this->getHshowsForKuser ( $kuser , $hshow );
				
				if ( $should_delete )
				{
					if ( count ( $this->other_hshows_by_producer ) == 0 )
					{
						$kuser->delete();
					}
				}
			}
			
			$entries = $hshow->getEntrys ();
			
			if ( $should_delete )
			{
				$id_list = array();
				foreach ( $entries as $entry )
				{
					$id_list[] = $entry->getId();
				}
				
				if ( $id_list )
				{
					$d = new Criteria();
					$d->add ( entryPeer::ID , $id_list , Criteria::IN );
					entryPeer::doDelete( $d );
				}
			}
			
			if ( $should_delete )
			{
				$hshow->delete();
			}
			
		}
		else
		{
			$error .= "Cannot find hshow [$hshow_id]<br>";
		}
		
		
		$this->hshow_id = $hshow_id;
		$this->kuser_name = $kuser_name;
		$this->hshow = $hshow;
		$this->kuser = $kuser;
		$this->entries = $entries; 	
		$this->should_delete = $should_delete;	

		$this->error = $error; 
	}
	
	private function getHshowsForKuser ( $kuser , $hshow )
	{
		
		$c = new Criteria();
		$c->add ( hshowPeer::PRODUCER_ID , $kuser->getId() );
		if ( $hshow ) $c->add ( kshowPeer::ID , $kshow->getId(), Criteria::NOT_EQUAL );
		$other_hshows_by_producer = hshowPeer::doSelect( $c );
		
		return $other_hshows_by_producer;
						
	}
}
?>