<?php

class EasebuzzController {

    protected $modelName = 'DonateModel';

    public function index() {
        header('HTTP/1.1 404 Not Found');
        echo "Webhook Not Found";
    }

    public function create() {
        error_log("Easebuzz");
        error_log(print_r($_REQUEST, true));
        $inputJSON = file_get_contents('php://input');
        $rawInput = json_decode($inputJSON, true);
        error_log(print_r($rawInput, true));
    }

}

$controller = new EasebuzzController();

// Routing
$action = $_GET['action'] ?? '';
switch ($action) {
    case 'create':
        $controller->create();
        break;
    default:
        $controller->index();
        break;
}
