<?php

namespace Afip\Planning\Components\Messenger;

class Messenger
{
    /*
   ____                    _                 _
  / ___| ___   _ __   ___ | |_  __ _  _ __  | |_  ___
 | |    / _ \ | '_ \ / __|| __|/ _` || '_ \ | __|/ __|
 | |___| (_) || | | |\__ \| |_| (_| || | | || |_ \__ \
  \____|\___/ |_| |_||___/ \__|\__,_||_| |_| \__||___/

     */

    public const WARNING = 'warning';
    public const DANGER  = 'danger';
    public const SUCCESS = 'success';

    /*
   ____                    _                       _
  / ___| ___   _ __   ___ | |_  _ __  _   _   ___ | |_  ___   _ __  ___
 | |    / _ \ | '_ \ / __|| __|| '__|| | | | / __|| __|/ _ \ | '__|/ __|
 | |___| (_) || | | |\__ \| |_ | |   | |_| || (__ | |_| (_) || |   \__ \
  \____|\___/ |_| |_||___/ \__||_|    \__,_| \___| \__|\___/ |_|   |___/

     */

    private function __construct()
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
     * @param string $status
     * @param string $message
     */
    public static function addMessage(string $message, string $status = self::SUCCESS)
    {
        \session_start();
        $_SESSION['_messenger'][] = [$message, $status];
        \session_write_close();
    }

    /**
     * @return array
     */
    public static function getMessages(): array
    {
        \session_start();
        $messages = $_SESSION['_messenger'];
        unset($_SESSION['_messenger']);
        \session_write_close();

        return $messages ?? [];
    }
}
