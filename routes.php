<?php
require_once 'controllers/AuthController.php';
require_once 'controllers/HomeController.php';
require_once 'controllers/DeviceController.php';
require_once 'controllers/ServisiController.php';

$page = $_GET['page'] ?? 'home';

switch ($page) {

    // Autentikacija
    case 'login':
        (new AuthController())->login();
        break;

    case 'register':
        (new AuthController())->register();
        break;

    case 'logout':
        (new AuthController())->logout();
        break;

    // Uređaji
    case 'uredjaji':
        (new DeviceController())->index();
        break;

    case 'dodaj-uredjaj':
        (new DeviceController())->create();
        break;

    // Servisi
    case 'prijavi-servis':
        (new ServisiController())->unos();
        break;

    case 'moji-servisi':
        (new ServisiController())->userList();
        break;

    case 'admin-servisi':
        (new ServisiController())->adminList();
        break;

    case 'izmeni-status':
        (new ServisiController())->updateStatus();
        break;

    // Statistika
    case 'statistika':
        (new ServisiController())->statistika();
        break;

    // Po defaultu otvori početnu
    default:
        (new HomeController())->index();
        break;
}
