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

  namespace ClicShopping\Sites\Shop\Pages\Account\Actions;

  use ClicShopping\OM\CLICSHOPPING;
  use ClicShopping\OM\Registry;
  use ClicShopping\OM\HTML;
  use ClicShopping\Sites\Shop\AddressBook;

  class AddressBookProcess extends \ClicShopping\OM\PagesActionsAbstract {

    private function CustomerAddress() {
      $Qentry = AddressBook::getEntry((int)$_GET['edit']);

      return $Qentry;
    }

    public function execute() {
      global $exists, $entry;

      $CLICSHOPPING_Customer = Registry::get('Customer');
      $CLICSHOPPING_Breadcrumb= Registry::get('Breadcrumb');
      $CLICSHOPPING_Template = Registry::get('Template');
      $CLICSHOPPING_NavigationHistory = Registry::get('NavigationHistory');
      $CLICSHOPPING_Language = Registry::get('Language');
      $CLICSHOPPING_Hooks = Registry::get('Hooks');

      $CLICSHOPPING_Hooks->call('AddressBookProcess', 'PreAction');

      if (!$CLICSHOPPING_Customer->isLoggedOn()) {
        $CLICSHOPPING_NavigationHistory->setSnapshot();
        CLICSHOPPING::redirect('index.php', 'Account&LogIn');
      }

      $new_customer = HTML::sanitize($_GET['newcustomer']);

      if ($new_customer == 1) {
        if (!empty($CLICSHOPPING_Customer->getDefaultAddressID()))  {
          $_GET['edit'] = $CLICSHOPPING_Customer->getDefaultAddressID();
        }
      }

      $exists = false;

      $entry = $this->CustomerAddress();

      if ( $entry !== false ) {
        $exists = true;
      }


// templates
      $this->page->setFile('address_book_process.php');
//Content
      $this->page->data['content'] = $CLICSHOPPING_Template->getTemplateFiles('address_book_process');
//language
      $CLICSHOPPING_Language->loadDefinitions('address_book_process');

      $CLICSHOPPING_Breadcrumb->add(CLICSHOPPING::getDef('navbar_title_1'), CLICSHOPPING::link('index.php', 'Account&Main'));
      $CLICSHOPPING_Breadcrumb->add(CLICSHOPPING::getDef('navbar_title_2'), CLICSHOPPING::link('index.php', 'Account&AddressBook'));
    }
  }
