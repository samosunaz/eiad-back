<?php

use Eiad\Models\User;
use Firebase\JWT\JWT;

$key = env('JWT_KEY');

$app->group('/users', function () {
  $this->get('', function ($request, $response, $args) {
    $users = User::all();
    $payload = [];
    foreach ($users as $user) {
      $payload[] = $user->getDetails();
    }
    return $response->withStatus(200)->withJson($payload);
  });

  $this->post('', function ($request, $response, $args) {
    $body = $request->getParsedBody();

    if ($body['action'] == 'login') {
      $email = $body['email'];
      $password = $body['password'];
      $user = User::where('email', $email)->where('password', $password)->first();
      if (!$user) {
        return $response->withStatus(404);
      }
      $payload = [];
      $payload['token'] = JWT::encode($user, '4dm1nd3l4b5', 'HS256');
      $payload['user'] = $user->getDetails();
      return $response->withStatus(200)->withJson($payload);
    } else if ($body['action'] == 'authenticate') {
      $alg['alg'] = ["HS256"];
      $jwt = $body['token'];
      try {
        $decoded = JWT::decode($jwt, '4dm1nd3l4b5', array('HS256'));
        if ($decoded->id) {
          $user = User::find($decoded->id);
        }
      } catch (Exception $e) {
        return $response->withStatus(400);
      }
      return $response->withStatus(200)->withJson($user->getDetails());
    } else {
      $user = new User();
      $user->id = $body['id'];
      $user->first_name = $body['first_name'];
      $user->last_name = $body['last_name'];
      $user->email = $body['email'];
      $user->password = $body['password'];
      $user->save();
      $user->roles()->attach($body['roles']);

      if (!$user->exists) {
        return $response->withStatus(400);
      }
      return $response->withStatus(200)->withJson($user);
    }
  });

  $this->group('/{user_id}', function () {

    $this->delete('', function ($request, $response, $args) {
      $user = User::find($args['user_id']);
      $user->delete();
      return $response->withStatus(204);
    });

    $this->get('', function ($request, $response, $args) {
      $user = User::find($args['user_id']);
      if ($user) {
        return $response->withStatus(200)->withJson($user);
      }
      return $response->withStatus(404);
    });
  });
});