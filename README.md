Drupal 8 Commerce Abandoned Carts
This module will automatically send a email messages to users who have abandoned their Drupal Commerce carts.

On each cron run the module finds Drupal Commerce carts that have been abandoned (using configurable settings) and that the user has gone to the point in the checkout process to have entered their email address. Then the module will send an email message to the us\
er(s) to remind them that they have a cart, or ask if they had an issue during checkout.

Email messages are fully customizable. Message limits and other options are configurable in the module settings.

REQUIREMENTS:
*Mime Mail

INSTRUCTIONS:

*Install and enable module.
*Visit the configuration page at: admin/commerce/config/abandonded_carts
*To customize the email message template simply copy the commerce_abandoned_carts_email.tpl.php file from the module's theme directory into your site's default theme directory, clear the site caches and modify as needed.

NOTES:

*The module has TEST mode enable by default. Be sure to test functionality thoroughly first before turning off TEST mode and sending actual emails to users.
*Some modules may override this module's 'from name' and 'from email' setting. For example, the Drupal Mandrill Module will override these settings with the settings entered into it's configuration. See the docs or issues for any mail handling modules that you may\
 be using if you're experiencing issues with the email header values.

MORE INFO:

https://3cwebservices.com/drupal/introducing-commerce-abandoned-carts-module
