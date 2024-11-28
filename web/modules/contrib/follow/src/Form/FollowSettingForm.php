<?php

namespace Drupal\follow\Form;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Form handler for adding follow settings.
 */
class FollowSettingForm extends ConfigFormBase {

  /**
   * Returns the entity_type.manager service.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a FollowSettingForm form.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The factory for configuration objects.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   Provides an interface for entity type managers.
   */
  public function __construct(ConfigFactoryInterface $config_factory, EntityTypeManagerInterface $entity_type_manager) {
    parent::__construct($config_factory);

    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory'),
      $container->get('entity_type.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'follow_setting_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'follow.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->configFactory->getEditable('follow.settings');

    $options = [];
    foreach (follow_get_follow_links() as $link => $data) {
      $options[$link] = $data['label'];
    }

    $form['links'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('Follow links'),
      '#options' => $options,
      '#default_value' => !empty($config->get('links')) ? $config->get('links') : [],
    ];

    $form['hide_labels'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Hide labels'),
      '#default_value' => !empty($config->get('hide_labels')) ? $config->get('hide_labels') : FALSE,
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->configFactory->getEditable('follow.settings')
      ->set('links', array_filter($form_state->getValue('links')))
      ->set('hide_labels', (bool) $form_state->getValue('hide_labels'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}
