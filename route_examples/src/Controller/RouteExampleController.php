<?php

namespace Drupal\route_examples\Controller;

use Drupal\Core\Controller\ControllerBase;

class RouteExampleController extends ControllerBase {

  public function helloWorld() {
    return [
      '#markup' => $this->t('Hello world!'),
    ];
  }

  public function helloUser() {
    return [
      '#markup' => $this->t('Hello @user', ['@user' => $this->currentUser()->getDisplayName()])
    ];
  }

  public function helloUserTitle() {
    return $this->t('Hello @user', ['@user' => $this->currentUser()->getDisplayName()]);
  }
}
