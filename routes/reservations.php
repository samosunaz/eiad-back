<?php

use Eiad\Models\ReservedMaterial;

$app->group('/reserved_materials', function () {

  $this->get('', function ($request, $response, $args) {
    $rsvMaterials = ReservedMaterial::all();
    return $response->withStatus(200)->withJson($rsvMaterials);
  });

  $this->post('', function ($request, $response, $args) {
    $body = $request->getParsedBody();
    return $response->withStatus(201);
  });

  $this->get('/{reserved_material_id}', function ($request, $response, $args) {
    $rsvMaterial = ReservedMaterial::find($args['reserved_material_id']);
    if ($rsvMaterial) {
      return $response->withStatus(200)->withJson($rsvMaterial);
    } else {
      return $response->withStatus(404)->write('NOT_FOUND');
    }
  });
});