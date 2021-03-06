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
  use ClicShopping\OM\Registry;
  use ClicShopping\OM\ObjectInfo;

  use ClicShopping\Sites\ClicShoppingAdmin\HTMLOverrideAdmin;

  use ClicShopping\Apps\Catalog\Suppliers\Classes\ClicShoppingAdmin\SupplierAdmin;

  Registry::set('SupplierAdmin', new SupplierAdmin());
  $CLICSHOPPING_SupplierAdmin = Registry::get('SupplierAdmin');
  $CLICSHOPPING_ProductsAdmin = Registry::get('ProductsAdmin');
  $CLICSHOPPING_Language = Registry::get('Language');
  $CLICSHOPPING_Address = Registry::get('Address');
  $CLICSHOPPING_Suppliers = Registry::get('Suppliers');

  $CLICSHOPPING_Page = Registry::get('Site')->getPage();

  $form_action = 'Insert';

  if ( (isset($_GET['Edit']) && isset($_GET['mID']) && !empty($_GET['mID']))) {
    $form_action = 'Update';
    $variable =  '&mID=' . $_GET['mID'];
  }
?>
  <div class="contentBody">
    <div class="row">
      <div class="col-md-12">
        <div class="card card-block headerCard">
          <div class="row">
            <span class="col-md-1 logoHeading"><?php echo HTML::image($CLICSHOPPING_Template->getImageDirectory() . '/categories/suppliers.gif', $CLICSHOPPING_Suppliers->getDef('heading_title'), '40', '40'); ?></span>
            <span class="col-md-4 pageHeading"><?php echo '&nbsp;' . $CLICSHOPPING_Suppliers->getDef('heading_title'); ?></span>
            <span class="col-md-7 text-md-right">
<?php
  echo HTML::form ('suppliers',  $CLICSHOPPING_Suppliers->link('Suppliers&' . $form_action . $variable) );
  if ($form_action == 'Update') echo HTML::hiddenField('suppliers_id', $_GET['mID']);

  echo HTML::button($CLICSHOPPING_Suppliers->getDef('button_cancel'), null, $CLICSHOPPING_Suppliers->link('Suppliers&page=' . $_GET['page'] . '&mID=' . $_GET['mID']), 'warning') .'&nbsp;';
  echo (($form_action == 'Insert') ? HTML::button($CLICSHOPPING_Suppliers->getDef('button_insert'), null, null, 'success') : HTML::button($CLICSHOPPING_Suppliers->getDef('button_update'), null, null, 'success'));
?>
            </span>
          </div>
        </div>
      </div>
    </div>
    <div class="separator"></div>
