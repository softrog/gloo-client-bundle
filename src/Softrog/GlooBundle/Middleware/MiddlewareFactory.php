<?php

namespace SoftRog\GlooBundle\Middleware;

class MiddlewareFactory
{
  /**
   * Build a Middleware based on the given definitions
   *
   * @param array $requestDefinition
   * @param array $responseDefinition
   * @return \SoftRog\GlooBundle\Middleware\MiddlewareWrapper
   */
  public function build($requestDefinition, $responseDefinition)
  {
    $middleware = new MiddlewareWrapper();

    if (count($requestDefinition) > 0) {
      list($attribute, $callback, $arguments) = $requestDefinition;
      $middleware->setRequestDefinition(new MiddlewareDefinition($attribute, $callback, $arguments));
    }

    if (count($responseDefinition) > 0) {
      list($attribute, $callback, $arguments) = $responseDefinition;
      $middleware->setResponseDefinition(new MiddlewareDefinition($attribute, $callback, $arguments));
    }

    return $middleware;
  }
}
