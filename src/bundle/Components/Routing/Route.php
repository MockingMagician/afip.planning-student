<?php

namespace Afip\Planning\Components\Routing;

class Route
{
    /*
 __      __           _         _      _
 \ \    / /          (_)       | |    | |
  \ \  / /__ _  _ __  _   __ _ | |__  | |  ___  ___
   \ \/ // _` || '__|| | / _` || '_ \ | | / _ \/ __|
    \  /| (_| || |   | || (_| || |_) || ||  __/\__ \
     \/  \__,_||_|   |_| \__,_||_.__/ |_| \___||___/

     */

    /** @var Router */
    private $router;

    /** @var string */
    private $method;

    /** @var string */
    private $regex;

    /** @var array */
    private $varNames;

    /** @var callable */
    private $callback;

    /*
   ____        _    _                         __   ____         _    _
  / ___|  ___ | |_ | |_  ___  _ __  ___      / /  / ___|   ___ | |_ | |_  ___  _ __  ___
 | |  _  / _ \| __|| __|/ _ \| '__|/ __|    / /   \___ \  / _ \| __|| __|/ _ \| '__|/ __|
 | |_| ||  __/| |_ | |_|  __/| |   \__ \   / /     ___) ||  __/| |_ | |_|  __/| |   \__ \
  \____| \___| \__| \__|\___||_|   |___/  /_/     |____/  \___| \__| \__|\___||_|   |___/

    */

    /**
     * @return Router
     */
    public function getRouter(): ?Router
    {
        return $this->router;
    }

    /**
     * @param Router $router
     * @return Route
     */
    public function setRouter(?Router $router): Route
    {
        $this->router = $router;
        return $this;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     * @return Route
     */
    public function setMethod(string $method): Route
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @return string
     */
    public function getRegex(): string
    {
        return $this->regex;
    }

    /**
     * @param string $regex
     * @return Route
     */
    public function setRegex(string $regex): Route
    {
        $this->regex = $regex;
        return $this;
    }

    /**
     * @return callable
     */
    public function getCallback(): callable
    {
        return $this->callback;
    }

    /**
     * @param callable $callback
     * @return Route
     */
    public function setCallback(callable $callback): Route
    {
        $this->callback = $callback;
        return $this;
    }

    /**
     * @return array
     */
    public function getVarNames(): array
    {
        return $this->varNames;
    }

    /**
     * @param array $varNames
     * @return Route
     */
    public function setVarNames(array $varNames): Route
    {
        $this->varNames = $varNames;
        return $this;
    }

    /*
   ____                    _                       _
  / ___| ___   _ __   ___ | |_  _ __  _   _   ___ | |_  ___   _ __  ___
 | |    / _ \ | '_ \ / __|| __|| '__|| | | | / __|| __|/ _ \ | '__|/ __|
 | |___| (_) || | | |\__ \| |_ | |   | |_| || (__ | |_| (_) || |   \__ \
  \____|\___/ |_| |_||___/ \__||_|    \__,_| \___| \__|\___/ |_|   |___/

     */

    public function __construct(string $method, string $uriLike, callable $callback, Router $router = null)
    {
        $this
            ->setMethod($method)
            ->uriParser($uriLike)
            ->setCallback($callback)
            ->setRouter($router)
        ;
    }

    /*
  __  __        _    _                 _
 |  \/  |  ___ | |_ | |__    ___    __| | ___
 | |\/| | / _ \| __|| '_ \  / _ \  / _` |/ __|
 | |  | ||  __/| |_ | | | || (_) || (_| |\__ \
 |_|  |_| \___| \__||_| |_| \___/  \__,_||___/

     */

    /**
     * @param $uriLike
     *
     * @return Route
     */
    private function uriParser($uriLike): self
    {
        preg_match_all('/{(.*?)}/', $uriLike, $matches);

        $this->setVarNames($matches[1]);

        $this->setRegex(preg_replace(
            '/\\\{.*?}/',
            '(.*?)',
            '/^'.preg_quote($uriLike, '/').'$/'
        ));

        return $this;
    }

    /**
     * @param string $method
     * @param string $uri
     *
     * @return bool
     */
    public function isMatching(string $method, string $uri): bool
    {
        return
            $this->method === $method
            &&
            (bool) preg_match($this->getRegex(), $uri);
    }

    /**
     * @param $uri
     *
     * @return mixed
     *
     * @throws \ReflectionException
     */
    public function call($uri)
    {
        preg_match(
            $this->getRegex(),
            $uri,
            $varsArray
        );

        $varsArray[0] = $this->getRouter();

        $reflection = new \ReflectionFunction($this->getCallback());
        $args  = $reflection->getParameters();

        while (\count($varsArray) < \count($args)) {
            $varsArray[] = null;

            trigger_error('Use of undefined variables should avoid');
        }

        return \call_user_func_array( $this->getCallback(), $varsArray);
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
        return [
            'method' => $this->getMethod(),
            'regex' => $this->getRegex(),
            'callback' => $this->getCallback(),
        ];
    }
}
