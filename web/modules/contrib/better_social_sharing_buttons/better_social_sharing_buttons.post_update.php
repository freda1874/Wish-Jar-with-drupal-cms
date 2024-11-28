<?php

/**
 * @file
 * Post update functions for the Better Social Sharing Buttons module.
 */

/**
 * Update default social sharing buttons block for Layout Builder sections.
 */
function better_social_sharing_buttons_post_update_update_layout_builder_more_settings() {
  if (!\Drupal::moduleHandler()->moduleExists('layout_builder')) {
    return NULL;
  }
  /** @var \Drupal\Core\Entity\EntityTypeManagerInterface $entityTypeManager */
  $entityTypeManager = \Drupal::service('entity_type.manager');
  $storage = $entityTypeManager->getStorage('entity_view_display');
  $updatedDisplays = [];
  foreach ($storage->loadMultiple() as $display) {
    $changed = FALSE;
    /** @var \Drupal\Core\Entity\Entity\EntityViewDisplay $display */
    $sections = $display->getThirdPartySetting('layout_builder', 'sections', []);
    foreach ($sections as $section) {
      /** @var \Drupal\layout_builder\Section $section */
      foreach ($section->getComponents() as $component) {
        $configuration = $component->toArray()['configuration'] ?? [];
        if (($configuration['id'] ?? '') === 'social_sharing_buttons_block') {
          $configuration['services'] = array_filter($configuration['services'] ?? []);
          $component->setConfiguration($configuration);
          $changed = TRUE;
        }
      }
    }
    if ($changed) {
      $updatedDisplays[] = $display->id();
      $display
        ->setThirdPartySetting('layout_builder', 'sections', $sections)
        ->save();
    }
  }
  if ($updatedDisplays) {
    return t('Updated the layout_builder schema settings for: %display_ids', [
      '%display_ids' => implode(', ', $updatedDisplays),
    ]);
  }

  return NULL;
}
