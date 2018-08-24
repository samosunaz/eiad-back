<?php

use Eiad\Models\Material;
use Eiad\Middleware\MaterialValidator;

$app->group('/materials', function () {

  $this->get('', function ($request, $response, $args) {
    $materials = [];
    $materials = Material::all();
    return $response->withStatus(200)->withJson($materials);
  });

  $this->post('', function ($request, $response, $args) {
    $body = $request->getParsedBody();

    $material = new Material();
    $material->id = $body['id'];
    $material->name = $body['name'];
    $material->brand = $body['brand'];
    $material->model = $body['model'];
    $material->lab_id = $body['lab_id'];
    $material->save();

    if ($material->exists) {
      return $response->withStatus(201)->withJson($material);
    } else {
      return $response->withStatus(400);
    }
  });

  $this->group('/{material_id}', function () {

    $this->delete('', function ($request, $response, $args) {
      $material = Material::find($args['material_id']);
      $material->delete();
      return $response->withStatus(204);
    });

    $this->get('', function ($request, $response, $args) {
      $material = Material::find($args['material_id']);
      return $response->withStatus(200)->withJson($material);
    });

    $this->put('', function ($request, $response, $args) {
      $body = $request->getParsedBody();
      $material = Material::find($args['material_id']);

      $material->name = $body['name'];
      $material->brand = $body['brand'];
      $material->model = $body['model'];
      $material->lab_id = $body['lab_id'];
      $material->save();
      return $response->withStatus(200)->withJson($material);
    });
  });
})->add(new MaterialValidator());