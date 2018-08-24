<?php

use Eiad\Models\LabClass;

$app->group('/classes', function () {

  $this->get('', function ($request, $response, $args) {
    $classes = LabClass::all();
    return $response->withStatus(200)->withJson($classes);
  });

  $this->post('', function ($request, $response, $args) {
    $body = $request->getParsedBody();

    $class = new LabClass();
    $class->id = $body['id'];
    $class->name = $body['name'];
    $class->starts_at = $body['starts_at'];
    $class->ends_at = $body['ends_at'];
    $class->lab_id = $body['lab_id'];
    $class->days = $body['days'];
    $class->save();

    if (!$class->exists) {
      return $response->withStatus(400);
    }

    return $response->withStatus(201)->withJson($class);
  });

  $this->group('/{class_id}', function () {

    $this->delete('', function ($request, $response, $args) {
      $class = LabClass::find($args['class_id']);
      $class->delete();
      return $response->withStatus(204);
    });

    $this->put('', function ($request, $response, $args) {
      $body = $request->getParsedBody();
      $class = LabClass::find($body['id']);
      $class->name = $body['name'];
      $class->starts_at = $body['starts_at'];
      $class->ends_at = $body['ends_at'];
      $class->lab_id = $body['lab_id'];
      $class->days = $body['days'];
      $class->save();
      return $response->withStatus(200);
    });
  });
});