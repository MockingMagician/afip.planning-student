<?php

namespace Afip\Planning\App\Controllers;

use Afip\Planning\Components\Messenger\Messenger;
use Afip\Planning\Components\Rendering\Renderer;
use Afip\Planning\Components\Routing\Router;
use Afip\Planning\Models\Room;
use Afip\Planning\Models\Teacher;
use Afip\Planning\Models\TeacherTraineeshipLabel;
use Afip\Planning\Models\Traineeship;
use Afip\Planning\Models\TraineeshipTeacher;

class TeacherController
{
    /**
     * @return Teacher[]
     */
    public static function getAllTeacherWithExtraData()
    {
        /** @var Teacher[] $teachers */
        $teachers = Teacher::getAll();

        foreach ($teachers as $teacher) {
            $rooms = Room::getById($teacher->getRoomId());
            $teacher->room = $rooms[0] ? $rooms[0]->getLabel() : '???';
            $teacher->traineeships = TeacherTraineeshipLabel::getByTeacherId($teacher->getId());
        }

        return $teachers;
    }

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
     *
     * @throws \ReflectionException
     * @throws \LogicException
     */
    public static function list()
    {
        return function (Router $router) {
            $teachers = TeacherController::getAllTeacherWithExtraData();

            Renderer::render(
                __DIR__.'/../templates/bodies/list-teachers.php',
                [
                    'title' => 'Liste des professeurs',
                    'teachers' => $teachers,
                ]
            );
        };
    }

    /**
     * @return \Closure
     *
     * @throws \ReflectionException
     * @throws \LogicException
     */
    public static function addView()
    {
        return function (Router $router) {
            $rooms = Room::getAll();
            $traineeships = Traineeship::getAll();

            Renderer::render(
                __DIR__.'/../templates/bodies/add-edit-teacher.php',
                [
                    'title' => 'Ajouter un professeur',
                    'rooms' => $rooms,
                    'traineeships' => $traineeships,
                ]
            );
        };
    }

    /**
     * @return \Closure
     *
     * @throws \ReflectionException
     * @throws \LogicException
     */
    public static function addAction()
    {
        return function (Router $router) {
            $posted = $_POST;

            $teacher = new Teacher($posted['teacher']);

            $teacher->flush();

            if (null !== $teacher->getId()) {
                foreach ($posted['TraineeshipTeacher'] as $ttId) {
                    $traineeshipTeacher = new TraineeshipTeacher();
                    $traineeshipTeacher->setTeacherId($teacher->getId());
                    $traineeshipTeacher->setTraineeshipId($ttId);
                    $traineeshipTeacher->flush();
                }
            }

            Messenger::addMessage('Professeur créé');

            $router->redirect('/');
        };
    }

    /**
     * @return \Closure
     *
     * @throws \ReflectionException
     * @throws \LogicException
     */
    public static function editView()
    {
        return function (Router $router, $id) {
            $teacher = Teacher::getById($id);

            if (false === (bool) \count($teacher)) {
                Messenger::addMessage('Professeur inexistant', Messenger::DANGER);

                return $router->redirect('/list/teachers');
            }

            $traineeshipsTeachers = TraineeshipTeacher::getByTeacherId($teacher[0]->getId());

            $rooms = Room::getAll();
            $traineeships = Traineeship::getAll();

            Renderer::render(
                __DIR__.'/../templates/bodies/add-edit-teacher.php',
                [
                    'title' => 'Ajouter un professeur',
                    'rooms' => $rooms,
                    'traineeships' => $traineeships,
                    'teacher' => $teacher[0],
                    'traineeshipsTeachers' => $traineeshipsTeachers,
                ]
            );
        };
    }

    /**
     * @return \Closure
     *
     * @throws \ReflectionException
     * @throws \LogicException
     */
    public static function editAction()
    {
        return function (Router $router, $id) {
            $posted = $_POST;

            $teacher = new Teacher($posted['teacher']);

            $teacher->setId($id);

            $teacher->flush();

            $traineeshipsTeachers = TraineeshipTeacher::getByTeacherId($teacher->getId());

            /** @var TraineeshipTeacher $tt */
            foreach ($traineeshipsTeachers as $tt) {
                $tt->delete();
            }

            if (null !== $teacher->getId()) {
                foreach ($posted['TraineeshipTeacher'] as $ttId) {
                    $traineeshipTeacher = new TraineeshipTeacher();
                    $traineeshipTeacher->setTeacherId($teacher->getId());
                    $traineeshipTeacher->setTraineeshipId($ttId);
                    $traineeshipTeacher->flush();
                }
            }

            Messenger::addMessage('Professeur modifié');

            $router->redirect('/list/teachers');
        };
    }
}
