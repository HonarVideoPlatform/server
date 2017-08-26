<?php
/**
 * Will run HScheduleHelper
 *
 * @package Scheduler
 */
require_once(__DIR__ . "/../bootstrap.php");

$instance = new HScheduleHelper();
$instance->run(); 
$instance->done();
