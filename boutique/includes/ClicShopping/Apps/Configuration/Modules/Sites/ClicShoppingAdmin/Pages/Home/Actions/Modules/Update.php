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


  namespace ClicShopping\Apps\Configuration\Modules\Sites\ClicShoppingAdmin\Pages\Home\Actions\Modules;

  use ClicShopping\OM\Registry;
  use ClicShopping\OM\CLICSHOPPING;
  use ClicShopping\OM\Cache;

  class Update extends \ClicShopping\OM\PagesActionsAbstract {
    protected $app;

    public function __construct() {
      $this->app = Registry::get('Modules');
    }

    public function execute() {
      $CLICSHOPPING_Modules = Registry::get('Modules');
      $CLICSHOPPING_Db = Registry::get('Db');

      if (isset($_GET['Update'])) {
        $set = (isset($_GET['set']) ? $_GET['set'] : '');

        foreach( $_POST['configuration'] as $key => $value ) {
          if((is_array($value)) && (!empty($value))){
            $key = HTML::sanitize($key);
            $value = HTML::sanitize($value);

            $pages = '';
            $count = count($value);

            for($i=0 ; $i<$count; $i++){

              $pages = "$pages$value[$i]";

              $CLICSHOPPING_Db->save('configuration', ['configuration_value' => $pages], ['configuration_key' => $key]);
            }
          } else {
            $CLICSHOPPING_Db->save('configuration', ['configuration_value' => $value], ['configuration_key' => $key]);
          }
        }

        Cache::clear('configuration');

        $CLICSHOPPING_Modules->redirect('Modules&set=' . $set . '&module=' . $_GET['module']);
      }
    }
  }