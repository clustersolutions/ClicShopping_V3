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

  namespace ClicShopping\Apps\OrderTotal\TotalShipping\Module\ClicShoppingAdmin\Config\SH;

  class SH extends \ClicShopping\Apps\OrderTotal\TotalShipping\Module\ClicShoppingAdmin\Config\ConfigAbstract {

    protected $pm_code = 'TotalShipping';

    public $is_uninstallable = true;
    public $sort_order = 400;

    protected function init() {
      $this->title = $this->app->getDef('module_sh_title');
      $this->short_title = $this->app->getDef('module_sh_short_title');
      $this->introduction = $this->app->getDef('module_sh_introduction');
      $this->is_installed = defined('CLICSHOPPING_APP_ORDER_TOTAL_SHIPPING_SH_STATUS') && (trim(CLICSHOPPING_APP_ORDER_TOTAL_SHIPPING_SH_STATUS) != '');
    }

    public function install() {
      parent::install();

      if (defined('MODULE_ORDER_TOTAL_INSTALLED')) {
        $installed = explode(';', MODULE_ORDER_TOTAL_INSTALLED);
      }

      $installed[] = $this->app->vendor . '\\' . $this->app->code . '\\' . $this->code;

      $this->app->saveCfgParam('MODULE_ORDER_TOTAL_INSTALLED', implode(';', $installed));
    }

    public function uninstall() {
      parent::uninstall();

      $installed = explode(';', MODULE_ORDER_TOTAL_INSTALLED);
      $installed_pos = array_search($this->app->vendor . '\\' . $this->app->code . '\\' . $this->code, $installed);

      if ($installed_pos !== false) {
        unset($installed[$installed_pos]);

        $this->app->saveCfgParam('MODULE_ORDER_TOTAL_INSTALLED', implode(';', $installed));
      }
    }
  }