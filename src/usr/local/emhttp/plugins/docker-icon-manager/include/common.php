<?php
// 包含工具类
require_once '/usr/php/docker-icon-utils/index.php';

// 确保必要的目录存在
Utils::ensureDirectory('/var/lib/docker/unraid/images/');
Utils::ensureDirectory('/boot/config/plugins/dockerMan/templates-user/');
Utils::ensureDirectory('/boot/config/plugins/docker-icon-manager/');
