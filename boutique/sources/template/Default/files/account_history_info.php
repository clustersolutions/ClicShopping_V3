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
  use ClicShopping\OM\CLICSHOPPING;

  require($CLICSHOPPING_Template->getTemplateFiles('breadcrumb'));
?>
<section class="account_history_info" id="account_history_info">
  <div class="contentContainer">
    <div class="contentText">
      <div class="page-header"><h1><?php echo CLICSHOPPING::getDef('heading_title_history_information'); ?></h1></div>
      <?php echo $CLICSHOPPING_Template->getBlocks('modules_account_customers'); ?>
    </div>
  </div>
</section>