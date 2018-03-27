<?php

namespace Afip\Planning\Connectivity;

class PDOConnect
{
    /*
 __      __           _         _      _
 \ \    / /          (_)       | |    | |
  \ \  / /__ _  _ __  _   __ _ | |__  | |  ___  ___
   \ \/ // _` || '__|| | / _` || '_ \ | | / _ \/ __|
    \  /| (_| || |   | || (_| || |_) || ||  __/\__ \
     \/  \__,_||_|   |_| \__,_||_.__/ |_| \___||___/

     */

    /** @var \PDO */
    private static $pdo;

    private static $firstCall = true;

    private static $dbName   = '';
    private static $host     = '';
    private static $port     = '3306';
    private static $username = '';
    private static $password = '';
    private static $options  = [
        \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
    ];

    /*
  __  __        _    _                 _
 |  \/  |  ___ | |_ | |__    ___    __| | ___
 | |\/| | / _ \| __|| '_ \  / _ \  / _` |/ __|
 | |  | ||  __/| |_ | | | || (_) || (_| |\__ \
 |_|  |_| \___| \__||_| |_| \___/  \__,_||___/

     */

    /**
     * @param array $params
     *
     * @throws \LogicException
     */
    private static function setPdoParameters(array $params)
    {
        if (
            !\array_key_exists('dbName', $params)
            ||
            !\array_key_exists('host', $params)
            ||
            !\array_key_exists('username', $params)
            ||
            !\array_key_exists('password', $params)
        ) {
            throw new \LogicException(
                "parameters MUST BE an array with at least keys('dbName', 'host', 'username', 'password')"
                ." and optionals keys('port', 'options')"
            );
        }

        self::$dbName   = $params['dbName']   ?? self::$dbName;
        self::$host     = $params['host']     ?? self::$host;
        self::$username = $params['username'] ?? self::$username;
        self::$password = $params['password'] ?? self::$password;
        self::$port     = $params['port']     ?? self::$port;
        self::$options  = $params['options']  ?? self::$options;

        self::init();
    }

    private static function init()
    {
        self::$pdo = new \PDO(
            'mysql:dbname='.self::$dbName.';host='.self::$host.';port='.self::$port,
            self::$username,
            self::$password,
            self::$options
        );
    }

    /**
     * @return \PDO
     * @throws \LogicException
     */
    public static function getConnection(): \PDO
    {
        if (self::$firstCall) {
            self::setPdoParameters(
                [
                    'dbName' => getenv('DB_NAME'),
                    'host' => getenv('DB_HOST'),
                    'port' => getenv('DB_PORT'),
                    'username' => getenv('DB_USERNAME'),
                    'password' => getenv('DB_PASSWORD'),
                ]
            );
            self::$firstCall = false;
        }
        if ((bool) self::$pdo) {
            if (!self::ping()) {
                self::init();
            }
        }

        return self::$pdo;
    }

    /**
     * @return bool
     */
    private static function ping(): bool
    {
        $pdo = self::$pdo;
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $oldErrorLevel = \error_reporting(0);
        try {
            $pdo->query('SELECT 1');
            $pingSuccess = true;
        } catch (\PDOException $e) {
            $pingSuccess = false;
        }
        \error_reporting($oldErrorLevel);

        return $pingSuccess;
    }

    /*
  __  __                _           __  __        _    _                 _
 |  \/  |  __ _   __ _ (_)  ___    |  \/  |  ___ | |_ | |__    ___    __| | ___
 | |\/| | / _` | / _` || | / __|   | |\/| | / _ \| __|| '_ \  / _ \  / _` |/ __|
 | |  | || (_| || (_| || || (__    | |  | ||  __/| |_ | | | || (_) || (_| |\__ \
 |_|  |_| \__,_| \__, ||_| \___|   |_|  |_| \___| \__||_| |_| \___/  \__,_||___/
                 |___/
     */

    /**
     * @return string
     */
    public function __toString()
    {
        return 'This Object is :'.self::class.". It have an static method 'getConnection(?array \$params)";
    }

    /**
     * @return array
     */
    public function __debugInfo()
    {
        return [
            \PDO::class => self::$pdo,
            'dbName' => self::$dbName,
            'host' => self::$host,
        ];
    }

    public function __destruct()
    {
        self::$pdo = null;
    }
}
