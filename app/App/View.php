<?php

namespace Rscharitas\MVCPCARE\App;

class View {
    
    protected $viewPath;
    protected $template;
    protected $data;
    protected $sections;

    public function __construct($viewPath, $template = 'template', $data = [])
    {
        $this->viewPath = $viewPath;
        $this->template = $template;
        $this->data = $data;
        $this->sections = [];
    }

    public function render($view, $data = [])
    {
        $viewFile = $this->viewPath . '/' . $view . '.php';
        $templateFile = $this->viewPath . '/' . $this->template . '.php';

        if (!file_exists($viewFile)) {
            throw new \Exception("View file '{$view}.php' not found.");
        }

        if (!file_exists($templateFile)) {
            throw new \Exception("Template file '{$this->template}.php' not found.");
        }

        $this->data = array_merge($this->data, $data);
        $this->captureSections($viewFile);

        extract($this->data);
        include $templateFile;
    }

    protected function captureSections($viewFile)
    {
        $this->sections = [];

        ob_start();
        include $viewFile;
        $content = ob_get_clean();

        $pattern = '/@section\((\'|\")(.+?)(\'|\")\)(.*?)@endsection/s';
        preg_match_all($pattern, $content, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            $sectionName = $match[2];
            $sectionContent = trim($match[4]);
            $this->sections[$sectionName] = $sectionContent;
        }
    }

    public function yieldSection($sectionName, $default = '')
    {
        return isset($this->sections[$sectionName]) ? $this->sections[$sectionName] : $default;
    }
}

