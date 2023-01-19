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

    $build = [
      '#theme' => 'service_examples_employee_info',
      '#employee' => $info,
    ];

    return $build;
  }

}
