<?php
/**
 *
 *  @copyright 2008 - https://www.clicshopping.org
 *  @Brand : ClicShopping(Tm) at Inpi all right Reserved
 *  @Licence GPL 2 & MIT
 *  @licence MIT - Portion of osCommerce 2.4
 *
 *
 */

  namespace ClicShopping\Sites\Shop\Pages\Checkout\Actions\Billing;

  use ClicShopping\OM\CLICSHOPPING;
  use ClicShopping\OM\HTML;
  use ClicShopping\OM\Registry;

  class Process extends \ClicShopping\OM\PagesActionsAbstract {
    public function execute() {

      $CLICSHOPPING_MessageStack = Registry::get('MessageStack');
      $CLICSHOPPING_Customer = Registry::get('Customer');
      $CLICSHOPPING_NavigationHistory = Registry::get('NavigationHistory');
      $CLICSHOPPING_Hooks = Registry::get('Hooks');

      if (isset($_POST['action']) && ($_POST['action'] == 'process') && isset($_POST['formid']) && ($_POST['formid'] == $_SESSION['sessiontoken'])) {

// if the customer is not logged on, redirect them to the login page
        if (!$CLICSHOPPING_Customer->isLoggedOn()) {
          $CLICSHOPPING_NavigationHistory->setSnapshot();
          CLICSHOPPING::redirect('index.php', 'Account&LogIn');
        }

        if (isset($_POST['coupon']) && !is_null($_POST['coupon'])) {
          $_SESSION['coupon'] = HTML::sanitize($_POST['coupon']);
        }

        if (isset($_POST['comments']) && !is_null($_POST['comments'])) {
          $_SESSION['comments'] = HTML::sanitize($_POST['comments']);
        }

// Confirmation des conditions des vente
        if (DISPLAY_CONDITIONS_ON_CHECKOUT == 'true') {
          if (!isset($_POST['conditions']) || ($_POST['conditions'] != 1)) {
            $CLICSHOPPING_MessageStack->add(CLICSHOPPING::getDef('error_conditions_not_accepted'), 'danger', 'header');

            CLICSHOPPING::redirect('index.php', 'Checkout&Billing');
          }
        }

        $CLICSHOPPING_Hooks->call('Billing', 'Process');

        CLICSHOPPING::redirect('index.php', 'Checkout&Confirmation');

      } else {
        $CLICSHOPPING_MessageStack->add(CLICSHOPPING::getDef('error_during_process'), 'danger', 'checkout_payment');

        CLICSHOPPING::redirect('index.php', 'Checkout&Billing');
      }
    }
  }