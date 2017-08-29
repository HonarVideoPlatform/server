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
class createWidgetsAction extends kalturaSystemAction
{
	
	/**
	 * 
	 */
	public function execute()
	{
		$this->forceSystemAuthentication();
		
		$hshow_ids = $this->getP ( "hshow_ids") ;
		$partner_id = $this->getP ( "partner_id") ;
//		$subp_id = $this->getP ( "subp_id") ;
		$source_widget_id= $this->getP ( "source_widget_id" , 201 ) ;
		$submitted = $this->getP ( "submitted");
		$method = $this->getP ( "method" , "partner" );
		$create = $this->getP ( "create" );
		$limit = $this->getP ( "limit" , 20 );
		if ( $limit > 300 ) $limit = 300;
		
		$this->hshow_ids = $hshow_ids;
		$this->partner_id = $partner_id;
//		$this->subp_id = $subp_id;
		$this->source_widget_id = $source_widget_id;
		$this->method = $method;
		$this->create = $create;
		$this->limit = $limit;
		
		$errors = array( );
		$res = array();
		$this->errors = $errors;
		
		if ( $submitted )
		{
			// fetch all hshows that don't have widgets
			$c = new Criteria();
			$c->setLimit ( $limit );
			if ( $method == "list" )
			{
				$c->add ( hshowPeer::ID , @explode ( "," , $hshow_ids ) , Criteria::IN );				
			}
			else
			{
				$c->add ( hshowPeer::PARTNER_ID , $partner_id );
				if ( $create )
				{
					// because we want to create - select those hshows that are not marked as "have widgets"
					$c->add ( hshowPeer::INDEXED_CUSTOM_DATA_3 , NULL , Criteria::EQUAL );
				}
			}
			$c->addAscendingOrderByColumn( hshowPeer::CREATED_AT );
			// start at a specific int_id
			// TODO
			$hshows = hshowPeer::doSelect( $c );
			$hshow_id_list = $this->getIdList ( $hshows , $partner_id , $errors );
			
			$fixed_hshows = array();
			
//			$res [] = print_r ( $hshow_id_list ,true );
			$this->res = $res;			//return;
			$this->errors = $errors;
			
			if ( $hshow_id_list )
			{
			//	$hshow_id_list_copy = array_  $hshow_id_list ;
				$widget_c = new Criteria();
				$widget_c->add ( widgetPeer::PARTNER_ID , $partner_id );
				$widget_c->add ( widgetPeer::HSHOW_ID , $hshow_id_list , Criteria::IN );
				$widgets = widgetPeer::doSelect( $widget_c );
				
				// - IMPORTANT - add the hshow->setIndexedCustomData3 ( $widget_id ) for wikis

				
				foreach ( $widgets as $widget )
				{
					$hshow_id = $widget->getHshowId();
					if ( in_array ( $hshow_id, $fixed_hshows ) ) continue;
					// mark the hshow as one that has a widget
					$hshow = $this->getHshow ( $hshows , $hshow_id );
					$hshow->setIndexedCustomData3( $widget->getId());
					$hshow->save();
					unset ( $hshow_id_list[$hshow_id]);
					$fixed_hshows[$hshow_id]=$hshow_id;
//					print_r ( $hshow_id_list );
				}

			// create widgets for those who are still on the list === don't have a widget				
				foreach ( $hshow_id_list as $hshow_id )
				{
					if ( in_array ( $hshow_id, $fixed_hshows ) ) continue;
					$hshow = $this->getHshow ( $hshows , $hshow_id );
					$widget = widget::createWidget( $hshow , null , $source_widget_id ,null);
					$hshow->setIndexedCustomData3( $widget->getId());
					$hshow->save();
					$fixed_hshows[$hshow_id]=$hshow_id;
				}
			
			}
			
					
			// create a log file of the kaltura-widget tagss for wiki
			$partner = PartnerPeer::retrieveByPK( $partner_id );
			if  ( $partner )
			{
				$secret = $partner->getSecret ();	
				foreach ( $hshows as $hshow )
				{
					$hshow_id = $hshow->getId();
					$article_name = "Video $hshow_id";
					$widget_id = $hshow->getIndexedCustomData3(); // by now this hshow should have the widget id 
					$subp_id = $hshow->getSubpId();
					$md5 = md5 ( $hshow_id  . $partner_id  .$subp_id . $article_name . $widget_id .  $secret );
					$hash = substr ( $md5 , 1 , 10 );
					$values = array ( $hshow_id , $partner_id , $subp_id , $article_name ,$widget_id , $hash);
					
					$str = implode ( "|" , $values);
					$base64_str = base64_encode( $str );
					
					$res [] = "kalturaid='$hshow_id'	kwid='$base64_str'	'$str'\n";
				}
			}
		}
		
		$this->res = $res;
	}
	
	
	private function getIdList ( $objs , $partner_id , &$errors )
	{
		if ( is_array ( $objs  ))
		{
			$id = array();
			foreach ( $objs as $obj )
			{
				if ( $partner_id == $obj->getPartnerId() )
				{
					$id[] = $obj->getId();
				}
				else
				{
					$errors[] = $obj->getId() . " is of partner " . $obj->getPartnerId() . " instead of $partner_id";
				}
			}
			return $id;
		}
		return null;
	}
	
	private function getHshow ( $hshows , $hshow_id )
	{
		foreach ( $hshows as $hshow )
		{
			if( $hshow_id == $hshow->getId() ) return $hshow;
		}
		return null;
	}
}

 
?>
