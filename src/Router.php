<?php

namespace App;


class Router
{
    /**
     * @var string
     */
    private $viewPath;

    /**
     * @var AltoRouter
     */
    private $router;


    public $layouts = 'layouts/default';

    public function __construct(string $viewPath)
    {
        $this->viewPath = $viewPath;
        $this->router = new \AltoRouter();

    }

    public function get(string $url, string $view, ?string $name = null)
    {
        $this->router->map('GET', $url, $view, $name);

        return $this; // méthode FLUENT nous revoie la classe
    }

    public function post(string $url, string $view, ?string $name = null)
    {
        $this->router->map('POST', $url, $view, $name);

        return $this; // méthode FLUENT nous revoie la classe
    }

    public function match(string $url, string $view, ?string $name = null)
    {
        $this->router->map('POST|GET', $url, $view, $name);

        return $this; // méthode FLUENT nous revoie la classe
    }

    public function url(string $name, array $params= [])
    {
        return $this->router->generate($name, $params);
    }

    public function run()
    {
        // initialisation des variables envoyés a l vue
        $match = $this->router->match();
        $view = $match['target'];
        $params = $match['params'];
        $router = $this;

        // generer le contenu envoyé a la vue
        ob_start();
        require $this->viewPath . DIRECTORY_SEPARATOR . $view . '.php';
        $content = ob_get_clean();
        
        
        
        require $this->viewPath . DIRECTORY_SEPARATOR . $this->layouts. '.php';
        return $this;
    }
}