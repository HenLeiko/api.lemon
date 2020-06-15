<?php
require 'controls.php';
header("Content-type: application/json");
$connection = mysqli_connect('localhost', 'root', '', 'lemon');

$request = $_SERVER['REQUEST_METHOD'];

$options = explode("/", $_GET['api']);
$function = $options[0];
$select = @$options[1];

switch ($request){
    case 'GET':
        getOptions($function, $select, $connection);
    break;
    case 'POST':
        postOptions($function, $select, $_POST, $connection);
    break;

}



