<?php

/**
 * @file
 * Hooks for the follow module.
 */

/**
 * @addtogroup hooks
 * @{
 */

/**
 * Alter the follow links.
 *
 * @param array $links
 *   An array of follow links.
 */
function hook_follow_links_alter(array &$links) {
  $links['custom'] = [
    'label' => t('Custom'),
    'path' => \Drupal::service('extension.list.module')->getPath('MY_MODULE') . '/icons',
  ];

  if (isset($links['feed'])) {
    $links['feed']['path'] = \Drupal::service('extension.list.module')->getPath('MY_MODULE') . '/icons';
  }
}

/**
 * @} End of "addtogroup hooks".
 */
