<?php

//querys select all <resource>
$select_all_devices = ;

$select_all_services = ;

$select_all_actions = ;

$select_all_slave_controllers = ;

$select_all_state_variables = ;

$select_all_resources = ;


//querys select by id
$select_device_by_id = ;

$select_service_by_id = ;

$select_action_by_id = ;

$select_slave_controller_by_id = ;

$select_state_variable_by_id = ;

$select_resource_by_id = ;


//querys select associeted resource
$select_device__services = ;

$select_service_actions = ;

$select_service_state_variables = ;

$device_querys = array("all" => $select_all_devices, "by-id" => $select_device_by_id, 
					   "services" => $select_device_services);



$querys = array("device" => $device_querys());