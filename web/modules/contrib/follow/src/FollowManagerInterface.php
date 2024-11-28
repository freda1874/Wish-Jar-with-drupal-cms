<?php

namespace Drupal\follow;

use Drupal\user\UserInterface;

/**
 * Interface for follow service.
 */
interface FollowManagerInterface {

  /**
   * Returns an array of follow links.
   *
   * @param \Drupal\user\UserInterface $user
   *   The user entity.
   * @param string $size
   *   The icon size.
   *
   * @return array
   *   An array of follow icons.
   */
  public function getIcons(UserInterface $user, string $size = 'small'): array;

}
