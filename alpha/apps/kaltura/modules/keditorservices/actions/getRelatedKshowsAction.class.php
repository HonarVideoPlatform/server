<?php
/**
 * @package    Core
 * @subpackage kEditorServices
 */
class getRelatedHshowsAction extends kalturaAction
{
	public function execute ( )
	{ 		
		$hshow_id = $this->getRequestParameter( 'hshow_id' , '');
		$this->hshowdataarray = myHshowUtils::getRelatedShowsData( $hshow_id, null, 12 );
		$this->getResponse()->setHttpHeader ( "Content-Type" , "text/xml; charset=utf-8" );
		$this->getController()->setRenderMode ( sfView::RENDER_CLIENT );
	}
}

