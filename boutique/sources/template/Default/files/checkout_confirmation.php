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
  use ClicShopping\OM\CLICSHOPPING;

  if ( $CLICSHOPPING_MessageStack->exists('checkout_confirmation') ) {
    echo $CLICSHOPPING_MessageStack->get('checkout_confirmation');
  }

  if (isset($CLICSHOPPING_PM->form_action_url)) {
    $form_action_url = $CLICSHOPPING_PM->form_action_url;
  } else {
    $form_action_url = CLICSHOPPING::link('index.php', 'Checkout&Process');
  }

  require($CLICSHOPPING_Template->getTemplateFiles('breadcrumb'));
  echo HTML::form('checkout_confirmation', $form_action_url, 'post', 'class="form-inline" role="form" onsubmit="return checkCheckBox(this)"');
?>
<section class="checkout_confirmation" id="checkout_confirmation">
  <div class="contentContainer">
    <div class="contentText">
      <div class="page-header"><h1><?php echo CLICSHOPPING::getDef('heading_title_Confirmation'); ?></h1></div>
      <div class="form-group">
        <?php echo $CLICSHOPPING_Template->getBlocks('modules_checkout_confirmation'); ?>
      </div>
      </div>
    </div>
</section>
</form>
