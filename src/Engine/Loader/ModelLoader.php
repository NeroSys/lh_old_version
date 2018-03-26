<?php

namespace App\Engine\Loader;


class ModelLoader
{
    use \App\Helper\WhichAppTrait;

    public function loadModel(string $route, \Registry $registry)
    {
        if(!$modelClass = $this->tryFindLocalOverrides($route)){
            $modelClass = $this->tryFindLocalRewrites($route);
        }
        if(!$modelClass) { $modelClass = $this->tryFindGlobal($route); }

        if(!$modelClass){
            throw new \Exception('Error: Could not load model ' . $route . '!');
        }
        //echo $class;
        $proxy = new \Proxy();

        foreach (get_class_methods($modelClass) as $method) {
            $proxy->{$method} = $this->callback($registry, $route . '/' . $method);
        }

        $registry->set('model_' . str_replace(array('/', '-', '.'), array('_', '', ''), (string)$route), $proxy);

        return $proxy;
    }

    protected function tryFindLocalOverrides(string $route)
    {
        $localClass = 'App\Overrides\Catalog';
        if ($this->isAdmin()) {
            $localClass = 'App\Overrides\Admin';
        }
        $localClass .= '\Model/' . ucwords($route, "/");
        $localClass = str_replace("/", '\\', $localClass) . 'Model';
        if (class_exists($localClass)) {
           return $localClass;
        }

        return null;
    }

    protected function tryFindLocalRewrites(string $route)
    {
        return $this->findRewritesAndOvverides($route, LOCAL_DIR_APPLICATION);
    }

    protected function tryFindGlobal(string $route)
    {
        return $this->findRewritesAndOvverides($route, DIR_APPLICATION);
    }


    protected function findRewritesAndOvverides(string $route, string $directory)
    {

        $route = preg_replace('/[^a-zA-Z0-9_\/]/', '', (string)$route);

        $file = $directory . 'model/' . $route . '.php';
        $class = 'Model' . preg_replace('/[^a-zA-Z0-9]/', '', $route);
        if(file_exists($file)) {
            include_once($file);
            return $class;
        }
        return null;
    }
    /**
     * @param string $model
     * @return Object created from model name or from registry
     */
    public function singleton($model)
    {
        $registry_key = 'model_' . str_replace('/', '_', $model);
        $already_existing_model = $this->registry->get($registry_key);
        if ($already_existing_model) {
            return $already_existing_model;
        }
        return $this->model($model);
    }

    protected function callback($registry, $route) {
        return function($args) use($registry, &$route) {
            // Trigger the pre events
            $result = $registry->get('event')->trigger('model/' . $route . '/before', array_merge(array(&$route), $args));

            if ($result) {
                return $result;
            }


            $methodNum = strrpos($route, '/');
            $tempRoute = substr($route, 0, $methodNum);
            if(!$modelClass = $this->tryFindLocalOverrides($tempRoute)){
                $modelClass = $this->tryFindLocalRewrites($tempRoute);
            }
            if(null === $modelClass && !$modelClass =  $this->tryFindGlobal($tempRoute) ) {
                throw new \Exception('Error: Could not load model ' . substr($route, 0, strrpos($route, '/')) . '!');
            }
            $model = new $modelClass($registry);
            $method = substr($route, strrpos($route, '/') + 1);

            if (method_exists($model, $method)) {
                $output = call_user_func_array(array($model, $method), $args);
            } else {
                throw new \Exception('Error: Could not call model/' . $route . '!');
            }

            // Trigger the post events
            $result = $registry->get('event')->trigger('model/' . $route . '/after', array_merge(array(&$route, &$output), $args));
            if ($result) {
                return $result;
            }

            return $output;
        };
    }
}