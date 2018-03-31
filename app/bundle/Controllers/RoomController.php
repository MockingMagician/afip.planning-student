<?php

namespace Afip\Planning\App\Controllers;

use Afip\Planning\Components\Messenger\Messenger;
use Afip\Planning\Components\Rendering\Renderer;
use Afip\Planning\Components\Routing\Router;
use Afip\Planning\Models\Room;

class RoomController
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
            /** @var Room[] $rooms */
            $rooms = Room::getAll();

            Renderer::render(
                __DIR__.'/../templates/bodies/list-rooms.php',
                [
                    'title' => 'Liste des salles',
                    'rooms' => $rooms,
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
                __DIR__.'/../templates/bodies/add-edit-room.php',
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
            $room = new Room($_POST['room']);

            $room->flush();

            if (null !== $room->getId()) {
                Messenger::addMessage("Salle {$room->getLabel()} ajouté");
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
            /** @var Room[] $room */
            $room = Room::getById($id);

            if (0 < \count($room)) {
                $room[0]->delete();
            }

            Messenger::addMessage('Suppression de la salle');

            $router->redirect('/list/rooms');
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
            $room = Room::getById($id);

            if (0 === \count($room)) {
                Messenger::addMessage("La salle n'existe pas", Messenger::DANGER);

                return $router->redirect('/list/rooms');
            }

            Renderer::render(
                __DIR__.'/../templates/bodies/add-edit-room.php',
                [
                    'title' => 'Modification de la salle : '.$room[0]->getLabel(),
                    'room'  => $room[0],
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
            $room = new Room($_POST['room']);

            $room->setId($id);

            $room->flush();

            if (null !== $room->getId()) {
                Messenger::addMessage("Salle {$room->getLabel()} modfié");
            } else {
                Messenger::addMessage('une erreur est survenue');
            }

            return $router->redirect('/list/rooms');
        };
    }
}
