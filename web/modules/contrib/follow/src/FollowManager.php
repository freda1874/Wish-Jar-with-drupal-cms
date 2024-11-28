<?php

namespace Drupal\follow;

use Drupal\Core\Cache\Cache;
use Drupal\Core\Config\ConfigFactory;
use Drupal\user\UserData;
use Drupal\user\UserInterface;

/**
 * Manager for follow related methods.
 */
class FollowManager implements FollowManagerInterface {

  /**
   * Returns the user.data service.
   *
   * @var \Drupal\user\UserData
   */
  protected $userData;

  /**
   * Returns the config.factory service.
   *
   * @var \Drupal\Core\Config\ConfigFactory
   */
  protected $config;

  /**
   * Constructs a FollowManager object.
   *
   * @param \Drupal\user\UserData $user_data
   *   Defines the user data service.
   * @param \Drupal\Core\Config\ConfigFactory $config
   *   Defines the configuration object factory.
   */
  public function __construct(UserData $user_data, ConfigFactory $config) {
    $this->userData = $user_data;
    $this->config = $config;
  }

  /**
   * {@inheritdoc}
   */
  public function getIcons(UserInterface $user, string $size = 'small'): array {
    $links = follow_get_follow_links();
    $data = (array) $this->userData->get('follow', $user->id(), 'links');

    // Check if we should hide labels.
    $hide_labels = $this->config->get('follow.settings')->get('hide_labels');

    $items = [];
    foreach ($data as $key => $link) {
      if (!$link || !isset($links[$key])) {
        continue;
      }

      $items[] = [
        'label' => $hide_labels ? '' : $links[$key]['label'],
        'src' => "/{$links[$key]['path']}/{$size}/icon-{$key}.png",
        'url' => $link,
        'key' => $key,
      ];
    }

    if (!$items) {
      return [];
    }

    return [
      '#theme' => 'follow_links',
      '#links' => $items,
      '#cache' => [
        'tags' => Cache::mergeTags($user->getCacheTags(), ['config:follow.settings']),
        'contexts' => ['url.path'],
      ],
    ];
  }

}
