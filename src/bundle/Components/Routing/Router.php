<?php

namespace Afip\Planning\Components\Routing;


class Router
{
    /*
 __      __           _         _      _
 \ \    / /          (_)       | |    | |
  \ \  / /__ _  _ __  _   __ _ | |__  | |  ___  ___
   \ \/ // _` || '__|| | / _` || '_ \ | | / _ \/ __|
    \  /| (_| || |   | || (_| || |_) || ||  __/\__ \
     \/  \__,_||_|   |_| \__,_||_.__/ |_| \___||___/

     */

    /** @var Route[] */
    private $routes = [];

    /** @var Route[] */
    private $errorListener = [];

    /*
   ____        _    _                         __   ____         _    _
  / ___|  ___ | |_ | |_  ___  _ __  ___      / /  / ___|   ___ | |_ | |_  ___  _ __  ___
 | |  _  / _ \| __|| __|/ _ \| '__|/ __|    / /   \___ \  / _ \| __|| __|/ _ \| '__|/ __|
 | |_| ||  __/| |_ | |_|  __/| |   \__ \   / /     ___) ||  __/| |_ | |_|  __/| |   \__ \
  \____| \___| \__| \__|\___||_|   |___/  /_/     |____/  \___| \__| \__|\___||_|   |___/

    */

    /**
     * @return Route[]
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }

    /**
     * @param Route[] $routes
     * @return Router
     */
    public function setRoutes(array $routes): Router
    {
        $this->routes = $routes;
        return $this;
    }

    /**
     * @return Route[]
     */
    public function getErrorListener(): array
    {
        return $this->errorListener;
    }

    /**
     * @param Route[] $errorListener
     * @return Router
     */
    public function setErrorListener(array $errorListener): Router
    {
        $this->errorListener = $errorListener;
        return $this;
    }

    /*
   ____                    _                       _
  / ___| ___   _ __   ___ | |_  _ __  _   _   ___ | |_  ___   _ __  ___
 | |    / _ \ | '_ \ / __|| __|| '__|| | | | / __|| __|/ _ \ | '__|/ __|
 | |___| (_) || | | |\__ \| |_ | |   | |_| || (__ | |_| (_) || |   \__ \
  \____|\___/ |_| |_||___/ \__||_|    \__,_| \___| \__|\___/ |_|   |___/

     */

    public function __construct()
    {
        ob_start();
    }

    /*
  __  __        _    _                 _
 |  \/  |  ___ | |_ | |__    ___    __| | ___
 | |\/| | / _ \| __|| '_ \  / _ \  / _` |/ __|
 | |  | ||  __/| |_ | | | || (_) || (_| |\__ \
 |_|  |_| \___| \__||_| |_| \___/  \__,_||___/

     */

    /**
     * @param string $withMethod
     * @param string $matchRegex
     * @param callable $callback
     *
     * @return Router
     */
    public function addRoute
    (
        string $withMethod,
        string $matchRegex,
        callable $callback
    )
    : self
    {
        $this->routes[] = new Route($withMethod, $matchRegex, $callback, $this);

        return $this;
    }

    /**
     * @return string
     */
    public function getCurrentUri(): string
    {
        return $_SERVER['REQUEST_URI'];
    }

    /**
     * @return string
     */
    public function getCurrentMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * @return string
     */
    public function getCurrentProtocol(): string
    {
        return $_SERVER['SERVER_PROTOCOL'];
    }

    /**
     * @return mixed
     */
    public function listen()
    {
        $method = $this->getCurrentMethod();
        $uri    = $this->getCurrentUri();

        foreach ($this->routes as $route) {
            if ($route->isMatching($method, $uri)) {

                return $route->call($uri);
            }
        }

        $this->dispatchErrorEvent(404);
    }

    /**
     * @param int $code
     *
     * @return mixed
     */
    public function dispatchErrorEvent(int $code)
    {
        foreach ($this->errorListener as $errorCode => $route) {
            if ($code === $errorCode) {

                $route->call($code);
            }
        }

        if ($code === 404) {

            $this->notFoundDefault();
        }
    }

    public function redirect($uri)
    {
        header('Location: '.$uri);
    }

    /**
     *
     */
    public function notFoundDefault()
    {
        \header($this->getCurrentProtocol().' 404 Not Found');

        echo '404 Not Found';
    }

    /*
  __  __                _           __  __        _    _                 _      
 |  \/  |  __ _   __ _ (_)  ___    |  \/  |  ___ | |_ | |__    ___    __| | ___ 
 | |\/| | / _` | / _` || | / __|   | |\/| | / _ \| __|| '_ \  / _ \  / _` |/ __|
 | |  | || (_| || (_| || || (__    | |  | ||  __/| |_ | | | || (_) || (_| |\__ \
 |_|  |_| \__,_| \__, ||_| \___|   |_|  |_| \___| \__||_| |_| \___/  \__,_||___/
                 |___/                                                          
     */

    public function __debugInfo()
    {
        return array_merge(
            $this->getRoutes(),
            $this->getErrorListener()
        );
    }

    public function __destruct()
    {
        ob_flush();
    }
}
