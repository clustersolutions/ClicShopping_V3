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

use ClicShopping\OM\HTML;
  use ClicShopping\OM\Registry;;
  use ClicShopping\OM\ObjectInfo;
  use ClicShopping\OM\CLICSHOPPING;

  $CLICSHOPPING_OrdersStatus = Registry::get('OrdersStatus');
  $CLICSHOPPING_Page = Registry::get('Site')->getPage();
  $CLICSHOPPING_Language = Registry::get('Language');

  if (!isset($_GET['page']) || !is_numeric($_GET['page'])) {
    $_GET['page'] = 1;
  }
?>
<!-- body //-->
<div class="contentBody">
  <div class="row">
    <div class="col-md-12">
      <div class="card card-block headerCard">
        <div class="row">
          <span class="col-md-1 logoHeading"><?php echo HTML::image($CLICSHOPPING_Template->getImageDirectory() . '/categories/order_status.gif', $CLICSHOPPING_OrdersStatus->getDef('heading_title'), '40', '40'); ?></span>
          <span class="col-md-4 pageHeading"><?php echo '&nbsp;' . $CLICSHOPPING_OrdersStatus->getDef('heading_title'); ?></span>
          <span class="col-md-7 text-md-right"><?php echo HTML::button($CLICSHOPPING_OrdersStatus->getDef('button_insert'), null, $CLICSHOPPING_OrdersStatus->link('Insert'), 'success', null, 'xs'); ?></span>
        </div>
      </div>
    </div>
  </div>
  <div class="separator"></div>
  <table border="0" width="100%" cellspacing="0" cellpadding="2">
    <td>
      <table class="table table-sm table-hover table-striped">
        <thead>
        <tr class="dataTableHeadingRow">
          <th><?php echo $CLICSHOPPING_OrdersStatus->getDef('table_heading_orders_status'); ?></th>
          <th class="text-md-right"><?php echo $CLICSHOPPING_OrdersStatus->getDef('table_heading_action'); ?>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
<?php
      $Qstatus = $CLICSHOPPING_OrdersStatus->db->prepare('select  SQL_CALC_FOUND_ROWS  *
                                                    from :table_orders_status
                                                    where language_id = :language_id
                                                    order by orders_status_id
                                                    limit :page_set_offset,
                                                         :page_set_max_results
                                                    ');

      $Qstatus->bindInt(':language_id', $CLICSHOPPING_Language->getId() );
      $Qstatus->setPageSet((int)MAX_DISPLAY_SEARCH_RESULTS_ADMIN);
      $Qstatus->execute();

      $listingTotalRow = $Qstatus->getPageSetTotalRows();

      if ($listingTotalRow > 0) {
      while ($Qstatus->fetch()) {

      if ((!isset($_GET['oID']) || (isset($_GET['oID']) && ((int)$_GET['oID'] === $Qstatus->valueInt('orders_status_id')))) && !isset($oInfo) && (substr($action, 0, 3) != 'new')) {
        $oInfo = new ObjectInfo($Qstatus->toArray());
      }

      if (DEFAULT_ORDERS_STATUS_ID == $Qstatus->value('orders_status_id')) {
        echo '                <th scope="row"><strong>' . $Qstatus->value('orders_status_name') . ' (' . $CLICSHOPPING_OrdersStatus->getDef('text_default') . ')</strong></th>' . "\n";
      } else {
        echo '                <th scope="row">' . $Qstatus->value('orders_status_name') . '</th>' . "\n";
      }
?>
        <td class="text-md-right">
<?php
      if ($Qstatus->valueInt('orders_status_id') > 5) {
        echo '<a href="' . $CLICSHOPPING_OrdersStatus->link('Delete&page=' . $_GET['page'] . '&oID=' . $Qstatus->valueInt('orders_status_id')) . '">' . HTML::image($CLICSHOPPING_Template->getImageDirectory() . 'icons/delete.gif', $CLICSHOPPING_OrdersStatus->getDef('image_delete')) . '</a>';
      }

      echo '&nbsp;';
      echo '<a href="' . $CLICSHOPPING_OrdersStatus->link('Edit&page=' . $_GET['page'] . '&oID=' . $Qstatus->valueInt('orders_status_id')) . '">' . HTML::image($CLICSHOPPING_Template->getImageDirectory() . 'icons/edit.gif', $CLICSHOPPING_OrdersStatus->getDef('icon_edit')) . '</a>' ;
      echo '&nbsp;';
?>
        </td>
        </tbody>
        </tr>
<?php
    }
  } // end $listingTotalRow
?>
      </table>
    </td>
  </table>
<?php
  if ($listingTotalRow > 0) {
?>
      <div class="row">
        <div class="col-md-12">
          <div class="col-md-6 float-md-left pagenumber hidden-xs TextDisplayNumberOfLink"><?php echo $Qstatus->getPageSetLabel($CLICSHOPPING_OrdersStatus->getDef('text_display_number_of_link')); ?></div>
          <div class="float-md-right text-md-right"><?php echo $Qstatus->getPageSetLinks(CLICSHOPPING::getAllGET(array('page', 'info', 'x', 'y'))); ?></div>
        </div>
      </div>
<?php
  }
?>
</div>