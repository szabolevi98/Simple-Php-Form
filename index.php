<?php
require_once 'controller/FormController.php';
require_once 'model/FormHandler.php';

$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'form';

try {
    $formHandler = new FormHandler($host, $user, $pass, $dbname);
} catch (Exception $e) {
    exit('Error: ' . $e->getMessage());
}

$controller = new FormController($formHandler);
$controller->handleRequest();

require_once 'view/Form.php';
