<?php

namespace Afip\Planning\App\Controllers;

use Afip\Planning\Components\Messenger\Messenger;
use Afip\Planning\Components\Rendering\Renderer;
use Afip\Planning\Components\Routing\Router;
use Afip\Planning\Models\Nationality;
use Afip\Planning\Models\Student;
use Afip\Planning\Models\StudentTeacher;
use Afip\Planning\Models\TeacherTraineeshipLabel;
use Afip\Planning\Models\Traineeship;

class StudentController
{
    private static function checkAddEditStudentPostedData()
    {
        try {
            $posted = $_POST;

            $student = new Student($posted['student']);

            foreach ($posted['studentTeacher'] as $k => $stt) {
                if (
                    ! isset($stt['teacherId'])
                    ||
                    0 >= $stt['teacherId'] = (int) $stt['teacherId']
                ) {
                    unset($posted['studentTeacher'][$k]);
                    continue;
                }

                $ttls = TeacherTraineeshipLabel::getByTeacherId($stt['teacherId']);

                $toUnset = true;

                /** @var TeacherTraineeshipLabel $ttl */
                foreach ($ttls as $ttl) {
                    if ($student->getTraineeshipId() === $ttl->getTraineeshipId()) {
                        $toUnset = false;
                    }
                }

                if ($toUnset) {
                    unset($posted['studentTeacher'][$k]);
                    continue;
                }
            }

            if (0 === \count($posted['studentTeacher'])) {
//                throw new \Exception("Data invalid");
            }
        } catch (\Exception | \PDOException $e) {
            return false;
        }

        return [
            $posted,
            $student,
        ];
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
     * @throws \LogicException
     */
    public static function list()
    {
        return function (Router $router, $id) {
            /** @var \Afip\Planning\Models\Student[] $students */
            $students = Student::getAll();

            foreach ($students as $student) {
                $nat = Nationality::getById($student->getNationalityId());
                $student->nationality = $nat[0] ? $nat[0]->getLabel() : '???';
                $student->traineeship = Traineeship::getById($student->getTraineeshipId())[0]->getLabel();
            }

            Renderer::render(
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
     *
     * @throws \LogicException
     */
    public static function addView()
    {
        return function (Router $router) {
            $nationalities = Nationality::getAll();
            $traineeships = Traineeship::getAll();
            $teachers = TeacherController::getAllTeacherWithExtraData();

            Renderer::render(
                __DIR__.'/../templates/bodies/add-edit-student.php',
                [
                    'title'         => 'Ajouter un étudiant',
                    'nationalities' => $nationalities,
                    'teachers'      => $teachers,
                    'traineeships'   => $traineeships,
                ]
            );
        };
    }

    /**
     * @return \Closure
     *
     * @throws \LogicException
     */
    public static function addAction()
    {
        return function (Router $router) {
            /*
             * Verify the data
             */
            $check = self::checkAddEditStudentPostedData();
            if (false === (bool) $check) {
                Messenger::addMessage('Data invalid', Messenger::DANGER);

                return $router->redirect('/add/student');
            }
            list($posted, $student) = $check;

            /*
             * Data is valid insert in DB
             */
            try {
                $student->flush();

                if (null === $student->getId()) {
                    throw new \Exception('Record of student as failed');
                }

                foreach ($posted['studentTeacher'] as $stt) {
                    $studentTeacher = new StudentTeacher();
                    $studentTeacher->setStudentId($student->getId());
                    $studentTeacher->setTeacherId((int) $stt['teacherId']);
                    $studentTeacher->setStartDate($stt['startDate']);
                    $studentTeacher->setEndDate($stt['endDate']);
                    $studentTeacher->flush();
                }
            } catch (\Exception | \PDOException $e) {
                Messenger::addMessage($e->getMessage(), Messenger::DANGER);

                return $router->redirect('/add/student');
            }

            Messenger::addMessage("Etudiant {$student->getLastName()} {$student->getFirstName()} ajouté");

            return $router->redirect('/');
        };
    }

    /**
     * @return \Closure
     *
     * @throws \LogicException
     */
    public static function delete()
    {
        return function (Router $router, $id) {
            /** @var Student[] $student */
            $student = Student::getById($id);

            if (0 < \count($student)) {
                $student[0]->delete();
            }

            Messenger::addMessage("Suppression de l'étudiant");

            $router->redirect('/list/students');
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
            $student = Student::getById($id);

            if (0 === \count($student)) {
                return $router->redirect('/list/students');
            }

            $nationalities = Nationality::getAll();
            $traineeships = Traineeship::getAll();
            $teachers = TeacherController::getAllTeacherWithExtraData();
            $studentsTeachers = StudentTeacher::getByStudentId($student[0]->getId());

            Renderer::render(
                __DIR__.'/../templates/bodies/add-edit-student.php',
                [
                    'title'            =>
                        'Modification de l\'étudiant : '.$student[0]->getLastName().' '.$student[0]->getFirstName(),
                    'nationalities'    => $nationalities,
                    'teachers'         => $teachers,
                    'traineeships'     => $traineeships,
                    'student'          => $student[0],
                    'studentsTeachers' => $studentsTeachers,
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
            /*
             * Verify the data
             */
            $check = self::checkAddEditStudentPostedData();
            if (false === (bool) $check) {
                Messenger::addMessage('Données invalides', Messenger::DANGER);

                return $router->redirect($router->getCurrentUri());
            }
            /**
             * @var array   $posted
             * @var Student $student
             */
            list($posted, $student) = $check;

            $student->setId((int) $id);

            /*
             * Data is valid insert in DB
             */
            try {
                $studentsTeachers = StudentTeacher::getByStudentId($id);
                /** @var StudentTeacher $studentTeacher */
                foreach ($studentsTeachers as $studentTeacher) {
                    $studentTeacher->delete();
                }

                $student->flush();

                if (null === $student->getId()) {
                    throw new \Exception('Record of student as failed');
                }

                foreach ($posted['studentTeacher'] as $stt) {
                    $studentTeacher = new StudentTeacher();
                    $studentTeacher->setStudentId($student->getId());
                    $studentTeacher->setTeacherId((int) $stt['teacherId']);
                    $studentTeacher->setStartDate($stt['startDate']);
                    $studentTeacher->setEndDate($stt['endDate']);
                    $studentTeacher->flush();
                }
            } catch (\Exception | \PDOException $e) {
                Messenger::addMessage($e->getMessage(), Messenger::DANGER);

                return $router->redirect($router->getCurrentUri());
            }

            Messenger::addMessage("Etudiant {$student->getLastName()} {$student->getFirstName()} modifié");

            return $router->redirect('/list/students');
        };
    }

    /**
     * @return \Closure
     *
     * @throws \ReflectionException
     * @throws \LogicException
     */
    public static function editAllView()
    {
        return function (Router $router) {
            $students = Student::getAll();

            if (0 === \count($students)) {
                Messenger::addMessage('Aucun utilisateur à modifier', Messenger::WARNING);

                return $router->redirect('/');
            }

            $nationalities = Nationality::getAll();
            $traineeships = Traineeship::getAll();
            $teachers = TeacherController::getAllTeacherWithExtraData();

            foreach ($students as $student) {
                $student->studentsTeachers = StudentTeacher::getByStudentId($student->getId());
            }

            Renderer::render(
                __DIR__.'/../templates/bodies/edit-all-students.php',
                [
                    'title'            => 'Modification des étudiants',
                    'nationalities'    => $nationalities,
                    'teachers'         => $teachers,
                    'traineeships'     => $traineeships,
                    'students'         => $students,
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
    public static function editAllAction()
    {
        return function (Router $router) {
            $posted = $_POST;
            $postedStack  = [];
            $studentStack = [];

            foreach ($posted['student'] as $k => $v) {
                $_POST = [
                    'student'        => $posted['student'][$k],
                    'studentTeacher' => $posted['studentTeacher'][$k],
                ];

                $check = self::checkAddEditStudentPostedData();
                if (true === (bool) $check) {
                    list($postedStack[], $studentStack[]) = $check;
                }
            }

            for ($i = 0, $length = \count($postedStack); $i < $length; $i++) {
                $posted = $postedStack[$i];
                $student = $studentStack[$i];
                $studentsTeachers = StudentTeacher::getByStudentId($student->getId());
                /** @var StudentTeacher $studentTeacher */
                foreach ($studentsTeachers as $studentTeacher) {
                    $studentTeacher->delete();
                }

                $student->flush();

                if (null === $student->getId()) {
                    throw new \Exception('Record of student as failed');
                }

                foreach ($posted['studentTeacher'] as $stt) {
                    $studentTeacher = new StudentTeacher();
                    $studentTeacher->setStudentId($student->getId());
                    $studentTeacher->setTeacherId((int) $stt['teacherId']);
                    $studentTeacher->setStartDate($stt['startDate']);
                    $studentTeacher->setEndDate($stt['endDate']);
                    $studentTeacher->flush();
                }
            }

            Messenger::addMessage('Etudiants modifiés');

            return $router->redirect($router->getCurrentUri());
        };
    }
}
