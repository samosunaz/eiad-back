<?php

use Eiad\Models\Floor;

$app->group('/floors', function () {

  $this->get('', function ($request, $response, $args) {
    $floors = Floor::all();
    return $response->withStatus(200)->withJson($floors);
  });

  $this->post('', function ($request, $response, $args) {
    $body = $request->getParsedBody();
    $floor = new Floor();
    $floor->id = $body['id'];
    $floor->name = $body['name'];
    $floor->save();
    if (!$floor->exists) {
      return $response->withStatus(400);
    }
    return $response->withStatus(201)->withJson($floor);
  });

  $this->group('/{floor_id}', function () {

    $this->group('', function () {

      $this->delete('', function ($request, $response, $args) {
        $floor = Floor::find($args['floor_id']);
        $floor->delete();
        return $response->withStatus(204);
      });

      $this->put('', function ($request, $response, $args) {
        $body = $request->getParsedBody();
        $floor = Floor::find($args['floor_id']);
        $floor->id = $body['id'];
        $floor->name = $body['name'];
        $floor->save();
        return $response->withStatus(200)->withJson($floor);
      });
    });

    $this->get('/labs', function ($request, $response, $args) {
      $floorId = $args['floor_id'];
      $floor = Floor::find($floorId);
      $labs = $floor->labs;
      return $response->withStatus(200)->withJson($labs);
    });
  });
});