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

  use ClicShopping\OM\Registry;
  use ClicShopping\OM\CLICSHOPPING;

  class CfgmModulesCheckoutConfirmation {
    public $code = 'modules_checkout_confirmation';
    public $directory;
    public $language_directory;
    public $site = 'Shop';
    public $key = 'MODULE_MODULES_CHECKOUT_CONFIRMATION_INSTALLED';
    public $title;
    public $template_integration = true;

    public function __construct() {
      $CLICSHOPPING_Template = Registry::get('TemplateAdmin');

      $this->directory = $CLICSHOPPING_Template->getDirectoryPathShopDefaultTemplateHtml() . '/modules/modules_checkout_confirmation/';
      $this->language_directory = $CLICSHOPPING_Template->getPathLanguageShopDirectory();

      $this->title = CLICSHOPPING::getDef('module_cfg_module_checkout_confirmation_title');
    }
  }

