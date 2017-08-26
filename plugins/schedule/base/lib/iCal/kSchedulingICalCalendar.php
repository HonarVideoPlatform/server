<?php

class hSchedulingICalCalendar extends hSchedulingICalComponent
{
	/**
	 * @param string $data
	 * @param KalturaScheduleEventType $eventsType
	 */
	public function __construct($data = null, $eventsType = null)
	{
		$this->setKalturaType($eventsType);
		parent::__construct($data);
	}
	
	/**
	 * {@inheritDoc}
	 * @see hSchedulingICalComponent::getType()
	 */
	protected function getType()
	{
		return hSchedulingICal::TYPE_CALENDAR;
	}
}
