<?php

namespace Eiad\Middleware;

use Eiad\Models\Material;


class MaterialValidator
{
  public function __invoke($request, $response, $next)
  {
    $body = $request->getParsedBody();
    $httpMethod = $request->getMethod();
    $errorData = [];

    if ($httpMethod == 'POST') {

      if (!$this->areParamsValid($body)) {
        $errorData['message'] = 'Parámetros inválidos.';
        return $response->withStatus(400)->withJson($errorData);
      }

      if ($this->isIdAlreadyInDb($body)) {
        $errorData['message'] = 'El ID ya existe.';
        return $response->withStatus(409)->withJson($errorData);
      }

    } else if ($httpMethod == 'DELETE' || $httpMethod == 'GET') {

      if ($this->isIdAlreadyInDb($body)) {
        return $response->withStatus(404);
      }

    }

    return $next($request, $response);

  }

  private function areParamsValid($body)
  {
    if (!$body['id'] || !$body['name'] || !$body['brand'] || !$body['model'] || !$body['lab_id']) {
      return false;
    }
    return true;
  }

  private function isIdAlreadyInDb($body)
  {
    if ($body['id']) {
      $material = Material::find($body['id']);
      if ($material) {
        return true;
      }
    }
    return false;
  }
}