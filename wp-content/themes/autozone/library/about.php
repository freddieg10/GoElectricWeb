<?php
function pix_add_adminpanel() {
  add_theme_page('About Theme', 'About AutoZone', 'administrator', 'adminpanel', 'adminpanel');
}


if (current_user_can('switch_themes')) {
    add_action('admin_menu', 'pix_add_adminpanel');
    include_once(get_template_directory() . '/library/theme/activation.php');
}

function adminpanel() {

  global $theme_name, $shortname, $options;
  

  $phpv = phpversion();
  $res_phpv = ( (float)$phpv < 5.6 ) ? "fa-close" : "fa-check";

  $max_execution_time = ini_get('max_execution_time');
  $res_max_execution_time = ( (int)$max_execution_time < 360 ) ? "fa-close" : "fa-check";

  $memory_limit = ini_get('memory_limit');
  $res_memory_limit = ( (int)$memory_limit < 128 ) ? "fa-close" : "fa-check";

  $post_max_size = ini_get('post_max_size');
  $res_post_max_size = ( (int)$post_max_size < 32 ) ? "fa-close" : "fa-check";

  $upload_max_filesize = ini_get('upload_max_filesize');
  $res_upload_max_filesize = ( (int)$upload_max_filesize < 32 ) ? "fa-close" : "fa-check";


if ($res_phpv == "fa-close" || $res_max_execution_time == "fa-close" || $res_memory_limit == "fa-close" || $res_post_max_size== "fa-close" || $res_upload_max_filesize == "fa-close") {
  $req_status = 'req_fail';
}else{
  $req_status = '';
}




  $envatoCode = get_theme_mod('pixtheme_licence_settings_code') ? get_theme_mod('pixtheme_licence_settings_code') : '' ;
  $option_name = 'pixtheme_licence_is_activated';
  $option_name_code = 'pixtheme_licence_code';
  $flag_activate = pixtheme_check_is_activated();
  $desc_active = get_theme_mod('activ_theme_desc') ? get_theme_mod('activ_theme_desc') : '';

  
  $class_not_activate = !$flag_activate ? 'theme-not-activated' : '';
  $html_support = "<div class='pix_about_block_description desc_renew_support'>" . esc_html__("Your support has expired. ", 'autozone') . "</div>
  
  
   <p>" . esc_html__("Unfortunately, your support period is expired but you can renew your support period  ", "autozone") . "</p>
   
  <a href='" . esc_url('https://help.market.envato.com/hc/en-us/articles/207886473-Extending-and-Renewing-Item-Support') . "' target='_blank' class='pix_about_block_link button button-primary'>" . esc_html__("Renew Support", "autozone") . "</a>
  
  
  ";

  
  if ($envatoCode){
    if ( get_option( $option_name ) != false ){
      if (get_option( $option_name_code ) == $envatoCode){
        $expiredTime = strtotime(get_option( $option_name )); 
        if ($expiredTime > time()){
          $html_support = "<div class='pix_about_block_description'>" . esc_html__("This theme comes with 6 months of free support for every license you purchase. Support can be extended through subscriptions via ThemeForest. Envato Elements does not provide technical support for this theme.", "autozone") . "</div>
          
          <a href='" . esc_url('http://support.templines.com/') . "' target='_blank' class='pix_about_block_link button button-primary'>" . esc_html__("Get Support", "autozone") . "</a>
          
          ";
        }
      }
    }
  }
  echo wp_kses_post("<div class='pix_about'>
      <div class='pix_about_header'>
          <h1 class='pix_about_title'>" . esc_html__("Welcome to AutoZone", "autozone") . "</h1>
          <div class='pix_about_description'>
              <p>" . esc_html__("Thank you for purchasing our theme.", "autozone") . "</p>
             
          </div>
      </div>
      <div id='pix_about_tabs' class='pix_tabs pix_about_tabs " . $class_not_activate . "'>
          <ul class='ui-tabs-nav pix-tabs'>
              <li class='ui-state-active'>
                  <a href='#pix_theme_about' class='ui-tabs-anchor' >" . esc_html__("Getting started", "autozone") . "</a>
              </li>
              <li>
                  <a href='#pix_theme_requirements' class='ui-tabs-anchor ". $req_status."'>" . esc_html__("Requirements", "autozone") . "</a>
              </li>
          </ul>
          <div id='pix_theme_about' class='pix_tabs_section pix_about_section'>
              <div class='pix_about_block'>
                  <div class='pix_about_block_inner'>
                      <h2 class='pix_about_block_title'>
                          <i class='dashicons dashicons-admin-network'></i>
                          " . esc_html__("Theme activation", "autozone") . "
                      </h2>
                      <div class='pix_about_block_description'>");
                          echo esc_attr(get_option('pix_theme_code'));

                         
                          if (function_exists( 'pixtheme_check_is_activated' )  ) {
                            if(pixtheme_check_is_activated() ){
        
                                
                                 echo wp_kses_post("<p class='pixtheme_check_is_activated'>" . esc_html__("Theme activated", "autozone") . "</p>");
                                
                                
                                echo wp_kses_post("<p>Reminder ! One registration per Website. If registered elsewhere please remove purchased code that registration first.</p>");
                                
                                 echo "<p><div style='display:flex'><input class='activation-input'  type='text' name='pix_code' data-activationtheme='1' value='{$envatoCode}'><a data-activationtheme='1' class='button button-primary activation-theme re-activation-theme'>" . esc_html__(' Save', 'autozone') . "</a></div><a class='wp-core-ui button-primary delete_key' style='cursor:pointer;' data-key_activate='true' >" . esc_html__('Deactivate', 'autozone') . "</a></p><p class='activated' style='display:none'>" . esc_html__("Theme activated", "autozone") . "</p>";
                                
                            }
                            else{
                                
                                echo wp_kses_post("<p class='pixtheme_check_is_not_activated'>" . esc_html__("Theme not activated", "autozone") . "</p>");
                                if($desc_active){
                                   echo wp_kses_post('<p>'.$desc_active.'</p>');
                                }else{
                                   echo wp_kses_post("<p>You can learn how to find your purchase code <a href='" . esc_url('http://support.templines.com/knowledge-base/where-can-i-find-my-purchase-code/') . "' target='_blank' >" . esc_html__("here", "autozone") . "</a>    You  will can later deactivate this code if you use dev site and using again on live version  .</p>");
                                }
                                
                                
                                
                                
                                
                               echo "<p><div style='display:flex'><input class='activation-input' type='text' name='pix_code' data-activationtheme='1' value='{$envatoCode}'><a data-activationtheme='1' class='button button-primary activation-theme'>" . esc_html__('Save', 'autozone') . "</a></div></p><p class='activated' style='display:none'>" . esc_html__("Theme activated", "autozone") . "</p>";
                            }
                          }else{
                            echo esc_html__('Add Plugins', 'autozone');
                          }
                      echo wp_kses_post("</div>
                  </div>
              </div>
             
              <div class='pix_about_block'>
                  <div class='pix_about_block_inner'>
                      <h2 class='pix_about_block_title'>
                          <i class='dashicons dashicons-book'></i>
                          " . esc_html__("Read full documentation", "autozone") . "
                      </h2>
                      <div class='pix_about_block_description'>
                          " . esc_html__("Need more details? Please check our full online documentation for detailed information on how to use autozone.", "autozone") . "
                      </div>
                      <a href='" . esc_url('https://templines.com/autozone-wordpress-theme-documentation/') . "' target='_blank' class='pix_about_block_link button button-primary'>" . esc_html__("Documentation", "autozone") . "</a>
                  </div>
              </div>");
          if ( !TGM_Plugin_Activation::get_instance()->is_tgmpa_complete() ) {
              echo wp_kses_post("<div class='pix_about_block'>
                  <div class='pix_about_block_inner'>
                      <h2 class='pix_about_block_title'>
                          <i class='dashicons dashicons-admin-plugins'></i>
                          " . esc_html__("Required plugins", "autozone") . "
                      </h2>
                      <div class='pix_about_block_description'>
                          " . esc_html__("Theme autozone is compatible with a large number of popular plugins. You can install only those that are going to use in the near future.", "autozone") . "
                      </div>
<a href='" . esc_url(admin_url('themes.php?page=tgmpa-install-plugins')) . "' class='pix_about_block_link button button-primary'>" . esc_html__("Install plugins", "autozone") . "</a>
                  </div>
              </div>");            
          }
              echo wp_kses_post("<div class='pix_about_block'>
                  <div class='pix_about_block_inner'>
                      <h2 class='pix_about_block_title'>
                          <i class='dashicons dashicons-admin-customizer'></i>
                          " . esc_html__("Demo import", "autozone") . "
                      </h2>
                      <div class='pix_about_block_description'>
                          " . esc_html__("Importing demo data (post, pages, images, theme settings, ...) is the easiest way to setup your theme.  It will allow you to quickly edit everything instead of creating content from scratch.", "autozone") . "
                      </div>
                      <a href='" . esc_url(admin_url('themes.php?page=pt-one-click-demo-import')) . "' class='pix_about_block_link button button-primary'>" . esc_html__("Import", "autozone") . "</a>
                  </div>
              </div>
              
              <div class='pix_about_block'>
                  <div class='pix_about_block_inner'>
                      <h2 class='pix_about_block_title'>
                          <i class='dashicons dashicons-admin-appearance'></i>
                          " . esc_html__("Setup Theme options", "autozone") . "
                      </h2>
                      <div class='pix_about_block_description'>
                          " . esc_html__("Using the WordPress Customizer you can easily customize every aspect of the theme. ", "autozone") . "
                      </div>
                      <a href='" . esc_url(admin_url('customize.php')) . "' class='pix_about_block_link button button-primary'>" . esc_html__("Customizer", "autozone") . "</a>
                  </div>
              </div>
              
              <div class='pix_about_block'>
                  <div class='pix_about_block_inner'>
                      <h2 class='pix_about_block_title'>
                          <i class='dashicons dashicons-admin-appearance'></i>
                          " . esc_html__("Kawara addons", "autozone") . "
                      </h2>
                      <div class='pix_about_block_description'>
                          " . esc_html__("For the construction of our theme, we use Kaswara addons . This add-on for WPBakery Page Builder (formerly Visual Composer) . With this module you can create different pages without any limits .  ", "autozone") . "
                      </div>
                      <a href='" . esc_url(admin_url('admin.php?page=kaswara-framework')) . "' class='pix_about_block_link button button-primary'>" . esc_html__("Kaswara Addons", "autozone") . "</a>
                  </div>
              </div>
              
              <div class='pix_about_block'>
                  <div class='pix_about_block_inner'>
                      <h2 class='pix_about_block_title'>
                          <i class='dashicons dashicons-sos'></i>
                          " . esc_html__("Support", "autozone") . "
                      </h2>" . $html_support . "
                  </div>
              </div>
              <div class='pix_about_block'>
                  <div class='pix_about_block_inner'>
                      <h2 class='pix_about_block_title'>
                          <i class='dashicons dashicons-images-alt2'></i>
                          " . esc_html__("On-line demo", "autozone") . "
                      </h2>
                      <div class='pix_about_block_description'>
                          " . esc_html__("Visit the Demo Version of autozone to check out all the features it has", "autozone") . "
                      </div>
                      <a href='" . esc_url('http://autozone.templines.org') . "' target='_blank' class='pix_about_block_link button button-primary'>" . esc_html__("View demo", "autozone") . "</a>
                  </div>
              </div>
          </div>

          <div id='pix_theme_requirements' class='pix_tabs_section pix_about_section' style='display: none;'>
              <div class='pix_about_block_inner requirements_inner'>
                  <h2>" . esc_html__("Theme requirements","autozone") ."</h2>
                  <p>" . esc_html__("All of our server requirements are minimal and are recommended by WordPress team .","autozone") ."</p>
<p>" . wp_kses_post("

Contact your web host and ask them to increase those limits to a minimum as follows:","autozone") ."</p>
                  <ul class='theme-requirement-list'>
                      <li>
                      
                          <code>PHP 5.6</code>
                          <i class='fa " . esc_attr($res_phpv) . "'></i>
                          <p>Currently: " . esc_attr($phpv) . "</p>
                      </li>
                      <li>
                      
                          <code>max_execution_time 360</code>
                          <i class='fa " . esc_attr($res_max_execution_time) . "'></i>
                          <p>Currently: " . esc_attr($max_execution_time) . "</p>
                      </li>
                      <li>
                       
                          <code>memory_limit 128M</code>
                         <i class='fa " . esc_attr($res_memory_limit) . "'></i>
                          <p>Currently: " . esc_attr($memory_limit) . "</p>
                      </li>
                      <li>
                     
                          <code>post_max_size 32M</code>
                           <i class='fa " . esc_attr($res_post_max_size) . "'></i>
                          <p>Currently: " . esc_attr($post_max_size) . "</p>
                      </li>
                      <li>
                     
                          <code>upload_max_filesize 32M</code>
                           <i class='fa " . esc_attr($res_upload_max_filesize) . "'></i>
                          <p>Currently: " . esc_attr($upload_max_filesize) . "</p>
                      </li>
                  </ul>
              </div>
          </div>
      </div>
  </div> ");

}
