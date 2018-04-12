<?php

use Eiad\Models\User;

$app->group('/users', function () {
  $this->map(['GET'], '', function ($request, $response, $args) {
    $users = User::all();
    return $response->withStatus(200)->withJson($users);
  });

  $this->map(['GET'], '/{user_id}', function ($request, $response, $args) {
    $user = User::find($args['user_id']);
    if ($user) {
      return $response->withStatus(200)->withJson($user);
    }
    return $response->withStatus(404);
  });
});