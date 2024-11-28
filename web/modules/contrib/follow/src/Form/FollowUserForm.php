<?php

namespace Drupal\follow\Form;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Config\ConfigFactory;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\user\UserData;
use Drupal\user\UserInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Form handler for adding follow links.
 */
class FollowUserForm extends FormBase {

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
   * Constructs a FollowUserForm form.
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
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('user.data'),
      $container->get('config.factory')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'user_follow_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, UserInterface $user = NULL) {
    $links = follow_get_follow_links();
    $data = (array) $this->userData->get('follow', $user->id(), 'links');

    $form['links'] = [
      '#type' => 'html_tag',
      '#tag' => 'div',
      '#tree' => TRUE,
    ];

    foreach ($this->config->get('follow.settings')->get('links') as $link) {
      if (isset($links[$link])) {
        $form['links'][$link] = [
          '#type' => 'textfield',
          '#title' => $links[$link]['label'],
          '#default_value' => !empty($data[$link]) ? $data[$link] : '',
        ];
      }
    }

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Save'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    /** @var \Drupal\user\UserInterface $user */
    $user = $form_state->getBuildInfo()['args'][0];
    Cache::invalidateTags($user->getCacheTags());

    $this->userData->set('follow', $user->id(), 'links', $form_state->getValue('links'));

    $this->messenger()->addStatus($this->t('Follow links have been saved.'));
  }

  /**
   * Provides form access callback.
   */
  public function access(UserInterface $user) {
    $current_user = $this->currentUser();
    $access = $current_user->hasPermission('edit any user follow links');

    if (!$access) {
      $access = $current_user->id() == $user->id() && $current_user->hasPermission('edit own follow links');
    }

    return $access ? AccessResult::allowed() : AccessResult::forbidden();
  }

}
