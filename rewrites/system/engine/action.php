<?php

class Action
{
    use App\Helper\WhichAppTrait;

    private $route;
    private $method = 'index';

    public function __construct($route)
    {
        $parts = explode('/', preg_replace('/[^a-zA-Z0-9_\/]/', '', (string)$route));

        // Break apart the route
        while ($parts) {
            $file = DIR_APPLICATION . 'controller/' . implode('/', $parts) . '.php';
            if (null !== \App\Helper\FileExiststRewriter::fileExists($file)) {
                $this->route = implode('/', $parts);
                break;
            } else {
                $this->method = array_pop($parts);
            }
        }
    }

    public function execute($registry, array $args = array())
    {
        // Stop any magical methods being called
        if (substr($this->method, 0, 2) == '__') {
            return new \Exception('Error: Calls to magic methods are not allowed!');
        }

        try {
            if (!$controller = $this->tryFindLocalOverrides($registry)) {
                $controller = $this->tryFindLocalRewrite($registry);
            }
            if (null === $controller) {
                $controller = $this->tryFindGlobal($registry);
            }

        } // Initialize the class
        catch (\Throwable $e) {
            throw new \Exception('Error: Could not call ' . $this->route . '/' . $this->method . '!');
        }

        $reflection = new \ReflectionClass($controller);

        if ($reflection->hasMethod($this->method) && $reflection->getMethod($this->method)->getNumberOfRequiredParameters() <= count($args)) {
            return call_user_func_array(array($controller, $this->method), $args);
        } else {
            return new \Exception('Error: Could not call ' . $this->route . '/' . $this->method . '!');
        }
    }

    protected function tryFindLocalOverrides(\Registry $registry)
    {
        $localClass = '\App\Overrides\Catalog';
        if ($this->isAdmin()) {
            $localClass = '\App\Overrides\Admin';
        }
        $localClass .= '\Controller/' . ucwords($this->route, "/");
        $localClass = str_replace("/", '\\', $localClass) . 'Controller';
        if (class_exists($localClass)) {
            return new $localClass($registry);
        }

        return null;
    }

    protected function tryFindLocalRewrite(\Registry $registry)
    {
        return $this->tryFind($registry, LOCAL_DIR_APPLICATION);
    }

    protected function tryFindGlobal(\Registry $registry)
    {
        return $this->tryFind($registry, DIR_APPLICATION);
    }

    protected function tryFind(\Registry $registry, string $directory)
    {
        $file = $directory . 'controller/' . $this->route . '.php';
        $class = 'Controller' . preg_replace('/[^a-zA-Z0-9]/', '', $this->route);
        if (is_file($file)) {
            include_once($file);

            return new $class($registry);
        }
        return null;
    }
}
