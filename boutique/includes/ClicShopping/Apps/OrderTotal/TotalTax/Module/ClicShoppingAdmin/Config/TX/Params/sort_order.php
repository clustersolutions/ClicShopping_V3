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

  namespace ClicShopping\Apps\OrderTotal\TotalTax\Module\ClicShoppingAdmin\Config\TX\Params;

  class sort_order extends \ClicShopping\Apps\OrderTotal\TotalTax\Module\ClicShoppingAdmin\Config\ConfigParamAbstract {

//    public $sort_order = 1000;
    public $default = '900';
    public $app_configured = false;

    protected function init() {
        $this->title = $this->app->getDef('cfg_order_total_tax_sort_order_title');
        $this->description = $this->app->getDef('cfg_order_total_tax_sort_order_description');
    }
  }
