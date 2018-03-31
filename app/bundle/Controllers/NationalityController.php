<?php

namespace Afip\Planning\App\Controllers;

use Afip\Planning\Components\Messenger\Messenger;
use Afip\Planning\Components\Rendering\Renderer;
use Afip\Planning\Components\Routing\Router;
use Afip\Planning\Models\Nationality;
use Afip\Planning\Models\Room;

class NationalityController
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
     *
     * @throws \ReflectionException
     * @throws \LogicException
     */
    public static function list()
    {
        return function (Router $router) {
            /** @var Nationality[] $students */
            $nationalities = Nationality::getAll();

            Renderer::render(
                __DIR__.'/../templates/bodies/list-nationalities.php',
                [
                    'title' => 'Liste des nationalitées',
                    'nationalities' => $nationalities,
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
            Renderer::render(
                __DIR__.'/../templates/bodies/add-edit-nationality.php',
                [
                    'title' => 'Ajouter une Salle',
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
            $nationality = new Nationality($_POST['nationality']);

            $nationality->flush();

            if (null !== $nationality->getId()) {
                Messenger::addMessage("Nationalité {$nationality->getLabel()} ajouté");
            } else {
                Messenger::addMessage('une erreur est survenue');
            }

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
            /** @var Nationality[] $nationality */
            $nationality = Nationality::getById($id);

            if (0 < \count($nationality)) {
                $nationality[0]->delete();
                Messenger::addMessage('Suppression de la nationalité');
            }

            $router->redirect('/list/nationalities');
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
            $nationality = Nationality::getById($id);

            if (0 === \count($nationality)) {
                Messenger::addMessage("La nationalité n'existe pas", Messenger::DANGER);

                return $router->redirect('/list/nationalities');
            }

            Renderer::render(
                __DIR__.'/../templates/bodies/add-edit-nationality.php',
                [
                    'title' => 'Modification de la nationalité : '.$nationality[0]->getLabel(),
                    'nationality'  => $nationality[0],
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
            /** @var Room $room */
            $nationality = new Nationality($_POST['nationality']);

            $nationality->setId($id);

            $nationality->flush();

            if (null !== $nationality->getId()) {
                Messenger::addMessage("Nationalité {$nationality->getLabel()} modifié");
            } else {
                Messenger::addMessage('une erreur est survenue');
            }

            return $router->redirect('/list/nationalities');
        };
    }
}
