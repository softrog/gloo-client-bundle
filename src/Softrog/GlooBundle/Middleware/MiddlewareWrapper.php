<?php

namespace SoftRog\GlooBundle\Middleware;

use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Softrog\Gloo\Middleware\MiddlewareInterface;
use Softrog\Gloo\Middleware\RequestMiddlewareInterface;
use Softrog\Gloo\Middleware\ResponseMiddlewareInterface;

class MiddlewareWrapper implements RequestMiddlewareInterface, ResponseMiddlewareInterface
{

  /** @var MiddlewareDefinition */
  protected $requestDefinition;

  /** @var MiddlewareDefinition */
  protected $responseDefinition;

  public function __construct()
  {
    $this->requestDefinition = null;
    $this->responseDefinition = null;
  }

  /**
   * Sets the middleware definition for the request event.
   *
   * @param \SoftRog\GlooBundle\Middleware\MiddlewareDefinition $definition
   * @return MiddlewareInterface
   */
  public function setRequestDefinition(MiddlewareDefinition $definition)
  {
    $this->requestDefinition = $definition;

    return $this;
  }

  /**
   * Sets the middleware definition for the response event.
   *
   * @param \SoftRog\GlooBundle\Middleware\MiddlewareDefinition $definition
   * @return MiddlewareInterface
   */
  public function setResponseDefinition(MiddlewareDefinition $definition)
  {
    $this->responseDefinition = $definition;

    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function onRequest(RequestInterface $request)
  {
    if (!is_null($this->requestDefinition)) {
      return $this->processDefinition($this->requestDefinition, $request);
    }

    return $request;
  }

  /**
   * {@inheritdoc}
   */
  public function onResponse(ResponseInterface $response)
  {
    if (!is_null($this->responseDefinition)) {
      return $this->processDefinition($this->responseDefinition, $response);
    }

    return $response;
  }

  /**
   * Process the given definition over the message
   *
   * @param \SoftRog\GlooBundle\Middleware\MiddlewareDefinition $definition
   * @param MessageInterface $message
   */
  protected function processDefinition(MiddlewareDefinition $definition, MessageInterface $message)
  {
    $attribute = $definition->getAttribute();
    $callback = $definition->getCallback();
    $arguments = $definition->getArguments();

    foreach ($arguments as $pos => $method) {
      $method = 'get' . ucfirst($method);
      if (is_callable([$message, $method])) {
        $arguments[$pos] = $message->$method();
      }
    }

    $method = 'with' . ucfirst($attribute);

    if (!is_callable([$message, $method])) {
      $message = sprintf("Method '%s' does not exist in the given message", $method);
      throw new \Exception($message);
    }
var_dump ($arguments); exit;
    return $message->$method(call_user_func_array($callback, $arguments));
  }

}
