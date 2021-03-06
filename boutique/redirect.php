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
  use ClicShopping\OM\HTTP;
  use ClicShopping\OM\CLICSHOPPING;
  use ClicShopping\OM\Registry;

  require('includes/application_top.php');

  $CLICSHOPPING_Language = Registry::get('Language');
  $CLICSHOPPING_Db = Registry::get('Db');
  $CLICSHOPPING_Service = Registry::get('Service');
  $CLICSHOPPING_Banner = Registry::get('Banner');
  $CLICSHOPPING_Manufacturer = Registry::get('Manufacturer');

  switch ($_GET['action']) {
    case 'banner':
      $Qbanner = $CLICSHOPPING_Db->get('banners', 'banners_url', ['banners_id' => HTML::sanitize($_GET['goto'])]);

       if ($Qbanner->fetch() !== false) {
        if (!empty($Qbanner->value('banners_url'))) {
          if ($CLICSHOPPING_Service->isStarted('Banner') ) {
            $CLICSHOPPING_Banner->updateBannerClickCount($_GET['goto']);
            HTTP::redirect($Qbanner->value('banners_url'));
          }
        }
      }
    break;

    case 'url':
      if (isset($_GET['goto']) && !is_null($_GET['goto'])) {

        $Qcheck = $CLICSHOPPING_Db->get('products_description', 'products_url', ['products_url' => HTML::sanitize($_GET['goto'])],
                                                                                null,
                                                                                1
                                       );

        if ($Qcheck->fetch() !== false) {
          HTTP::redirect('https:://' . $Qcheck->value('products_url'));
        }
      }

    break;

    case 'manufacturer':
      if ($CLICSHOPPING_Manufacturer->getID() && is_numeric($CLICSHOPPING_Manufacturer->getID())) {

       $Qmanufacturer = $CLICSHOPPING_Db->get('manufacturers_info',
                                              'manufacturers_url', ['manufacturers_id' => $CLICSHOPPING_Manufacturer->getID(),
                                                                   'languages_id' => $CLICSHOPPING_Language->getId()
                                                                   ]
                                             );

        if ($Qmanufacturer->fetch() !== false) {

// url exists in selected language
          if (!empty($Qmanufacturer->value('manufacturers_url'))) {
            $Qupdate = $CLICSHOPPING_Db->prepare('update :table_manufacturers_info
                                                  set url_clicked = url_clicked+1,
                                                     date_last_click = now()
                                                  where manufacturers_id = :manufacturers_id
                                                  and languages_id = :languages_id
                                                ');

            $Qupdate->bindInt(':manufacturers_id', $CLICSHOPPING_Manufacturer->getID());
            $Qupdate->bindInt(':languages_id', $CLICSHOPPING_Language->getId());
            $Qupdate->execute();

            HTTP::redirect($Qmanufacturer->value('manufacturers_url'));
          }

        } else {

// no url exists for the selected language, lets use the default language then
          $Qmanufacturer = $CLICSHOPPING_Db->prepare('select mi.languages_id,
                                                             mi.manufacturers_url
                                                      from :table_manufacturers_info mi,
                                                           :table_languages l
                                                      where mi.manufacturers_id = :manufacturers_id
                                                      and mi.languages_id = l.languages_id
                                                      and l.code = :default_language
                                                    ');

          $Qmanufacturer->bindInt(':manufacturers_id', $CLICSHOPPING_Manufacturer->getID());
          $Qmanufacturer->bindValue(':default_language', DEFAULT_LANGUAGE);
          $Qmanufacturer->execute();


          if ($Qmanufacturer->fetch() !== false) {
            if (!empty($Qmanufacturer->value('manufacturers_url'))) {

              $Qupdate = $CLICSHOPPING_Db->prepare('update :table_manufactuers_info
                                                    set url_clicked = url_clicked+1,
                                                        date_last_click = now()
                                                    where manufacturers_id = :manufacturers_id
                                                    and languages_id = :languages_id
                                                  ');

              $Qupdate->bindInt(':manufacturers_id', $CLICSHOPPING_Manufacturer->getID());
              $Qupdate->bindInt(':languages_id', $Qmanufacturer->valueInt('languages_id'));
              $Qupdate->execute();

              HTTP::redirect($Qmanufacturer->value('manufacturers_url'));
            }
          } // end $Qmanufacturer->fetch()
        } // end else
      } // is numeric

      break;
  }

  CLICSHOPPING::redirect('index.php');

