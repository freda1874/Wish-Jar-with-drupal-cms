<?php

namespace Drupal\follow\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\follow\FollowManagerInterface;
use Drupal\user\UserInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Block with the follow links.
 *
 * @Block(
 *   id = "follow_block",
 *   admin_label = @Translation("Follow links"),
 *   category = @Translation("User")
 * )
 */
class FollowUserBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Returns the current_route_match service.
   *
   * @var \Drupal\Core\Routing\RouteMatchInterface
   */
  protected $routeMatch;

  /**
   * Returns the follow.manager service.
   *
   * @var \Drupal\follow\FollowManagerInterface
   */
  protected $followManager;

  /**
   * Constructs a FollowUserBlock block.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin ID for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Routing\RouteMatchInterface $route_match
   *   Provides an interface for classes representing the result of routing.
   * @param \Drupal\follow\FollowManagerInterface $follow_manager
   *   Defines the follow service.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, RouteMatchInterface $route_match, FollowManagerInterface $follow_manager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);

    $this->routeMatch = $route_match;
    $this->followManager = $follow_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('current_route_match'),
      $container->get('follow.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'size' => 'small',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['size'] = [
      '#type' => 'radios',
      '#title' => $this->t('Icon size'),
      '#default_value' => $this->configuration['size'],
      '#options' => [
        'small' => $this->t('Small'),
        'large' => $this->t('Large'),
        'paulrobertlloyd32' => $this->t('Paul Robert Lloyd 32'),
      ],
      '#required' => TRUE,
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['size'] = $form_state->getValue('size');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];

    /** @var \Drupal\user\UserInterface $user */
    $user = $this->routeMatch->getParameter('user');

    if (!$user || !($user instanceof UserInterface) || !empty($user->in_preview)) {
      return $build;
    }

    $build['follow_links'] = $this->followManager->getIcons($user, $this->configuration['size']);

    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function blockAccess(AccountInterface $account) {
    $access = $account->hasPermission('view follow links');

    return AccessResult::allowedIf($access);
  }

}
