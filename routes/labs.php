<?php

use Eiad\Models\Lab;
use Eiad\Middleware\LabValidator;

$app->group('/labs', function () {

  $this->get('', function ($request, $response, $args) {
    $labs = Lab::all();
    return $response->withStatus(200)->withJson($labs);
  });

  $this->post('', function ($request, $response, $args) {
    $body = $request->getParsedBody();
    $lab = new Lab();
    $lab->id = $body['id'];
    $lab->name = $body['name'];
    $lab->floor_id = $body['floor_id'];
    $lab->save();
    if (!$lab->exists) {
      return $response->withStatus(400);
    }
    return $response->withStatus(201)->withJson($lab);
  });

  $this->group('/{lab_id}', function () {

    $this->delete('', function ($request, $response, $args) {
      $lab = Lab::find($args['lab_id']);
      $lab->delete();
      return $response->withStatus(204);
    });

    $this->get('', function ($request, $response, $args) {
      $labId = $args['lab_id'];
      $lab = Lab::find($labId);
      $lab->materials;
      if ($lab) {
        return $response->withStatus(200)->withJson($lab);
      } else {
        return $response->withStatus(404);
      }
    });

    $this->get('/classes', function ($request, $response, $args) {
      $lab = Lab::find($args['lab_id']);
      $labClasses = $lab->labClasses;
      $payload = [];
      foreach ($labClasses as $labClass) {
        $payload[] = $labClass->asEvent();
      }
      return $response->withStatus(200)->withJson($payload);
    });

  });
})->add(new LabValidator());