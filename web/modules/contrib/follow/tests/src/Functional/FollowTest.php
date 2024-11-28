<?php

namespace Drupal\Tests\follow\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * Class FollowTest. The base class for testing follow links.
 */
class FollowTest extends BrowserTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['follow', 'follow_test'];

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * Test follow settings.
   */
  public function testFollowSettings() {
    // Log in as an admin user with permission to manage follow settings.
    $admin = $this->drupalCreateUser([], NULL, TRUE);
    $this->drupalLogin($admin);

    // Check the status of the page.
    $this->drupalGet('admin/config/people/follow');
    $this->assertSession()->statusCodeEquals(200);

    // Set follow settings.
    $edit = [];
    $edit['links[feed]'] = TRUE;
    // Enable the link that was added via an alter hook.
    $edit['links[custom]'] = TRUE;
    $edit['links[youtube]'] = FALSE;
    $this->submitForm($edit, 'Save configuration');

    // Check if the settings were saved.
    $this->assertSession()->pageTextContains('The configuration options have been saved.');

    $this->drupalGet("user/{$admin->id()}/follow");
    $this->assertSession()->statusCodeEquals(200);

    // Check if the selected links exist on the page.
    $this->assertSession()->pageTextContains('Feed');
    $this->assertSession()->pageTextContains('Test Link');
    $this->assertSession()->pageTextNotContains('YouTube');
  }

}
