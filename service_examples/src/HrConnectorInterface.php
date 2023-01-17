<?php

namespace Drupal\service_examples;

use Drupal\user\UserInterface;

/**
 * Connects the Drupal website with the HR system.
 */
interface HrConnectorInterface {

  /**
   * Retrieves employee information for the given user account
   *
   * @param UserInterface $user
   */
  public function getEmployeeInformation(UserInterface $user);

}
