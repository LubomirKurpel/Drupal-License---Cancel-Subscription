<?php

namespace Drupal\grafeon_cancel_subscription;

use Drupal\Component\Datetime\TimeInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;

/**
 * Default cron implementation.
 */
class Cron implements CronInterface {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;


  /**
   * The time.
   *
   * @var \Drupal\Component\Datetime\TimeInterface
   */
  protected $time;

  /**
   * Constructs a new Cron object.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   * @param \Drupal\Component\Datetime\TimeInterface $time
   *   The time.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager, TimeInterface $time) {
    $this->entityTypeManager = $entity_type_manager;
    $this->time = $time;
  }

  /**
   * {@inheritdoc}
   */
  public function run() {
    // If the subscription has an end time which is earlier than now,
    // and it's not already closed, end the subscription immediately.    
    $subscription_storage = $this->entityTypeManager->getStorage('commerce_subscription');
    $subscription_ids = $subscription_storage->getQuery()
      ->condition('state', ['pending', 'trial', 'active'], 'IN')
      ->condition('ends', $this->time->getRequestTime(), '<=')
      ->accessCheck(FALSE)
      ->execute();

    if (!$subscription_ids) {
      return;
    }
    /** @var \Drupal\commerce_recurring\Entity\SubscriptionInterface[]  $subscriptions */
    $subscriptions = $subscription_storage->loadMultiple($subscription_ids);

    foreach ($subscriptions as $subscription) {
		
      $subscription->cancel();
      $subscription->save();
	  
	  
    }

	
  }

}