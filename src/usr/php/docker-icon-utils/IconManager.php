<?php

class IconManager {
    private $iconDir = '/var/lib/docker/unraid/images/';

    /**
     * 构造函数
     */
    public function __construct() {
        // 确保图标目录存在
        if (!file_exists($this->iconDir)) {
            mkdir($this->iconDir, 0755, true);
        }
    }

    /**
     * 上传图标
     * @param array $file 上传的文件
     * @param string $containerName 容器名称
     * @return bool 是否成功
     */
    public function uploadIcon($file, $containerName) {
        if (!$this->validateIcon($file)) {
            return false;
        }

        $iconName = "{$containerName}-icon.png";
        $targetPath = $this->iconDir . $iconName;

        return move_uploaded_file($file['tmp_name'], $targetPath);
    }

    /**
     * 删除图标
     * @param string $containerName 容器名称
     * @return bool 是否成功
     */
    public function deleteIcon($containerName) {
        $iconPath = $this->getIconPath($containerName);
        if (file_exists($iconPath)) {
            return unlink($iconPath);
        }
        return false;
    }

    /**
     * 获取图标路径
     * @param string $containerName 容器名称
     * @return string 图标路径
     */
    public function getIconPath($containerName) {
        return $this->iconDir . "{$containerName}-icon.png";
    }

    /**
     * 验证图标文件
     * @param array $file 上传的文件
     * @return bool 是否有效
     */
    public function validateIcon($file) {
        // 检查文件类型
        $allowedTypes = ['image/png', 'image/jpeg', 'image/gif'];
        if (!in_array($file['type'], $allowedTypes)) {
            return false;
        }

        // 检查文件大小（限制为2MB）
        if ($file['size'] > 2 * 1024 * 1024) {
            return false;
        }

        // 检查文件是否为真实图片
        $imageInfo = getimagesize($file['tmp_name']);
        if (!$imageInfo) {
            return false;
        }

        return true;
    }

    /**
     * 获取所有图标
     * @return array 图标列表
     */
    public function getIcons() {
        $icons = [];
        $files = glob($this->iconDir . '*-icon.png');
        foreach ($files as $file) {
            $fileName = basename($file);
            $containerName = str_replace('-icon.png', '', $fileName);
            $icons[] = [
                'container' => $containerName,
                'path' => $file,
                'size' => filesize($file)
            ];
        }
        return $icons;
    }
}