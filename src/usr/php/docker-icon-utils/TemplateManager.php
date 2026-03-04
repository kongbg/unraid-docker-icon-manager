<?php

class TemplateManager {
    private $templateDir = '/boot/config/plugins/dockerMan/templates-user/';

    /**
     * 构造函数
     */
    public function __construct() {
        // 确保模板目录存在
        if (!file_exists($this->templateDir)) {
            mkdir($this->templateDir, 0755, true);
        }
    }

    /**
     * 创建模板
     * @param string $containerName 容器名称
     * @param string $repository 镜像仓库
     * @return bool 是否成功
     */
    public function createTemplate($containerName, $repository) {
        $templatePath = $this->getTemplatePath($containerName);
        $xmlContent = $this->generateTemplateContent($containerName, $repository);
        return file_put_contents($templatePath, $xmlContent) !== false;
    }

    /**
     * 更新模板
     * @param string $containerName 容器名称
     * @return bool 是否成功
     */
    public function updateTemplate($containerName) {
        // 先获取容器的镜像信息
        $containerManager = new ContainerManager();
        $repository = $containerManager->getContainerImage($containerName);
        return $this->createTemplate($containerName, $repository);
    }

    /**
     * 获取模板路径
     * @param string $containerName 容器名称
     * @return string 模板路径
     */
    public function getTemplatePath($containerName) {
        return $this->templateDir . "my-{$containerName}.xml";
    }

    /**
     * 生成模板内容
     * @param string $containerName 容器名称
     * @param string $repository 镜像仓库
     * @return string 模板内容
     */
    private function generateTemplateContent($containerName, $repository) {
        return <<<XML
<?xml version="1.0"?>
<Container version="2">
  <Name>{$containerName}</Name>
  <Repository>{$repository}</Repository>
  <Registry/>
  <Network>bridge</Network>
  <MyIP/>
  <Shell>sh</Shell>
  <Privileged>false</Privileged>
  <Support/>
  <Project/>
  <Overview/>
  <Category/>
  <WebUI/>
  <TemplateURL/>
  <Icon/>
  <ExtraParams/>
  <PostArgs/>
  <CPUset/>
  <DonateText/>
  <DonateLink/>
  <Description/>
  <Environment/>
  <Labels/>
</Container>
XML;
    }

    /**
     * 检查模板是否存在
     * @param string $containerName 容器名称
     * @return bool 是否存在
     */
    public function templateExists($containerName) {
        return file_exists($this->getTemplatePath($containerName));
    }

    /**
     * 删除模板
     * @param string $containerName 容器名称
     * @return bool 是否成功
     */
    public function deleteTemplate($containerName) {
        $templatePath = $this->getTemplatePath($containerName);
        if (file_exists($templatePath)) {
            return unlink($templatePath);
        }
        return false;
    }

    /**
     * 获取所有模板
     * @return array 模板列表
     */
    public function getTemplates() {
        $templates = [];
        $files = glob($this->templateDir . 'my-*.xml');
        foreach ($files as $file) {
            $fileName = basename($file);
            $containerName = str_replace(['my-', '.xml'], '', $fileName);
            $templates[] = [
                'container' => $containerName,
                'path' => $file,
                'size' => filesize($file)
            ];
        }
        return $templates;
    }
}