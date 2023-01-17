<?php

namespace Drupal\service_examples\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\service_examples\HrConnector;
use Drupal\service_examples\HrConnectorInterface;
use Drupal\user\UserInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Returns responses for Service Examples routes.
 */
class EmployeeInfoController extends ControllerBase {

  /**
   * The service_examples.hr_connector service.
   *
   * @var \Drupal\service_examples\HrConnectorInterface
   */
  protected $hrConnector;

  /**
   * The controller constructor.
   *
   * @param \Drupal\service_examples\HrConnectorInterface $hr_connector
   *   The service_examples.hr_connector service.
   */
  public function __construct(HrConnectorInterface $hr_connector) {
    $this->hrConnector = $hr_connector;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('service_examples.hr_connector')
    );
  }

  /**
   * Display employee information for a given user
   */
  public function displayEmployeeInformation(UserInterface $user) {

    $info = $this->hrConnector->getEmployeeInformation($user);

    $build['name'] = [
      '#type' => 'html_tag',
      '#tag' => 'h2',
      '#value' => $info['first_name'] . ' ' . $info['last_name'],
    ];
    $build['title'] = [
      '#type' => 'html_tag',
      '#tag' => 'div',
      '#value' => $info['title'],
    ];
    $build['department'] = [
      '#type' => 'html_tag',
      '#tag' => 'div',
      '#value' => $this->t('Department: @department', ['@department' => $info['department']]),
    ];
    if ($info['hire_date'] !== NULL) {
      $build['hire_date'] = [
        '#type' => 'html_tag',
        '#tag' => 'div',
        '#value' => $this->t('Hired: @hired', ['@hired' => $info['hire_date']]),
      ];
    }
    $build['photo'] = [
      '#theme' => 'image',
      '#uri' => $info['photo_url'],
    ];

    return $build;
  }

}
