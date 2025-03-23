<?php
/**
 * Example usage of the Database class
 * and its descendants
 */

include_once(__DIR__ . '/../../system/classes/Database.php');

$db = new MySQL();

$db->setHost('localhost');
$db->setDatabase('siteweb');
$db->setUsername('root');
$db->setPassword('root');
$db->setPort(3306);

// var_dump($db->connect());
print_r($db->connect());
