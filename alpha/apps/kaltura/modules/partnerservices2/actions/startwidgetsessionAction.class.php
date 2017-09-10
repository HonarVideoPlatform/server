<?php
/**
 * @package api
 * @subpackage ps2
 */
require_once 'startsessionAction.class.php';

/**
 * @package api
 * @subpackage ps2
 */
class startwidgetsessionAction extends startsessionAction
{
	public function describe()
	{
		return
			array (
				"display_name" => "startWidgetSession",
				"desc" => "Starts new kaltura session for a specific widget id." ,
				"in" => array (
					"mandatory" => array (
						"widget_id" 		=> array ("type" => "string", "desc" => ""),
						),
					"optional" => array (
						"expiry" 		=> array ("type" => "integer", "default" => "86400", "desc" => ""),
						)
					),
				"out" => array (
					"hs" => array ("type" => "string", "desc" => ""),
					"partner_id" => array ("type" => "string", "desc" => ""),
					"subp_id" => array ("type" => "string", "desc" => ""),
					"uid" => array ("type" => "string", "desc" => "")
					),
				"errors" => array (
					APIErrors::START_WIDGET_SESSION_ERROR ,
				)
			);
	}

	protected function ticketType ()	{		return self::REQUIED_TICKET_NONE;	}

	protected function addUserOnDemand ( )	{		return self::CREATE_USER_FALSE;	}

	// we'll allow empty uid here - this is called from just any place in the web with now defined context
	protected function allowEmptyPuser()	{		return true;	}

	public function executeImpl ( $partner_id , $subp_id , $puser_id , $partner_prefix , $puser_kuser )
	{
		// make sure the secret fits the one in the partner's table
		$hs_str = "";
		$expiry = $this->getP ( "expiry" , 86400 );
		$widget_id = $this->getPM ( "widget_id" );

		$widget = widgetPeer::retrieveByPK( $widget_id );
		if ( !$widget )
		{
			$this->addError( APIErrors::INVALID_WIDGET_ID , $widget_id );
			return;
		}

		$partner_id = $widget->getPartnerId();

		$partner = PartnerPeer::retrieveByPK( $partner_id );
		// TODO - see how to decide if the partner has a URL to redirect to


		// according to the partner's policy and the widget's policy - define the privileges of the hs
		// TODO - decide !! - for now only view - any hshow
		$privileges = "view:*,widget:1";

		if ( $widget->getSecurityType() == widget::WIDGET_SECURITY_TYPE_FORCE_HS )
		{
			
			if ( ! $this->hs )// the one from the defPartnerservices2Action
				$this->addException( APIErrors::MISSING_HS );

			$hs_str = $this->getP ( "hs" );
			$widget_partner_id = $widget->getPartnerId();
			$res = hSessionUtils::validateHSession2 ( 1 ,$widget_partner_id  , $puser_id , $hs_str , $this->hs );
			
			if ( 0 >= $res )
			{
				// chaned this to be an exception rather than an error
				$this->addException ( APIErrors::INVALID_HS , $hs_str , $res , hs::getErrorStr( $res ));
			}			
		}
		else
		{
			// 	the session will be for NON admins and privileges of view only
			$puser_id = 0;
			$result = hSessionUtils::createHSessionNoValidations ( $partner_id , $puser_id , $hs_str , $expiry , false , "" , $privileges );
		}

		if ( $result >= 0 )
		{
			$this->addMsg ( "hs" , $hs_str );
			$this->addMsg ( "partner_id" , $partner_id );
			$this->addMsg ( "subp_id" , $widget->getSubpId() );
			$this->addMsg ( "uid" , "0" );
		}
		else
		{
			// TODO - see that there is a good error for when the invalid login count exceed s the max
			$this->addError( APIErrors::START_WIDGET_SESSION_ERROR ,$widget_id );
		}

	}
}
?>