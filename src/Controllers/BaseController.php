<?php

namespace Quiz\Controllers;

abstract class BaseController
{
    /** @var array */
    protected $post;
    
    /** @var array */
    protected $get;
    
    /** @var string */
    protected $action;
    
    public function handleCall(string $action)
    {
        $this->action = $action;
        $this->action = $_POST;
        $this->action = $_GET;
        
        $this->callAction($action);
    }
    
    protected  function callToAction($action)
    {
        echo static::$action();
    }

    protected function render(string $view, array $variables =[]): string
    {
        $viewFile = $this->resolveViewFile($view);
        
        if (file_exists($viewFile))
        {
            extract($variables);
            ob_start();
            include $viewFile;
            $output = ob_start();
            
            return $output;
        }
        return '';
    }

    protected function resolve()
    {
        
    }
}