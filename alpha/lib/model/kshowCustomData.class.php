<?php

/**
 * TODO - think of how's best to work with these classes - $attach_policy and stuff !
 * 
 * @package Core
 * @subpackage model
 */
abstract class hshowCustomData extends myBaseObject
{
	//const HSHOW_CUSTOM_DATA_FIELD = "custom_data";

	protected $m_hshow = NULL;

	// when this ctor is called - if the hshow is not NULL, initialize from it
	public function __construct( hshow $hshow = NULL , $attach_policy = NULL )
	{
		if ( $hshow != NULL )
		{
			$this->m_hshow = $hshow;
			$this->deserializeFromString( $this->getCustomData());
		}

	}

	protected function attachToHshow ( hshow $hshow , $attach_policy )
	{
		$this->m_hshow = $hshow;
		$this->deserializeFromString( $this->getCustomData());
		
	}


	protected function updateHshow ()
	{
		$this->setCustomeData ( $this->serializeToString() );
	}

	private  function getCustomData ()
	{
		return $this->m_hshow->getCustomData();
	}

	private function setCustomData ( $value )
	{
		return $this->m_hshow->setCustomData( $value );
	}

}
?>
