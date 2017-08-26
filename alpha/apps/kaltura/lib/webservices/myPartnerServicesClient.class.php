<?php
require_once ( MODULES . "/partnerservices2/actions/startsessionAction.class.php" );
require_once ( MODULES . "/partnerservices2/actions/addhshowAction.class.php" );
class myPartnerServicesClient
{
	public static function createKalturaSession ( $uid, $privileges = null)
	{
		$kaltura_services = new startsessionAction();
		
		$params = array ( "format" => kalturaWebserviceRenderer::RESPONSE_TYPE_PHP_ARRAY , 
			"partner_id" => 0 , "subp_id" => 100 , "uid" => $uid , "secret" => "11111" );
		
		if ($privileges)
			$params["privileges"] = $privileges;
		
		$kaltura_services->setInputParams( $params );
		$result = $kaltura_services->internalExecute () ;
		return @$result["result"]["hs"];		
	}
	
	public static function createHshow ( $hs , $uid , $name , $partner_id = 0 , $subp_id = 100, $extra_params = null )
	{
		$kaltura_services = new addhshowAction();
		
		$params = array ( "format" => kalturaWebserviceRenderer::RESPONSE_TYPE_RAW , 
			"partner_id" => $partner_id , "subp_id" => $subp_id , "uid" => $uid , "hs" => $hs , "hshow_name" => $name ,
			"allow_duplicate_names" => "1" ) ;
		if ( $extra_params ) $params = array_merge( $params , $extra_params );
		
		$kaltura_services->setInputParams( $params );
		$result = $kaltura_services->internalExecute ( ) ;
		
		$hshow_wrapper = @$result["result"]["hshow"];
		
		if ( $hshow_wrapper )
		{
			$hshow = $hshow_wrapper->getWrappedObj();
			return 	$hshow	;
		}
		else
		{
			return null;
		}
	}
	

}
?>
