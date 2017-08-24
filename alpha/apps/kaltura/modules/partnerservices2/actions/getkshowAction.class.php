<?php
/**
 * @package api
 * @subpackage ps2
 */
class gethshowAction extends defPartnerservices2Action
{
	public function describe()
	{
		return 
			array (
				"display_name" => "getHShow",
				"desc" => "" ,
				"in" => array (
					"mandatory" => array ( 
						"hshow_id" => array ("type" => "string", "desc" => "")
						),
					"optional" => array (
						"detailed" => array ("type" => "boolean", "desc" => "")
						)
					),
				"out" => array (
					"hshow" => array ("type" => "hshow", "desc" => "")
					),
				"errors" => array (
					APIErrors::INVALID_HSHOW_ID ,
				)
			); 
	}

	// ask to fetch the kuser from puser_kuser 
	public function needKuserFromPuser ( )	
	{	
		$hshow_id = $this->getPM ( "hshow_id" );
		if ( $hshow_id == hshow::HSHOW_ID_USE_DEFAULT )			return parent::KUSER_DATA_KUSER_ID_ONLY ;
		return self::KUSER_DATA_NO_KUSER;	
	}
		
	public function executeImpl ( $partner_id , $subp_id , $puser_id , $partner_prefix , $puser_kuser )
	{
		$hshow_id = $this->getPM ( "hshow_id" );
		$detailed = $this->getP ( "detailed" , false );
		$hshow_indexedCustomData3 = $this->getP ( "indexedCustomData3" );
		$hshow = null;
        
		if ( $hshow_id == hshow::HSHOW_ID_USE_DEFAULT )
        {
// see if the partner has some default hshow to add to
            $hshow = myPartnerUtils::getDefaultHshow ( $partner_id, $subp_id , $puser_kuser );
if ( $hshow ) $hshow_id = $hshow->getId();
        }
		elseif ( $hshow_id )
		{
			$hshow = hshowPeer::retrieveByPK( $hshow_id );
		}
		elseif ( $hshow_indexedCustomData3 )
		{
			$hshow = hshowPeer::retrieveByIndexedCustomData3( $hshow_indexedCustomData3 );
		}

		if ( ! $hshow )
		{
			$this->addError ( APIErrors::INVALID_HSHOW_ID , $hshow_id );
		}
		else
		{
			$level = ( $detailed ? objectWrapperBase::DETAIL_LEVEL_DETAILED : objectWrapperBase::DETAIL_LEVEL_REGULAR );
			$wrapper = objectWrapperBase::getWrapperClass( $hshow , $level );
			// TODO - remove this code when cache works properly when saving objects (in their save method)
			$wrapper->removeFromCache( "hshow" , $hshow_id );
			$this->addMsg ( "hshow" , $wrapper ) ;
		}
	}
}
?>
