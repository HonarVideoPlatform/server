<?php
/**
 * @package plugins.contentDistribution 
 * @subpackage Scheduler.Distribute
 */
interface IDistributionEngine
{
	/**
	 * @param HSchedularTaskConfig $taskConfig
	 */
	public function configure();
	
	/**
	 * @param KalturaClient $kalturaClient
	 */
	public function setClient();
}
