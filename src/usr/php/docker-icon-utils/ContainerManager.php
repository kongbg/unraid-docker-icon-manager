<?php

class ContainerManager {
    /**
     * 获取所有 Docker 容器
     * @return array 容器列表
     */
    public function getContainers() {
        $containers = [];
        $output = shell_exec('docker ps -a --format "{{.Names}}|{{.Image}}|{{.Status}}"');
        if ($output) {
            $lines = explode("\n", trim($output));
            foreach ($lines as $line) {
                if (empty($line)) continue;
                list($name, $image, $status) = explode('|', $line);
                $containers[] = [
                    'name' => $name,
                    'image' => $image,
                    'status' => $status,
                    'has_icon' => $this->hasIcon($name)
                ];
            }
        }
        return $containers;
    }

    /**
     * 获取容器详细信息
     * @param string $name 容器名称
     * @return array 容器信息
     */
    public function getContainerInfo($name) {
        $output = shell_exec("docker inspect --format '{{json .}}' $name");
        if ($output) {
            return json_decode($output, true);
        }
        return [];
    }

    /**
     * 检查容器是否有图标
     * @param string $name 容器名称
     * @return bool 是否有图标
     */
    public function hasIcon($name) {
        $iconPath = "/var/lib/docker/unraid/images/{$name}-icon.png";
        return file_exists($iconPath);
    }

    /**
     * 获取容器的镜像名称
     * @param string $name 容器名称
     * @return string 镜像名称
     */
    public function getContainerImage($name) {
        $output = shell_exec("docker inspect --format '{{.Config.Image}}' $name");
        return trim($output);
    }
}