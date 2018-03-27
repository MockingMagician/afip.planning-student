<?php

use Afip\Planning\App\Controllers\IndexController;
use Afip\Planning\App\Controllers\RoomController;
use Afip\Planning\App\Controllers\StudentController;
use Afip\Planning\App\Controllers\TeacherController;
use Afip\Planning\Components\Routing\Router;

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
//    ->addRoute(
//        'GET',
//        '/student/insert',
//        StudentController::insert()
//    )
//    ->addRoute(
//        'GET',
//        '/student/delete/{id}',
//        StudentController::delete()
//    )
//    ->addRoute(
//        'GET',
//        '/student/edit/{id}',
//        StudentController::edit()
//    )
//    // View a student
//    ->addRoute(
//        'GET',
//        '/student/{id}/edit',
//        Student::edit
//    )
//    // NEW student view
//    ->addRoute(
//        'GET',
//        '/student/new',
//        Student::new
//    )
//    // NEW student action
//    ->addRoute(
//        'GET',
//        '/student/{id}/edit',
//        Student::newAction
//    )
;

$router->listen();
