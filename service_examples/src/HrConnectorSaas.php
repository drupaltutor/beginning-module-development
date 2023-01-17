<?php

namespace Drupal\service_examples;

use Drupal\user\UserInterface;
use GuzzleHttp\Exception\RequestException;

/**
 * Connects the Drupal website with the HR SaaS API.
 */
class HrConnectorSaaS implements HrConnectorInterface {

  /**
   * Retrieves employee information for the given user account
   *
   * @param UserInterface $user
   */
  public function getEmployeeInformation(UserInterface $user) {
    /** @var \GuzzleHttp\ClientInterface $http_client */
    $http_client = \Drupal::service('http_client');

    try {
      $response = $http_client->request(
        'GET',
        'https://drupaltutor.github.io/beginning-module-development/service_examples/data/' . $user->getAccountName() . '.json',
      );
      $employee_info = json_decode($response->getBody()->getContents(), TRUE, 512, JSON_THROW_ON_ERROR);
    }
    catch (RequestException $e) {
      $employee_info = [
        'first_name' => 'Valued',
        'last_name' => 'Employee',
        'title' => 'Team Member',
        'department' => 'Team',
        'hire_date' => NULL,
        'photo_url' => 'https://drupaltutor.github.io/beginning-module-development/service_examples/data/unknown2.jpg',
      ];
    }
    return $employee_info;
  }

}
