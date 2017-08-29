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
class bandsAction extends kalturaSystemAction
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
	//	$this->forceSystemAuthentication();
		
		$from = $this->getRequestParameter( "from" , null );
		$to = $this->getRequestParameter( "to" , null );
		$limit = $this->getRequestParameter( "limit" , 100 );
		$c = new Criteria();
		$c->setLimit( $limit );
		$c->add ( hshowPeer::PARTNER_ID , 5 ); // myspace
		
		$c->addAscendingOrderByColumn( hshowPeer::ID );
		
		if ( !empty ( $from ) )
		{
			$c->addAnd( hshowPeer::ID , $from , Criteria::GREATER_EQUAL );
		}
		if ( ! empty ( $to ) )
		{
			$c->addAnd( hshowPeer::ID , $to , Criteria::LESS_EQUAL );
		}
		
		$this->band_list = hshowPeer::doSelectJoinkuser ( $c );
				
	}
}
?>
