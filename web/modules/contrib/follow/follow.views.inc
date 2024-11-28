<?php

/**
 * @file
 * Contains follow.views.inc.
 */

/**
 * Implements hook_views_data_alter().
 */
function follow_views_data_alter(array &$data) {
  $data['users_field_data']['follow'] = [
    'title' => t('Follow links'),
    'group' => t('User'),
    'field' => [
      'title' => t('Follow links'),
      'id' => 'follow_links_field',
    ],
  ];
}
