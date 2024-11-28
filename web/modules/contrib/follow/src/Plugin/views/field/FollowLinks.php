<?php

namespace Drupal\follow\Plugin\views\field;

use Drupal\Core\Session\AccountInterface;
use Drupal\follow\FollowManagerInterface;
use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\views\ResultRow;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * A handler to provide display for the Follow links.
 *
 * @ingroup views_field_handlers
 *
 * @ViewsField("follow_links_field")
 */
class FollowLinks extends FieldPluginBase {

  /**
   * Returns the follow.manager service.
   *
   * @var \Drupal\follow\FollowManagerInterface
   */
  protected $followManager;

  /**
   * Returns the current_user service.
   *
   * @var \Drupal\Core\Session\AccountInterface
   */
  protected $currentUser;

  /**
   * Constructs a new FollowLinks instance.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin ID for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\follow\FollowManagerInterface $follow_manager
   *   Defines the follow service.
   * @param \Drupal\Core\Session\AccountInterface $current_user
   *   Defines an account interface which represents the current user.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, FollowManagerInterface $follow_manager, AccountInterface $current_user) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);

    $this->followManager = $follow_manager;
    $this->currentUser = $current_user;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('follow.manager'),
      $container->get('current_user')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function query() {}

  /**
   * {@inheritdoc}
   */
  public function render(ResultRow $values) {
    $build = [];

    /** @var \Drupal\user\UserInterface $user */
    $user = $this->getEntity($values);

    if (!$user || !$this->currentUser->hasPermission('view follow links')) {
      return $build;
    }

    $build['follow'] = $this->followManager->getIcons($user);

    return $build;
  }

}
