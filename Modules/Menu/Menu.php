<?php

namespace Modules\Menu;

use Illuminate\Config\Repository;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class Menu {

    /**
     * @var Repository
     */
    protected $config;

    /**
     * @var Router
     */
    protected $routes;

    /**
     * @param Repository $config
     * @param Router     $routes
     */
    public function __construct (Repository $config, Router $routes)
    {
        $this->config = $config;
        $this->routes = $routes;
    }

    public function make ()
    {
        $menu = collect($this->loadConfig());

        return $menu->sortBy('order')->map(fn ($item) => $this->item($item))->all();
    }

    protected function item ($item)
    {
        $collection = collect();

        $collection['url']   = $this->dispatch($item);
        $collection['title'] = $item['text'] ?? NULL;
        $collection['icon']  = $item['icon'] ?? NULL;
        $collection['order'] = $item['order'] ?? 0;

        if ( isset($item['children']) ) {
            $collection['children'] = collect($item['children'])->map(fn ($child) => $this->item($child))->all();
        }

        return $collection->filter()->sortKeys()->all();
    }

    protected function dispatch ($item)
    {
        if ( isset($item['route']) ) {
            $route = $item['route'];
            if ( is_array($route) ) {
                return route($route[0], $route[1]);
            }

            return route($route);
        }
        if ( isset($item['url']) ) {
            return url($item['url']);
        }
        if ( isset($item['action']) ) {
            return action($item['action']);
        }

        return NULL;
    }

    protected function loadConfig ()
    {
        return $this->config->get('menu.navbar');
    }

    public function compileRoutes ()
    {
        $modules = $this->config->get('menu.only_paths.modules');
        $methods = $this->config->get('menu.only_paths.methods');

        $collection = [];

        foreach ( $this->routes->getRoutes() as $route ) {

            /** @var Route $route */

            $module = Arr::first(explode('/', $route->uri()));
            $method = $route->getActionMethod();

            if ( in_array($module, $modules) && in_array($method, $methods) ) {

                $name = $route->getName() ?? Str::of($route->getPrefix())->append("/{$method}")->trim('/')->replace('/', '.')->__toString();

                $collection[$name] = [
                    'uri'    => $route->uri(),
                    'action' => $route->getActionName(),
                    'method' => $route->getActionMethod(),
                    'params' => $route->parameterNames(),
                ];
            }
        }

        dump($collection, data_get($collection, 'assignments.*'), Arr::undot($collection));
    }

}