<?php
  if ( (isset($_GET['Edit']) && isset($_GET['mID']) && !empty($_GET['mID']))) {

    $Qsuppliers = $CLICSHOPPING_Suppliers->db->prepare('select *
                                                  from :table_suppliers
                                                  where suppliers_id = :suppliers_id
                                                ');
    $Qsuppliers->bindInt(':suppliers_id',(int)$_GET['mID']);
    $Qsuppliers->execute();

    $suppliers = $Qsuppliers->fetch();

    $mInfo = new ObjectInfo($Qsuppliers->toArray());

  } else {
    $mInfo = new ObjectInfo(array());
  }

  echo HTMLOverrideAdmin::getCkeditor();
?>
    <div id="suppliersTabs" style="overflow: auto;">
      <ul class="nav nav-tabs flex-column flex-sm-row" role="tablist"  id="myTab">
        <li class="nav-item"><?php echo '<a href="#tab1" role="tab" data-toggle="tab" class="nav-link active">' . $CLICSHOPPING_Suppliers->getDef('tab_general') . '</a>'; ?></li>
        <li class="nav-item"><?php echo '<a href="#tab2" role="tab" data-toggle="tab" class="nav-link">' . $CLICSHOPPING_Suppliers->getDef('tab_suppliers_note'); ?></a></li>
        <li class="nav-item"><?php echo '<a href="#tab3" role="tab" data-toggle="tab" class="nav-link">' . $CLICSHOPPING_Suppliers->getDef('tab_visuel'); ?></a></li>
      </ul>

      <div class="tabsClicShopping">
        <div class="tab-content">
<?php
// -- ------------------------------------------------------------ //
// --          ONGLET Information Général de la Marque          //
// -- ------------------------------------------------------------ //
?>
          <div class="tab-pane active" id="tab1">
            <div class="col-md-12 mainTitle">
              <div class="float-md-left"><?php echo $CLICSHOPPING_Suppliers->getDef('title_suppliers_general'); ?></div>
            </div>
            <div class="adminformTitle">

              <div class="row">
                <div class="col-md-5">
                  <div class="form-group row">
                    <label for="<?php echo $CLICSHOPPING_Suppliers->getDef('text_suppliers_name'); ?>" class="col-5 col-form-label"><?php echo $CLICSHOPPING_Suppliers->getDef('text_suppliers_name'); ?></label>
                    <div class="col-md-5">
                      <?php echo  HTML::inputField('suppliers_name',  $mInfo->suppliers_name, 'required aria-required="true" id="suppliers_name"'); ?>
                    </div>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group row">
                    <label for="<?php echo $CLICSHOPPING_Suppliers->getDef('text_suppliers_manager'); ?>" class="col-5 col-form-label"><?php echo $CLICSHOPPING_Suppliers->getDef('text_suppliers_manager'); ?></label>
                    <div class="col-md-5">
                      <?php echo HTML::inputField('suppliers_manager', $mInfo->suppliers_manager); ?>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-5">
                  <div class="form-group row">
                    <label for="<?php echo $CLICSHOPPING_Suppliers->getDef('text_suppliers_phone'); ?>" class="col-5 col-form-label"><?php echo $CLICSHOPPING_Suppliers->getDef('text_suppliers_phone'); ?></label>
                    <div class="col-md-5">
                      <?php echo  HTML::inputField('suppliers_phone',  $mInfo->suppliers_phone); ?>
                    </div>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group row">
                    <label for="<?php echo $CLICSHOPPING_Suppliers->getDef('text_suppliers_fax'); ?>" class="col-5 col-form-label"><?php echo $CLICSHOPPING_Suppliers->getDef('text_suppliers_fax'); ?></label>
                    <div class="col-md-5">
                      <?php echo HTML::inputField('suppliers_fax', $mInfo->suppliers_fax); ?>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-5">
                  <div class="form-group row">
                    <label for="<?php echo $CLICSHOPPING_Suppliers->getDef('text_suppliers_email_address'); ?>" class="col-5 col-form-label"><?php echo $CLICSHOPPING_Suppliers->getDef('text_suppliers_email_address'); ?></label>
                    <div class="col-md-5">
                      <?php echo  HTML::inputField('suppliers_email_address',  $mInfo->suppliers_email_address); ?>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-5">
                  <div class="form-group row">
                    <label for="<?php echo $CLICSHOPPING_Suppliers->getDef('text_suppliers_address'); ?>" class="col-5 col-form-label"><?php echo $CLICSHOPPING_Suppliers->getDef('text_suppliers_address'); ?></label>
                    <div class="col-md-5">
                      <?php echo HTML::inputField('suppliers_address', $mInfo->suppliers_address); ?>
                    </div>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group row">
                    <label for="<?php echo $CLICSHOPPING_Suppliers->getDef('text_suppliers_suburb'); ?>" class="col-5 col-form-label"><?php echo $CLICSHOPPING_Suppliers->getDef('text_suppliers_suburb'); ?></label>
                    <div class="col-md-5">
                      <?php echo  HTML::inputField('suppliers_suburb',  $mInfo->suppliers_suburb); ?>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-5">
                  <div class="form-group row">
                    <label for="<?php echo $CLICSHOPPING_Suppliers->getDef('text_suppliers_postcode'); ?>" class="col-5 col-form-label"><?php echo $CLICSHOPPING_Suppliers->getDef('text_suppliers_postcode'); ?></label>
                    <div class="col-md-5">
                      <?php echo HTML::inputField('suppliers_postcode', $mInfo->suppliers_postcode); ?>
                    </div>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group row">
                    <label for="<?php echo $CLICSHOPPING_Suppliers->getDef('text_suppliers_city'); ?>" class="col-5 col-form-label"><?php echo $CLICSHOPPING_Suppliers->getDef('text_suppliers_city'); ?></label>
                    <div class="col-md-5">
                      <?php echo  HTML::inputField('text_suppliers_city',  $mInfo->text_suppliers_city); ?>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-5">
                  <div class="form-group row">
                    <label for="<?php echo $CLICSHOPPING_Suppliers->getDef('text_suppliers_country'); ?>" class="col-5 col-form-label"><?php echo $CLICSHOPPING_Suppliers->getDef('text_suppliers_country'); ?></label>
                    <div class="col-md-5">
<?php
  if ($error === true) {
    if ($entry_country_error === true) {
      echo  HTML::selectMenuCountryList('suppliers_country_id', $mInfo->suppliers_country_id)  . '&nbsp;' . $CLICSHOPPING_Suppliers->getDef('entry_country_error');
    } else {
      echo $CLICSHOPPING_Address->getCountryName($mInfo->suppliers_country_id) . HTML::hiddenField('suppliers_country_id');
    }
  } else {
    echo HTML::selectMenuCountryList('suppliers_country_id', $mInfo->suppliers_country_id) ;
  }
?>
                    </div>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group row">
                    <label for="<?php echo $CLICSHOPPING_Suppliers->getDef('text_suppliers_states'); ?>" class="col-5 col-form-label"><?php echo $CLICSHOPPING_Suppliers->getDef('text_suppliers_states'); ?></label>
                    <div class="col-md-5">
                      <?php echo HTML::inputField('suppliers_states', $mInfo->suppliers_states); ?>
                    </div>
                  </div>
                </div>
              </div>

              <div class="spaceRow"></div>
              <div class="row">
                <div class="col-md-12">
                  <span class="col-md-2 centerInputFields"><?php echo $CLICSHOPPING_Suppliers->getDef('text_suppliers_url'); ?></span>
                </div>
              </div>

<?php
  $languages = $CLICSHOPPING_Language->getLanguages();

  for ($i=0, $n=count($languages); $i<$n; $i++) {
?>
              <div class="form-group row">
                <label for="code" class="col-2 col-form-label"><?php echo $CLICSHOPPING_Language->getImage($languages[$i]['code']); ?></label>
                <div class="col-md-5">
                  <?php echo HTML::inputField('suppliers_url[' . $languages[$i]['id'] . ']', $CLICSHOPPING_SupplierAdmin->getSupplierUrl($mInfo->suppliers_id, $languages[$i]['id'])) ?>
                </div>
              </div>
<?php
  }
?>
            </div>
          </div>
<!-- //################################################################################################################ -->
<!--          ONGLET Information note complementaire          //-->
<!-- //################################################################################################################ -->
          <div class="tab-pane" id="tab2">
            <div class="col-md-12 mainTitle">
              <div class="float-md-left"><?php echo $CLICSHOPPING_Suppliers->getDef('title_suppliers_general'); ?></div>
            </div>
            <div class="adminformTitle">
              <div class="row">
                <div class="col-md-5">
                  <div class="form-group row">
                    <label for="<?php echo $CLICSHOPPING_Suppliers->getDef('text_suppliers_notes'); ?>" class="col-5 col-form-label"><?php echo $CLICSHOPPING_Suppliers->getDef('text_suppliers_notes'); ?></label>
                    <div class="col-md-5">
                      <?php echo  HTML::textAreaField('suppliers_notes', $mInfo->suppliers_notes, 70,10); ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
<!-- //################################################################################################################ -->
<!--          ONGLET Information visuelle          //-->
<!-- //################################################################################################################ -->
          <div class="tab-pane" id="tab3">
            <div class="mainTitle"><?php echo $CLICSHOPPING_Suppliers->getDef('title_suppliers_image'); ?></div>
            <div class="adminformTitle">
              <div class="row">
                <div class="col-md-12">
                  <span class="col-md-1"><?php echo HTML::image($CLICSHOPPING_Template->getImageDirectory() . '/images_product.gif', $CLICSHOPPING_Suppliers->getDef('text_products_image_vignette'), '40', '40'); ?></span>
                  <span class="col-md-3 main"><?php echo $CLICSHOPPING_Suppliers->getDef('text_products_image_vignette'); ?></span>
                  <span class="col-md-1"><?php echo HTML::image($CLICSHOPPING_Template->getImageDirectory() . '/images_product.gif', $CLICSHOPPING_Suppliers->getDef('text_products_image_visuel'), '40', '40'); ?></span>
                  <span class="col-md-7 main"><?php echo $CLICSHOPPING_Suppliers->getDef('text_products_image_visuel'); ?></span>
                </div>
                <div class="col-md-12">
                  <div class="adminformAide">
                    <div class="row">
                      <span class="col-md-4 text-md-center float-md-left"><?php echo HTMLOverrideAdmin::fileFieldImageCkEditor('suppliers_image', '212', '212',null); ?></span>
                      <span class="col-md-8 text-md-center float-md-right">
                        <div class="col-md-12">
                          <?php echo $CLICSHOPPING_ProductsAdmin->getInfoImage($mInfo->suppliers_image, $CLICSHOPPING_Suppliers->getDef('text_products_image_vignette')); ?>
                         </div>
                        <div class="col-md-12 text-md-right">
                          <?php echo $CLICSHOPPING_Suppliers->getDef('text_suppliers_delete_image') . HTML::checkboxField('delete_image', 'yes', false); ?>
                        </div>
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="separator"></div>
            <div class="alert alert-info">
              <div><?php echo HTML::image($CLICSHOPPING_Template->getImageDirectory() . 'icons/help.gif', $CLICSHOPPING_Suppliers->getDef('title_help_image')) . ' ' . $CLICSHOPPING_Suppliers->getDef('title_help_image') ?></div>
              <div class="separator"></div>
              <div><?php echo $CLICSHOPPING_Suppliers->getDef('help_image_suppliers'); ?></div>
            </div>
          </div>
        </div>
        <div class="separator"></div>
        <?php echo $CLICSHOPPING_Hooks->output('Catalog', 'SuppliersTab4', null, 'display'); ?>
      </div>
    </div>
  </div>
</form>
</div>

