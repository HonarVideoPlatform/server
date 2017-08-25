<?php
/**
 * @package Core
 * @subpackage externalWidgets
 */
class getWidgetThumbnailAction extends sfAction
{
	/**
	 * Will forward to the the thumbnail of the hshows using the widget id
	 */
	public function execute()
	{
		$widget_id = $this->getRequestParameter( "wid" );
		$widget = widgetPeer::retrieveByPK( $widget_id );

		if ( !$widget )
		{
			die();	
		}
		
		// because of the routing rule - the entry_id & kmedia_type WILL exist. be sure to ignore them if smaller than 0
		$hshow_id= $widget->getHshowId();
		
		if ($hshow_id)
		{
			$hshow = hshowPeer::retrieveByPK($hshow_id);
			if ($hshow->getShowEntry())
				$this->redirect($hshow->getShowEntry()->getBigThumbnailUrl());
		}
	}
}
