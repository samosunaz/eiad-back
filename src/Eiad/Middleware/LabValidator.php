<?php

namespace Eiad\Middleware;

use Eiad\Models\Lab;


class LabValidator
{
  private $body;
  public function __invoke($request, $response, $next)
  {
    $this->body = $request->getParsedBody();
    $errRes = [];
    $method = $request->getMethod();

    if ($request->isPost()) {
      if (!$this->areParamsValid()) {
        $errRes['message'] = 'Parámetros inválidos.';
        return $response->withStatus(400)->withJson($errRes);
      }
      if ($this->isAlreadyInDb()) {
        $errRes['message'] = 'El ID ya está en uso.';
        return $response->withStatus(409)->withJson($errRes);
      }
    } else if ($request->isDelete()) {
      if ($this->isAlreadyInDb()) {
        $errRes['message'] = 'Laboratorio no encontrado.';
        return $response->withStatus(404)->withJson($errRes);
      }
    }

    return $next($request, $response);
  }

  private function areParamsValid()
  {
    if (!$this->body['id'] || !$this->body['name'] || !$this->body['floor_id']) {
      return false;
    }
    return true;
  }

  private function isAlreadyInDb()
  {
    if ($this->body['id']) {
      $lab = Lab::find($this->body['id']);
      if ($lab) {
        return true;
      }
    }
    return false;
  }
}