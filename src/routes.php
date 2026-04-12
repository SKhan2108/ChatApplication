<?php

use Slim\App;
use App\Controllers\UserController;
use App\Controllers\GroupController;
use App\Controllers\MessageController;

return function (App $app) {
    $app->post('/users', [UserController::class, 'create']);
    $app->post('/groups', [GroupController::class, 'create']);
    $app->get('/groups', [GroupController::class, 'list']);
    $app->post('/groups/{id}/join', [GroupController::class, 'join']);
    $app->post('/groups/{id}/messages', [MessageController::class, 'send']);
    $app->get('/groups/{id}/messages', [MessageController::class, 'get']);
};
