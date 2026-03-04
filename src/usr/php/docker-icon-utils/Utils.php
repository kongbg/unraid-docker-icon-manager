<?php

class Utils {
    /**
     * 生成随机字符串
     * @param int $length 字符串长度
     * @return string 随机字符串
     */
    public static function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * 清理文件名
     * @param string $filename 文件名
     * @return string 清理后的文件名
     */
    public static function sanitizeFilename($filename) {
        return preg_replace('/[^a-zA-Z0-9_-]/', '_', $filename);
    }

    /**
     * 输出 JSON 响应
     * @param mixed $data 响应数据
     * @param int $status 状态码
     */
    public static function jsonResponse($data, $status = 200) {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    /**
     * 日志记录
     * @param string $message 日志消息
     * @param string $level 日志级别
     */
    public static function log($message, $level = 'info') {
        $logFile = '/var/log/docker-icon-manager.log';
        $timestamp = date('Y-m-d H:i:s');
        $logEntry = "[$timestamp] [$level] $message\n";
        file_put_contents($logFile, $logEntry, FILE_APPEND);
    }

    /**
     * 检查权限
     * @param string $path 路径
     * @param int $mode 权限模式
     * @return bool 是否有权限
     */
    public static function checkPermission($path, $mode) {
        return (fileperms($path) & $mode) == $mode;
    }

    /**
     * 确保目录存在
     * @param string $path 目录路径
     * @param int $mode 权限模式
     * @return bool 是否成功
     */
    public static function ensureDirectory($path, $mode = 0755) {
        if (!file_exists($path)) {
            return mkdir($path, $mode, true);
        }
        return true;
    }

    /**
     * 获取文件大小的人类可读格式
     * @param int $bytes 字节数
     * @return string 人类可读的大小
     */
    public static function humanFileSize($bytes, $decimals = 2) {
        $size = ['B', 'KB', 'MB', 'GB', 'TB'];
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f %s", $bytes / pow(1024, $factor), $size[$factor]);
    }
}