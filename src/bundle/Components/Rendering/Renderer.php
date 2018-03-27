<?php

namespace Afip\Planning\Components\Rendering;


class Renderer
{
    /*
   ____                    _                       _
  / ___| ___   _ __   ___ | |_  _ __  _   _   ___ | |_  ___   _ __  ___
 | |    / _ \ | '_ \ / __|| __|| '__|| | | | / __|| __|/ _ \ | '__|/ __|
 | |___| (_) || | | |\__ \| |_ | |   | |_| || (__ | |_| (_) || |   \__ \
  \____|\___/ |_| |_||___/ \__||_|    \__,_| \___| \__|\___/ |_|   |___/

     */

    public function __construct()
    {
    }

    /*
  __  __        _    _                 _
 |  \/  |  ___ | |_ | |__    ___    __| | ___
 | |\/| | / _ \| __|| '_ \  / _ \  / _` |/ __|
 | |  | ||  __/| |_ | | | || (_) || (_| |\__ \
 |_|  |_| \___| \__||_| |_| \___/  \__,_||___/

     */

    /**
     * @param string $path
     * @param array $varsArray
     *
     * @throws \LogicException
     */
    public function render(string $path, array $varsArray): void
    {
        if (! $this->isReadable($path)) {
            throw new \LogicException("{$path} file is not readable or not exist");
        }

        echo $this->rending($path, $varsArray);
    }

    /**
     * @param string $path
     *
     * @return bool
     */
    private function isReadable(string $path): bool
    {
        return \is_readable($path);
    }

    /**
     * @param string $path
     * @param array $varsArray
     *
     * @return string
     */
    private function rending(string $path, array $varsArray): string
    {
        \ob_start();
        foreach ($varsArray as $varName => $value) {
            $$varName = $value;
        }
        require_once $path;

        return \ob_get_clean();
    }
}
