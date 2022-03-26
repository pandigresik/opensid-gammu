<?php
require 'vendor/autoload.php';
require_once 'config.php';
// Using Medoo namespace.
use Medoo\Medoo;
 
// Connect the database.
$database = new Medoo([
    'type' => 'mysql',
    'host' => HOST,
    'database' => DB,
    'username' => USERNAME,
    'password' => PASSWORD,
    'port' => PORT

]);
