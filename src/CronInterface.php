<?php

namespace Drupal\grafeon_cancel_subscription;

/**
 * Provides the interface for the Recurring module's cron.
 *
 * Cancels subscriptions if the end date is earlier than the cron time and the subscription is active
 */
interface CronInterface {

  /**
   * Runs the cron.
   */
  public function run();

}