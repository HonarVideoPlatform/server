<?php
/**
 * @package plugins.scheduledTask
 * @subpackage Scheduler
 */
require_once(__DIR__ . "/../../../../batch/bootstrap.php");

$instance = new HScheduledTaskDryRunner();
$instance->run();
$instance->done();
