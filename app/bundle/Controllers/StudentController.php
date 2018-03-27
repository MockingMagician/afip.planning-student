<?php

namespace Afip\Planning\App\Controllers;


use Afip\Planning\Components\Rendering\Renderer;
use Afip\Planning\Components\Routing\Router;

use Afip\Planning\Models\Nationality;
use Afip\Planning\Models\Student;
use Afip\Planning\Models\Traineeship;

class StudentController
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
    public static function list()
    {
        return function (Router $router, $id) {
            /** @var \Afip\Planning\Models\Student[] $students */
            $students = Student::getAll();

            foreach ($students as $student) {
                $student->nationality = Nationality::getById($student->getNationalityId())[0]->getLabel();
                $student->traineeship = Traineeship::getById($student->getTraineeshipId())[0]->getLabel();
            }

            $renderer = new Renderer();
            $renderer->render(
                __DIR__.'/../templates/bodies/list-students.php',
                [
                    'title' => 'Liste des étudiants',
                    'students' => $students,
                ]
            );
        };
    }

    /**
     * @return \Closure
     */
    public static function insert()
    {
        return function (Router $router, $id) {
            $student = Student::getById($id);


        };
    }

    /**
     * @return \Closure
     */
    public static function delete()
    {
        return function (Router $router, $id) {
            $student = \Afip\Planning\Models\Student::getById($id);


        };
    }

    /**
     * @return \Closure
     */
    public static function edit()
    {
        return function (Router $router, $id) {
            $student = \Afip\Planning\Models\Student::getById($id);


        };
    }
}
