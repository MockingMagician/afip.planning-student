<?php

namespace Afip\Planning\App\Controllers;


use Afip\Planning\Components\Rendering\Renderer;
use Afip\Planning\Components\Routing\Router;
use Afip\Planning\Models\Room;
use Afip\Planning\Models\Student;
use Afip\Planning\Models\Teacher;

class IndexController
{
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
     * @return \Closure
     * @throws \LogicException
     */
    public static function view()
    {
        return function (Router $router) {
            $render = new Renderer();

            $teachersCount = Teacher::countAll();
            $roomsCount    = Room::countAll();
            $studentsCount = Student::countAll();

            $render->render(
                __DIR__ . '/../app/bundle/templates/bodies/index.php',
                [
                    'title' => 'Accueil',
                    'teachersCount' => $teachersCount,
                    'roomsCount' => $roomsCount,
                    'studentsCount' => $studentsCount,
                ]
            );
        };
    }
}
