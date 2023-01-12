<?php

namespace Drupal\route_examples\Controller;

use Drupal\Component\Utility\Html;
use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\user\UserInterface;

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

  public function userInfo(UserInterface $user) {
    $build = [];
    /** @var \Drupal\Core\Datetime\DateFormatterInterface */
    $date_formater = \Drupal::service('date.formatter');
    $build[] = [
      '#type' => 'html_tag',
      '#tag' => 'div',
      '#value' => $this->t('Name: @name', ['@name' => $user->getDisplayName()]),
    ];
    $build[] = [
      '#type' => 'html_tag',
      '#tag' => 'div',
      '#value' => $this->t('Email: @email', ['@email' => $user->getEmail()]),
    ];
    $build[] = [
      '#type' => 'html_tag',
      '#tag' => 'div',
      '#value' => $this->t('Created: @created', ['@created' => $date_formater->format($user->getCreatedTime())]),
    ];
    $build[] = [
      '#type' => 'html_tag',
      '#tag' => 'div',
      '#value' => $this->t('Last Login: @login', ['@login' => $date_formater->format($user->getLastLoginTime())]),
    ];

    return $build;
  }

  public function userInfoTitle(UserInterface $user) {
    return $this->t('Information About @user', ['@user' => $user->getDisplayName()]);
  }

}
