<?php
/**
 * @package plugins.captionSphinx
 * @subpackage lib
 */
class hSphinxCaptionAssetFlowManager implements kObjectDeletedEventConsumer
{
	/* (non-PHPdoc)
	 * @see kObjectDeletedEventConsumer::objectDeleted()
	 */
	public function shouldConsumeDeletedEvent(BaseObject $object)
	{
		if($object instanceof CaptionAssetItem)
			return true;
			
		return false;
	}
	
	/* (non-PHPdoc)
	 * @see kObjectDeletedEventConsumer::objectDeleted()
	 */
	public function objectDeleted(BaseObject $object, BatchJob $raisedJob = null)
	{
		$sphinxSearchManager = new hSphinxSearchManager();
		$sphinxSearchManager->deleteFromSphinx($object);
		
		return true;
	}
}
