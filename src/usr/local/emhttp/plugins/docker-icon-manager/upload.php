<?php
require_once '/usr/php/docker-icon-utils/index.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['icon']) && isset($_POST['container'])) {
    $containerName = $_POST['container'];
    $iconFile = $_FILES['icon'];

    // 验证容器是否存在
    $containerManager = new ContainerManager();
    $containers = $containerManager->getContainers();
    $containerExists = false;
    foreach ($containers as $container) {
        if ($container['name'] === $containerName) {
            $containerExists = true;
            break;
        }
    }

    if (!$containerExists) {
        Utils::jsonResponse([
            'success' => false,
            'message' => 'Container not found'
        ], 404);
    }

    // 上传图标
    $iconManager = new IconManager();
    if (!$iconManager->validateIcon($iconFile)) {
        Utils::jsonResponse([
            'success' => false,
            'message' => 'Invalid icon file. Please upload a valid image file (PNG, JPEG, GIF) under 2MB.'
        ], 400);
    }

    if (!$iconManager->uploadIcon($iconFile, $containerName)) {
        Utils::jsonResponse([
            'success' => false,
            'message' => 'Failed to upload icon'
        ], 500);
    }

    // 创建或更新模板
    $templateManager = new TemplateManager();
    $repository = $containerManager->getContainerImage($containerName);
    if (!$templateManager->createTemplate($containerName, $repository)) {
        Utils::jsonResponse([
            'success' => false,
            'message' => 'Icon uploaded but failed to create template'
        ], 500);
    }

    Utils::jsonResponse([
        'success' => true,
        'message' => 'Icon uploaded successfully'
    ]);
} else {
    Utils::jsonResponse([
        'success' => false,
        'message' => 'Invalid request'
    ], 400);
}