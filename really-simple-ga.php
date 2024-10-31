<?php
/**
 * Plugin Name: Really Simple GA
 * Description: It will easily add Google Analytics code to site without adding extra codes.
 * Version: 1.0.0
 * Tested up to: 5.5
 * Author: TWS Media
 * Author URI: https://tws.media
 * License: GPL v3
 * Text Domain: really-simple-ga
 * Domain Path: /languages
 */

/**
 * Really Simple GA
 */

 // If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


if (! defined('REALLY_SIMPLE_GA_VERSION')) {
    define('REALLY_SIMPLE_GA_VERSION', '1.0.0');
}

function rsga_deactivated(){
	if( get_option( 'rsga_google_anaytics_code' ) ) {
		delete_option( 'rsga_google_anaytics_code' );
	}
}
register_deactivation_hook( __FILE__, 'rsga_deactivated' );

class REALLY_SIMPLE_GA
{
	function __construct()
	{
		load_plugin_textdomain( 'really-simple-ga', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
		add_action('admin_menu', array($this, 'rsga_display_admin_menu'));
		add_action('wp_head', array($this, 'rsga_show_google_analytics'));
	}

	public function rsga_display_admin_menu(){
		require_once plugin_dir_path( __FILE__ ) . 'admin-screen.php';
	}

	public function rsga_show_google_analytics() {
		$analytics_code = get_option( 'rsga_google_anaytics_code' );
		if( $analytics_code ){ ?>
		<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
			ga('create', '<?php echo $analytics_code; ?>', 'auto');
			ga('send', 'pageview');
		</script>
		<?php
		}
	}	

}
new REALLY_SIMPLE_GA();