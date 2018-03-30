<?php

use Afip\Planning\App\Controllers\ErrorController;
use Afip\Planning\App\Controllers\IndexController;
use Afip\Planning\App\Controllers\NationalityController;
use Afip\Planning\App\Controllers\RoomController;
use Afip\Planning\App\Controllers\StudentController;
use Afip\Planning\App\Controllers\TeacherController;
use Afip\Planning\Components\Routing\Router;
use Afip\Planning\Models\Room;

require_once './../vendor/autoload.php';
require_once './../app/config/env.php';

$router = new Router();

$router
    ->addRoute(
        'GET',
        '/',
        IndexController::view()
    )
    ->addRoute(
        'GET',
        '/list/students',
        StudentController::list()
    )
    ->addRoute(
        'GET',
        '/list/rooms',
        RoomController::list()
    )
    ->addRoute(
        'GET',
        '/list/teachers',
        TeacherController::list()
    )
    ->addRoute(
        'GET',
        '/list/nationalities',
        NationalityController::list()
    )
    ->addRoute(
        'GET',
        '/add/student',
        StudentController::addView()
    )
    ->addRoute(
        'POST',
        '/add/student',
        StudentController::addAction()
    )
    ->addRoute(
        'GET',
        '/student/delete/{id}',
        StudentController::delete()
    )
    ->addRoute(
        'GET',
        '/student/edit/{id}',
        StudentController::editView()
    )
    ->addRoute(
        'POST',
        '/student/edit/{id}',
        StudentController::editAction()
    )
    ->addRoute(
        'GET',
        '/add/teacher',
        TeacherController::addView()
    )
    ->addRoute(
        'POST',
        '/add/teacher',
        TeacherController::addAction()
    )
    ->addRoute(
        'GET',
        '/teacher/edit/{id}',
        TeacherController::editView()
    )
    ->addRoute(
        'POST',
        '/teacher/edit/{id}',
        TeacherController::editAction()
    )
    ->addRoute(
        'GET',
        '/add/room',
        RoomController::addView()
    )
    ->addRoute(
        'POST',
        '/add/room',
        RoomController::addAction()
    )
    ->addRoute(
        'GET',
        '/room/delete/{id}',
        RoomController::delete()
    )
    ->addRoute(
        'GET',
        '/room/edit/{id}',
        RoomController::editView()
    )
    ->addRoute(
        'POST',
        '/room/edit/{id}',
        RoomController::editAction()
    )
    ->addRoute(
        'GET',
        '/add/nationality',
        NationalityController::addView()
    )
    ->addRoute(
        'POST',
        '/add/nationality',
        NationalityController::addAction()
    )
    ->addRoute(
        'GET',
        '/nationality/delete/{id}',
        NationalityController::delete()
    )
    ->addRoute(
        'GET',
        '/nationality/edit/{id}',
        NationalityController::editView()
    )
    ->addRoute(
        'POST',
        '/nationality/edit/{id}',
        NationalityController::editAction()
    )
    ->addRoute(
        'GET',
        '/student/all/edit',
        StudentController::editAllView()
    )
    ->addRoute(
        'POST',
        '/student/all/edit',
        StudentController::editAllAction()
    )
    ->addErrorRoute(404, ErrorController::Error404())
;

$router->listen();
