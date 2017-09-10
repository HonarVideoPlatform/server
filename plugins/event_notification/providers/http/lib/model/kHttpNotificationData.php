<?php
/**
 * @package plugins.httpNotification
 * @subpackage model.data
 */
abstract class kHttpNotificationData
{
	/**
	 * Applies scope upon creation
	 * @param hScope $scope
	 */
	abstract public function setScope(hScope $scope);
}