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
  use ClicShopping\OM\HTML;

  $CLICSHOPPING_PageManagerShop = Registry::get('PageManagerShop');

  $id = HTML::sanitize($_GET['pages_id']);
  $page = $CLICSHOPPING_PageManagerShop->pageManagerDisplayInformation($id);
  $page_title = $CLICSHOPPING_PageManagerShop->pageManagerDisplayTitle($id);

  const HEADING_TITLE = '';
  require($CLICSHOPPING_Template->getTemplateFiles('breadcrumb'));
?>
<section class="information" id="information">
  <div class="contentContainer">
    <div class="contentText">
      <div class="page-header pageManagerHeader">
        <h1><?php echo $page_title; ?></h1>
      </div>
      <div class="pageManager"><?php echo $page; ?></div>
    </div>
  </div>
</section>