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


  namespace ClicShopping\Apps\Configuration\Zones\Sites\ClicShoppingAdmin\Pages\Home\Actions\Zones;

  use ClicShopping\OM\HTML;
  use ClicShopping\OM\Registry;

  class DeleteConfirm extends \ClicShopping\OM\PagesActionsAbstract {
    protected $app;

    public function __construct() {
      $this->app = Registry::get('Zones');
    }

    public function execute() {

      $zone_id = HTML::sanitize($_GET['cID']);

      $this->app->db->delete('zones', ['zone_id' => (int)$zone_id]);

      $this->app->redirect('Zones&'. (isset($_GET['page']) ? 'page=' . $_GET['page'] . '&' : ''));
    }
  }