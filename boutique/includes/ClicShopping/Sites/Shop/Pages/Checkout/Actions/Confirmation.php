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

  namespace ClicShopping\Sites\Shop\Pages\Checkout\Actions;

  use ClicShopping\OM\HTML;
  use ClicShopping\OM\CLICSHOPPING;
  use ClicShopping\OM\Registry;
  use ClicShopping\Sites\Shop\Payment;
  use ClicShopping\Sites\Shop\Shipping;

  class Confirmation extends \ClicShopping\OM\PagesActionsAbstract {

    public function execute() {
      global $form_action_url, $payment, $CLICSHOPPING_Shipping, $button_payment_module, $CLICSHOPPING_PM, $output_total_modules;

      $CLICSHOPPING_Customer = Registry::get('Customer');
      $CLICSHOPPING_ShoppingCart = Registry::get('ShoppingCart');
      $CLICSHOPPING_NavigationHistory = Registry::get('NavigationHistory');
      $CLICSHOPPING_Breadcrumb = Registry::get('Breadcrumb');
      $CLICSHOPPING_Template = Registry::get('Template');
      $CLICSHOPPING_OrderTotal = Registry::get('OrderTotal');
      $CLICSHOPPING_ProductsCommon = Registry::get('ProductsCommon');
      $CLICSHOPPING_Language = Registry::get('Language');

// if there is nothing in the customers cart, redirect them to the shopping cart page
      if ($CLICSHOPPING_ShoppingCart->count_contents() < 1) {
        CLICSHOPPING::redirect('index.php', 'Cart');
      }

// if the customer is not logged on, redirect them to the login page
      if (!$CLICSHOPPING_Customer->isLoggedOn()) {
        $CLICSHOPPING_NavigationHistory->setSnapshot(array('mode' => null, 'page' => 'Checkout&Billing'));
        CLICSHOPPING::redirect('index.php', 'Account&LogIn');
      }

// avoid hack attempts during the checkout procedure by checking the internal cartID
      if (isset($CLICSHOPPING_ShoppingCart->cartID) && isset($_SESSION['cartID'])) {
        if ($CLICSHOPPING_ShoppingCart->cartID != $_SESSION['cartID']) {
          CLICSHOPPING::redirect('index.php', 'Checkout&Shipping');
        }
      }

// if no shipping method has been selected, redirect the customer to the shipping method selection page
      if (!isset($_SESSION['shipping'])) {
        CLICSHOPPING::redirect('index.php', 'Checkout&Shipping');
      }

      if (isset($_POST['payment'])) $_SESSION['payment'] = $_POST['payment'];

      if (isset($_POST['comments'])) {
        $_SESSION['comments'] = null;
        if (!is_null($_POST['comments'])) {
          $_SESSION['comments'] = HTML::sanitize($_POST['comments']);
        }
      }

// Confirmation des conditions des vente
      if (DISPLAY_CONDITIONS_ON_CHECKOUT == 'true') {
        if (!isset($_POST['conditions']) || ($_POST['conditions'] != 1)) {
          $message = CLICSHOPPING::getDef('error_conditions_not_accepted');

          CLICSHOPPING::redirect('index.php', 'Checkout&Billing&error_message=' . urlencode($message));
        }
      }

       if (!isset($_SESSION['coupon'])) {
         $_SESSION['coupon'] = HTML::sanitize($_POST['coupon']);
       }

//this needs to be set before the order object is created, but we must process it after
      if (isset($_SESSION['coupon'])) {
        $coupon = null;

        if (!is_null($_SESSION['coupon'])) {
          $_SESSION['coupon'] = HTML::sanitize($_SESSION['coupon']);
        }
      }

// load the selected payment module
      Registry::set('Payment', new Payment($_SESSION['payment']));
      $CLICSHOPPING_Payment = Registry::get('Payment');

// must be always before coupon
      $CLICSHOPPING_Order = Registry::get('Order');

      $CLICSHOPPING_Payment->update_status();

      if (strpos($CLICSHOPPING_Payment->selected_module, '\\') !== false) {

        $code = 'Payment_' . str_replace('\\', '_', $CLICSHOPPING_Payment->selected_module);

        if (Registry::exists($code)) {
          $CLICSHOPPING_PM = Registry::get($code);
        }

      } elseif (isset($_SESSION['payment']) && is_object($GLOBALS[$_SESSION['payment']])) {
        $CLICSHOPPING_PM = $GLOBALS[$_SESSION['payment']];
      }

      if ( !isset($CLICSHOPPING_PM) || ($CLICSHOPPING_Payment->selected_module != $_SESSION['payment']) || ($CLICSHOPPING_PM->enabled === false) ) {
        CLICSHOPPING::redirect('index.php', 'Checkout&Billing&error_message=' . urlencode(CLICSHOPPING::getDef('error_no_payment_module_selected')));
      }

      if (is_array($CLICSHOPPING_Payment->modules)) {
        $CLICSHOPPING_Payment->pre_confirmation_check();
      }

// discount coupons
      if (isset( $_SESSION['coupon']) && is_object($CLICSHOPPING_Order->coupon) ) {

// erreur quand le nbr de coupon permis = 0 et debug = false
        if(CLICSHOPPING_APP_ORDER_TOTAL_DISCOUNT_COUPON_DC_DEBUG == 'False') {
          if( $CLICSHOPPING_Order->coupon->getErrors() ) {

            if( isset($_SESSION['coupon']) ) unset($_SESSION['coupon']);
            $message = implode( ' ', $CLICSHOPPING_Order->coupon->getDisplayMessages());

            CLICSHOPPING::redirect('index.php', 'Checkout&Billing&error_message=' . urlencode($message));
          }
        }
      }

// load the selected shipping module
      Registry::set('Shipping', new Shipping($_SESSION['shipping']));
      $CLICSHOPPING_Shipping = Registry::get('Shipping');

      $CLICSHOPPING_OrderTotal->process();

      $output_total_modules = $CLICSHOPPING_OrderTotal->output();

// Stock Check
      $any_out_of_stock = false;

      if (STOCK_CHECK == 'true') {
        for ($i=0, $n=count($CLICSHOPPING_Order->products); $i<$n; $i++) {
          if ($CLICSHOPPING_ProductsCommon->getCheckStock($CLICSHOPPING_Order->products[$i]['id'], $CLICSHOPPING_Order->products[$i]['qty'])) {
            $any_out_of_stock = true;
          }
        }
        // Out of Stock
        if ( (STOCK_ALLOW_CHECKOUT != 'true') && ($any_out_of_stock === true) ) {
          CLICSHOPPING::redirect('index.php', 'Cart');
        }
      }

      $CLICSHOPPING_Language->loadDefinitions('checkout_confirmation');

// Payment Management Url redirection
      if (isset($CLICSHOPPING_PM->form_action_url)) {
        $form_action_url = $CLICSHOPPING_PM->form_action_url;
      } else {
        $form_action_url = CLICSHOPPING::link('index.php', 'Checkout&Process');
      }

// Modification suite atos
      if (is_array($CLICSHOPPING_Payment->modules)) {
        $confirmation = $CLICSHOPPING_Payment->confirmation();
      }

// Detection si atos est installe verifier si le code a la ligne 341 est Ok : Atos module
  if ( substr($payment, 0, 4) == 'atos' ) {
    if (isset($GLOBALS[$payment]->form_submit)) {
      $button_payment_module = $GLOBALS[$payment]->form_submit;
    } else {
      $button_payment_module =  HTML::button(CLICSHOPPING::getDef('button_confirm'), null, null, 'primary');
    }
     $button_payment_module . '</form>' . "\n";
  }

// templates
      $this->page->setFile('checkout_confirmation.php');
//Content
      $this->page->data['content'] = $CLICSHOPPING_Template->getTemplateFiles('checkout_confirmation');
//language
      $CLICSHOPPING_Language->loadDefinitions('checkout_confirmation');

      $CLICSHOPPING_Breadcrumb->add(CLICSHOPPING::getDef('navbar_title_1'), CLICSHOPPING::link('index.php', 'Checkout&Shipping'));
      $CLICSHOPPING_Breadcrumb->add(CLICSHOPPING::getDef('navbar_title_2'));

    }
  }