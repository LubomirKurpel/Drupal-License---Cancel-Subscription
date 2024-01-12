<?php
namespace Drupal\grafeon_cancel_subscription\Controller;

use Drupal\commerce_recurring\Entity\SubscriptionInterface;
use Drupal\Core\Entity\ContentEntityConfirmFormBase;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Provides route responses for the Example module.
 */
class GrafeonCancelSubscriptionController extends ControllerBase {

  /**
   * Returns a simple page.
   *
   * @return array
   *   A simple renderable array.
   */
  public function cancel() {
	
	$current_user_id = \Drupal::currentUser()->id();
		
	$subscriptions = \Drupal::entityTypeManager()->getStorage('commerce_subscription')->loadByProperties([
		'uid' => $current_user_id
	]);
	
	
		if (!empty($subscriptions)) {
			foreach ($subscriptions as $subscription) {
				
				// TRUE je schedule na koniec billing obdobia
				$subscription->cancel(TRUE);
				$subscription->save();

			}
			
			$url = Url::fromRoute('user.page')->toString();
			drupal_set_message(t('Your subscription renewal was cancelled.'), 'status', TRUE);
			return new RedirectResponse($url);
			
		}
		else {
			return [
			  '#markup' => 'You do not have any subscriptions created... are you trying to hack me?!',
			];
		}

  }
  
}