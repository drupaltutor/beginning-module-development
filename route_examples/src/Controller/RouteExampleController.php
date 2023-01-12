<?php

namespace Drupal\route_examples\Controller;

class RouteExampleController {

  public function helloWorld() {
    return [
      '#markup' => 'Hello world!',
    ];
  }
}
