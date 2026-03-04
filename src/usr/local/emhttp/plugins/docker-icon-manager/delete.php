<?php
require_once '/usr/php/docker-icon-utils/index.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['container'])) {
        Utils::jsonResponse([
            'success' => false,
            'message' => 'Container name is required'
        ], 400);
    }

    $containerName = $data['container'];

    // 删除图标
    $iconManager = new IconManager();
    if (!$iconManager->deleteIcon($containerName)) {
        Utils::jsonResponse([
            'success' => false,
            'message' => 'Failed to delete icon'
        ], 500);
    }

    // 删除模板
    $templateManager = new TemplateManager();
    $templateManager->deleteTemplate($containerName);

    Utils::jsonResponse([
        'success' => true,
        'message' => 'Icon deleted successfully'
    ]);
} else {
    Utils::jsonResponse([
        'success' => false,
        'message' => 'Invalid request'
    ], 400);
}