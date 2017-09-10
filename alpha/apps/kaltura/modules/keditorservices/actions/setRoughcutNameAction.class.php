<?php
/**
 * @package    Core
 * @subpackage kEditorServices
 */
require_once ( __DIR__ . "/defKeditorservicesAction.class.php");

/**
 * @package    Core
 * @subpackage kEditorServices
 */
class setRoughcutNameAction extends defKeditorservicesAction
{
	protected function executeImpl( hshow $hshow, entry &$entry )
	{
		$this->res = "";
		
		$likuser_id = $this->getLoggedInUserId();
		
		if ( $likuser_id != $entry->getKuserId())
		{
			// ERROR - attempting to update an entry which doesnt belong to the user
			return "<xml>!</xml>";//$this->securityViolation( $hshow->getId() );
		}
		
		$name = @$_GET["RoughcutName"];
		
		$entry->setName($name);
		$entry->save();
		
		//myEntryUtils::createWidgetImage($entry, false);
		
		$this->name = $name;
	}
}

?>