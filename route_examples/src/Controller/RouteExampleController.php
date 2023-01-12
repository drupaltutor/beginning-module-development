<?php

namespace Drupal\route_examples\Controller;

use Drupal\Component\Utility\Html;
use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;

class RouteExampleController extends ControllerBase {

  public function helloWorld() {
    return [
      '#markup' => $this->t('Hello world!'),
    ];
  }

  public function helloUser() {
    // return [
    //   '#markup' => Html::escape($this->currentUser()->getDisplayName()),
    // ];
    // return [
    //   '#plain_text' => $this->currentUser()->getDisplayName(),
    // ];
    return [
      '#markup' => $this->t('Hello @user', ['@user' => $this->currentUser()->getDisplayName()])
    ];
  }

  public function helloUserTitle() {
    return $this->t('Hello @user', ['@user' => $this->currentUser()->getDisplayName()]);
  }
}
