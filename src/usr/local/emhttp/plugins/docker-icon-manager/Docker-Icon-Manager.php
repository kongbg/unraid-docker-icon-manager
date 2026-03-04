<?php
require_once '/usr/local/emhttp/plugins/docker-icon-manager/include/common.php';

$action = $_GET['action'] ?? 'main';

switch ($action) {
    case 'settings':
        include '/usr/local/emhttp/plugins/docker-icon-manager/Docker-Icon-Manager-Settings.page';
        break;
    default:
        include '/usr/local/emhttp/plugins/docker-icon-manager/Docker-Icon-Manager.page';
        break;
}
