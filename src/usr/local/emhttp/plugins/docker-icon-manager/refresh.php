<?php
require_once '/usr/php/docker-icon-utils/index.php';

$containerManager = new ContainerManager();
$containers = $containerManager->getContainers();

Utils::jsonResponse([
    'success' => true,
    'containers' => $containers
]);
