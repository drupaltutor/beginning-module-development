<?php

namespace Drupal\service_examples;

use Drupal\user\UserInterface;

/**
 * Connects the Drupal website with the HR database.
 */
class HrConnector implements HrConnectorInterface {

  /**
   * Retrieves employee information for the given user account
   *
   * @param UserInterface $user
   */
  public function getEmployeeInformation(UserInterface $user) {
    if ($user->getAccountName() === 'john') {
      return [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'title' => 'Web Developer',
        'department' => 'Marketing',
        'hire_date' => '2018-01-25',
        'photo_url' => 'https://drupaltutor.github.io/beginning-module-development/service_examples/data/john1.jpg',
      ];
    }
    elseif ($user->getAccountName() === 'jane') {
      return [
        'first_name' => 'Jane',
        'last_name' => 'Doe',
        'title' => 'Marketing Manager',
        'department' => 'Marketing',
        'hire_date' => '2010-04-10',
        'photo_url' => 'https://drupaltutor.github.io/beginning-module-development/service_examples/data/jane1.jpg',
      ];
    }
    else {
      return [
        'first_name' => 'Valued',
        'last_name' => 'Employee',
        'title' => 'Team Member',
        'department' => 'Team',
        'hire_date' => NULL,
        'photo_url' => 'https://drupaltutor.github.io/beginning-module-development/service_examples/data/unknown1.jpg',
      ];
    }
  }

}
