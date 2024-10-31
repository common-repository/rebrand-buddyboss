<?php
/**
 * Plugin Name: 	Rebrand BuddyBoss 
 * Plugin URI: 	    https://rebrandpress.com/rebrand-buddyboss/
 * Description: 	BuddyBoss combines WPUltimo and Pabbly. Together, they allow you to create and manage your own WordPress community. With Rebrand Buddy Boss, you can unify the capabilities of both plugins under your own brand image. Change the name and plugin description, apply your colors and logo, and replace the developer’s name with your company’s to more easily sell unlimited plans and upsells on your WaaS (Website as a Service).

 * Version:     	1.0
 * Author:      	RebrandPress
 * Author URI:  	https://rebrandpress.com/
 * License:     	GPL2 etc
 * Network:         Active
*/

if (!defined('ABSPATH')) { exit; }

if ( !class_exists('Rebrand_BuddyBoss_Pro') ) {
	
	class Rebrand_BuddyBoss_Pro {
		
		public function bzbb_load()
		{
			global $bzbb_load;
			load_plugin_textdomain( 'bzbb', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

			if ( !isset($bzbb_load) )
			{
			  require_once(__DIR__ . '/bb-settings.php');
			  $PluginLMS = new BZ_BB\BZRebrandBuddyBossSettings;
			  $PluginLMS->init();
			}
			return $bzbb_load;
		}
		
	}
}
$PluginRebrandBuddyBoss = new Rebrand_BuddyBoss_Pro;
$PluginRebrandBuddyBoss->bzbb_load();

