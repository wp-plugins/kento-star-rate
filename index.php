<?php
/*
Plugin Name: Kento Star Rate
Plugin URI: http://kentothemes.com
Description: Star Rating for post
Version: 1.0
Author: KentoThemes
Author URI: http://kentothemes.com
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/


wp_enqueue_script('jquery');
define('KENTO_STAR_RATE_PLUGIN_PATH', WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) . '/' );
wp_enqueue_style('kento-star-rate-style', KENTO_STAR_RATE_PLUGIN_PATH.'css/style.css');

wp_enqueue_script('kento_star_rate_ajax_js', plugins_url( '/js/kento-star-rate-ajax.js' , __FILE__ ) , array( 'jquery' ));
wp_localize_script( 'kento_star_rate_ajax_js', 'kento_star_rate_ajax', array( 'kento_star_rate_ajaxurl' => admin_url( 'admin-ajax.php')));




            
			
			
			                                         
register_activation_hook(__FILE__, kento_star_rate_install());





function kento_star_rate_install()
	{
	global $wpdb;
        $sql = "CREATE TABLE IF NOT EXISTS " . $wpdb->prefix . "ksr"
                 ."( UNIQUE KEY id (id),
					id int(100) NOT NULL AUTO_INCREMENT,
					postid  int(10) NOT NULL,
					rate  int(10) NOT NULL,
					count  int(10) NOT NULL)";
		$wpdb->query($sql);
		
        $sql2 = "CREATE TABLE IF NOT EXISTS " . $wpdb->prefix . "ksr_info"
                 ."( UNIQUE KEY id (id),
					id int(100) NOT NULL AUTO_INCREMENT,
					postid  int(10) NOT NULL,
					userid  int(10) NOT NULL,
					rate  int(10) NOT NULL)";
		$wpdb->query($sql2);
		
		}


function kento_star_rate_drop() {
	
if ( get_option('kento_star_rate_deletion') == 1 )
	{
		delete_option('ksr_bg_color');
		delete_option('ksr_mouseenter_color');	
		delete_option('ksr_currentrate_color');	
		delete_option('ksr_star_size');	
		delete_option('ksr_star_design');			
		delete_option('kento_star_rate_deletion');	
		global $wpdb;
		$table = $wpdb->prefix . "ksr";
		$wpdb->query('DROP TABLE IF EXISTS ' . $wpdb->prefix . 'ksr');
		
		global $wpdb;
		$table = $wpdb->prefix . "ksr_info";
		$wpdb->query('DROP TABLE IF EXISTS ' . $wpdb->prefix . 'ksr_info');		
		
	}
	
}

if ( get_option('kento_star_rate_deletion') == 1 ) {
	register_uninstall_hook( __FILE__, 'kento_star_rate_drop' );
}





function kento_star_rate_ajax()
	{
		$post_id = (int)$_POST['post_id'];
		$star_rate = (int)$_POST['star_rate'];
		
		$userid = get_current_user_id();
		if(is_user_logged_in())
			{
				
				global $wpdb;
				$table = $wpdb->prefix . "ksr_info";
				
				$result = $wpdb->get_results("SELECT * FROM $table WHERE userid = $userid AND postid = $post_id", ARRAY_A);
				$already_rated = $wpdb->num_rows;
				
				if($already_rated > 0 )
					{
						echo "<span class='ksr-already-rate'>You already Rated.</span>";
					}
				else
					{
		
						global $wpdb;
						$table = $wpdb->prefix . "ksr";
						$result = $wpdb->get_results("SELECT * FROM $table WHERE postid = $post_id", ARRAY_A);
						$already_rated = $wpdb->num_rows;
						
						if($already_rated > 0 )
							{
								global $wpdb;
								$table = $wpdb->prefix . "ksr";
								$wpdb->query("UPDATE $table SET rate = rate+$star_rate , count=count+1 WHERE postid = '".$post_id."'");
	
							}
						else
							{
							$wpdb->insert(	$table, 	
											array( 	'id' => '', 'postid' => $post_id,'rate' => $star_rate,'count' => 1,	),
											array('%d', '%d',	'%d','%d')
										);

							}

						global $wpdb;
						$table = $wpdb->prefix . "ksr_info";
							$wpdb->insert(	$table,
											array( 	'id' => '', 'postid' => $post_id,'userid' => $userid,'rate' => $star_rate,	),
											array('%d', '%d', '%d', '%d')
										);




						echo "<span class='ksr-thanks'>Thanks For Rate.</span>";	
							}

				
			}
		else
			{
				echo "<span class='ksr-logged'>Please <a href='".wp_login_url()."'>login</a> to rate.</span>";
			
		
		
		}
		die();
	}



add_action('wp_ajax_kento_star_rate_ajax', 'kento_star_rate_ajax');
add_action('wp_ajax_nopriv_kento_star_rate_ajax', 'kento_star_rate_ajax');


















function kento_star_rate_frontend($ksr)
	{
		
		$ksr_bg_color = get_option( 'ksr_bg_color' );
		$ksr_mouseenter_color = get_option( 'ksr_mouseenter_color' );			
		$ksr_currentrate_color = get_option( 'ksr_currentrate_color' );
		$rated = kento_star_rate_count_rate(get_the_id());
		
		
		
		
		
		$ksr.=	"<div id='kento-star-rate'>";
		$ksr.=		"<div class='ksr-holder' currentrate='".kento_star_rate_count_rate(get_the_id())."' >";
		$ksr.=		"<ul id='ksr-stars-".get_the_id()."'>";
		for($i=1; $i<=5;$i++)
			{
				$ksr.= "<li class='ksr-".$i."  ksr-star' rate='".$i."' postid='".get_the_id()."'></li>";
			}
		$ksr.=		"</ul>";
		$ksr.= "<style type='text/css' >";
		
		
		for($i=1; $i<=$rated;$i++)
			{	
				$ksr.= "#ksr-stars-".get_the_id()." li.ksr-".$i."{";
				$ksr.= "background-color:".$ksr_currentrate_color;
				$ksr.= "}";
			}
		for($i=$rated+1; $i<=6;$i++)
			{	
				$ksr.= "#ksr-stars-".get_the_id()." li.ksr-".$i."{";
				$ksr.= "background-color:".$ksr_bg_color;
				$ksr.= "}";
			}		
			
		
		
		$ksr.= "</style>";
		
		$ksr.=		"</div>";
		
		$ksr.= "<span id='ksr-bg-color'>".get_option( 'ksr_bg_color' )."</span>";
		$ksr.= "<span id='ksr-mouseenter-color'>".get_option( 'ksr_mouseenter_color' )."</span>";
		$ksr.= "<span id='ksr-currentrate-color'>".get_option( 'ksr_currentrate_color' )."</span>";
		
		$ksr.=	"<div class='ksr-rate-status-".get_the_id()."'></div>";
		$ksr.=	"</div>";
		
		return $ksr;

	}


add_filter('the_content', 'kento_star_rate_frontend');


function kento_star_rate_style()
	{	
	
		$ksr_star_size = get_option( 'ksr_star_size' );
		$ksr_star_design = get_option( 'ksr_star_design' );
		echo "
		
		<style type='text/css'>
		#kento-star-rate ul li
			{
				height: ".$ksr_star_size."px !important;
				width: ".$ksr_star_size."px !important;
				
			}
		#kento-star-rate ul li {
		  background: url('".KENTO_STAR_RATE_PLUGIN_PATH."css/stars/".$ksr_star_design."');
		  background-repeat:no-repeat;
		  background-size:100%;
			}
			
			
		</style>";
	}
add_action('wp_head', 'kento_star_rate_style');



function kento_star_rate_count_rate($post_id)
	{
		global $wpdb;
		$table = $wpdb->prefix . "ksr";
		$result = $wpdb->get_results("SELECT * FROM $table WHERE postid = $post_id", ARRAY_A);
		$rate = $result[0]['rate'];
		$count = $result[0]['count'];
		
		if($rate>0 AND $count>0)
			{
				return ceil($rate/$count);
			}
		else
			{
				return 0;
			}
		
		
		}





////////////////////////////////////////////////////////////

add_action('admin_init', 'kento_star_rate_init' );
add_action('admin_menu', 'kento_star_rate_menu');

function kento_star_rate_init(){
	register_setting( 'kento_star_rate_plugin_options', 'ksr_bg_color');
	register_setting( 'kento_star_rate_plugin_options', 'ksr_mouseenter_color');
	register_setting( 'kento_star_rate_plugin_options', 'ksr_currentrate_color');
	register_setting( 'kento_star_rate_plugin_options', 'ksr_star_size');	
	register_setting( 'kento_star_rate_plugin_options', 'ksr_star_design');
	register_setting( 'kento_star_rate_plugin_options', 'kento_star_rate_deletion');	
	
    }
function kento_star_rate_menu() {
	add_menu_page(__('Kento Star Rate Settings','ksr'), __('KSR Settings','ksr'), 'manage_options', 'ksr_settings', 'kento_star_rate_settings');
}


function kento_star_rate_settings(){
	include('kento-star-rate-admin.php');	
}






////////////////


add_action( 'admin_enqueue_scripts', 'mw_enqueue_color_picker' );

function mw_enqueue_color_picker( $hook_suffix ) {
    // first check that $hook_suffix is appropriate for your admin page
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'my-script-handle', plugins_url('/js/kento-star-rate-ajax.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
}







?>