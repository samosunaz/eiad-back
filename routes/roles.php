<?php

use Eiad\Models\Role;

$app->group('/roles', function () {
  $this->get('/{role_id}', function ($request, $response, $args) {
    $role = Role::find($args['role_id']);
    return $response->withStatus(200)->withJson($role->users);
  });
});