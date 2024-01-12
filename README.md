# Drupal License - Cancel Subscription

## What does this module do?
This module registers new route /cancel_subscription to cancel existing subscription for an user. This functionality is baked into Commerce License module but never actually used anywhere in the module.

## Requirements
- Drupal License
- Drupal 8 / 9 (not tested in 9 but it should work)

## Installation
To install this module you will want to put the source in the [appropriate directory](https://www.drupal.org/docs/8/extending-drupal-8/installing-modules#mod_location).
After you have placed the module there, simply enable it as you would any other module.

## Configuring
You need to set-up cron tasks to run periodically since this module rely on cron run and evaluates expired subscriptions on cron run.

No further configuration is needed. Simply enabling the module and clearing the cache should do the trick. Module does no change to database tables so removing the module is done by uninstalling and deleting the folder. Easy as that.
