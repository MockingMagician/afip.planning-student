<?php

namespace Afip\Planning\App\Controllers;


use Afip\Planning\Components\Rendering\Renderer;
use Afip\Planning\Components\Routing\Router;
use Afip\Planning\Models\Room;
use Afip\Planning\Models\Teacher;
use Afip\Planning\Models\TeacherTraineeshipLabel;

class TeacherController
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
     * @throws \ReflectionException
     * @throws \LogicException
     */
    public static function list()
    {
        return function (Router $router, $id) {
            /** @var Teacher[] $teachers */
            $teachers = Teacher::getAll();


            foreach ($teachers as $teacher) {
                $teacher->room = Room::getById($teacher->getRoomId())[0]->getLabel();
                $teacher->traineeships = TeacherTraineeshipLabel::getByTeacherId($teacher->getId());
            }

            $renderer = new Renderer();
            $renderer->render(
                __DIR__.'/../templates/bodies/list-teachers.php',
                [
                    'title' => 'Liste des professeurs',
                    'teachers' => $teachers,
                ]
            );
        };
    }
}
