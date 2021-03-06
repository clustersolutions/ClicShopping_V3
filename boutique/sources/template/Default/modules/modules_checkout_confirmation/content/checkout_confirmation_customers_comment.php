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
?>
<div class="col-md-<?php echo $content_width; ?>">
  <div class="col-md-12">
    <div class="separator"></div>
    <div class="page-header moduleCheckoutConfirmationCustomersCommentPageHeader"><h3><?php echo CLICSHOPPING::getDef('module_checkout_confirmation_customers_comment_heading_order_title'); ?></h3></div>
    <div class="card moduleCheckoutConfirmationCustomersCommentCard">
      <div class="card-header moduleCheckoutConfirmationCustomersCommentCardHeader"><strong><?php echo CLICSHOPPING::getDef('module_checkout_confirmation_customers_comment_heading_order_comments') ; ?></strong><?php echo $edit_comment; ?></div>
      <div class="card-block moduleCheckoutConfirmationCustomersCommentCardBlock">
        <?php echo $comment; ?>
      </div>
    </div>
  </div>
</div>
