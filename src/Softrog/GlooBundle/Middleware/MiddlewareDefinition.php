<?php

namespace SoftRog\GlooBundle\Middleware;

class MiddlewareDefinition
{

  /** @var string */
  protected $attribute;
  /** @var callable */
  protected $callback;
  /** @var string[] */
  protected $arguments;

  /**
   * Build a middleware definition.
   *
   * @param string $attribute
   * @param callable $callback
   * @param string[] $arguments
   * @throws \Exception
   */
  public function __construct($attribute, callable $callback, array $arguments)
  {
    $this->attribute = $attribute;
    $this->callback = $callback;
    $this->arguments = $arguments;
  }

  /**
   * Get the definition attribute.
   *
   * @return string
   */
  function getAttribute()
  {
    return $this->attribute;
  }

  /**
   * Get the definitio callback.
   *
   * @return callable
   */
  function getCallback()
  {
    return $this->callback;
  }

  /**
   * Get the definition arguments.
   *
   * @return string[]
   */
  function getArguments()
  {
    return $this->arguments;
  }

}
