<?php
if ( !is_admin() || ! defined( 'WPINC' ) || ! defined('REALLY_SIMPLE_GA_VERSION')) {
	die;
}

// add top level menu page
add_submenu_page('options-general.php', __('Really Simple GA', 'really-simple-ga'), __('Really Simple GA', 'really-simple-ga'), 'manage_options',	'really-simple-ga', 'rsga_admin_option_cb' );

function rsga_admin_option_cb() {
  // check user capabilities
  if ( ! current_user_can( 'manage_options' ) ) {
    return;
  }
  
  //if form submited
  if( isset($_POST['rsga_submit_btn']) && isset($_POST['rsga_nonce']) && wp_verify_nonce($_POST['rsga_nonce'], 'rsga_security')) {
      $error = '';
      $success = '';

      $analytics_code = sanitize_text_field($_POST['rsga_analytics_code']);
      if( $analytics_code != ''){
          update_option( 'rsga_google_anaytics_code', $analytics_code );
          if( $success == ''){
              $success .= '<div class="notice notice-success is-dismissible"><p><strong>'.__('Google analytics code saved successfully.','really-simple-ga').'</strong></p></div>';
          }
      }else{
          delete_option( 'rsga_google_anaytics_code' );
      }
      
  }
  ?>
<!-- Our admin page content should all be inside .wrap -->
<div class="wrap">
    <!-- Print the page title -->
    <h1><?php _e('Really Simple GA', 'really-simple-ga'); ?></h1>
    <?php
    if($success != ''){ echo $success; }
    if($error != ''){ echo $error; }
    ?>

    <form action="<?php echo basename($_SERVER['REQUEST_URI']);; ?>" method="post">
        <?php wp_nonce_field('rsga_security', 'rsga_nonce'); ?>
        <table class="form-table" role="presentation">
            <tbody>
                <tr>
                    <th scope="row"><label for="set_google_anaytics_code"><?php _e('Google analytics code:', 'really-simple-ga'); ?></label>
                    </th>
                    <td>
                        <?php 
                            $ga_analytics_code = '';
                            //get default
                            if( get_option( 'rsga_google_anaytics_code' ) ) {
                                $ga_analytics_code = get_option( 'rsga_google_anaytics_code' );
                            }
                        ?>
                        <input name="rsga_analytics_code" type="text" id="rsga_analytics_code" value="<?php echo $ga_analytics_code; ?>" class="regular-text">
                        <p class="description" id="rsga_analytics_code-description"><?php _e('It looks like: <strong>UA-XXXXX-Y', 'really-simple-ga'); ?></strong></p>
                    </td>
                </tr>

            </tbody>
        </table>
        <?php submit_button( 'Save Changes', 'primary', 'rsga_submit_btn'); ?>
    </form>
</div>
<?php
}