<?php
/*
Plugin Name: WP Internal Links Lite
Plugin URI: http://wpinternallinks.com/?utm_source=plugin&utm_medium=description&utm_campaign=salespage
Description: WP Internal Links allows you to easily create (and change on the fly) powerful internal linking structures within your site, that both Google and your visitors love.
Version: 1.0.4
Author: Mikel Perez & Tony Shepherd
Author URI:  http://wpinternallinks.com/?utm_source=plugin&utm_medium=description&utm_campaign=salespage
*/

define( INLPLN1, plugins_url('/', __FILE__) );
define( INLPLN_SETTINGS, 'inl_settings' );

$wpdb->inl_link_structures = 'inl_link_structures';
$wpdb->inl_link_struct_to_links = 'inl_link_struct_to_links';
register_activation_hook(__FILE__,'il_pln_activation');
add_action( 'admin_menu', 'adminMenuNL' );

function il_pln_activation(){
vm_reservation_system_create_tables();
}
function inlpln_lite_scripts_method() {
  	wp_enqueue_script(
		'inlpln-script',
		plugins_url('/js/jquery.blockUI.js', __FILE__),
        array('jquery'));
}    
 
add_action('admin_enqueue_scripts', 'inlpln_lite_scripts_method');
function add_inl_post_content($content) {
  	if(!is_feed() && !is_home()) {
	   global $post;
       $posthtml = '';
       $inl_options = get_option(INLPLN_SETTINGS);
       $inl_pos_top = $inl_options['inl_pos_top'];
       if($inl_pos_top =='' || $inl_pos_top == 'top'){
        $posthtml.=get_inl_content($post->ID);
        $posthtml.=$content;
       }else if($inl_pos_top=='bottom'){
        $posthtml.= $content;
        $posthtml.=  get_inl_content($post->ID);
       }
        if(get_inl_content($post->ID)==''){
         $posthtml =    $content;
        }
   
	return $posthtml;
	}else{
	   return $content;
	}
	
}
add_filter('the_content', 'add_inl_post_content',-10000);
require_once('sql-scripts.php');
function adminMenuNL() {

	add_menu_page(__('WP Internal Links Lite','menu-test'), __('WP Internal Links Lite','menu-test'), 'manage_options', 'in_links', 'in_links_intro' ,INLPLN1.'images/favicon.png');
    add_submenu_page('in_links', __('General Settings','menu-test'), __('General Settings','menu-test'), 'manage_options', 'in_links_settings', 'in_links_settings');

   
     add_submenu_page('in_links', __('Manage structures','menu-test'), __('Manage structures','menu-test'), 'manage_options', 'in_links_management', 'in_links_management');
     add_submenu_page('in_links', __('New Structure','menu-test'), __('New Structure','menu-test'), 'manage_options', 'in_links_new', 'in_links_new');
  

   
   
  
    }

function in_links_intro(){
    require_once('intro.php'); 
}
function in_links_settings(){
    require_once('settings.php'); 
}
function in_links_management(){
     require_once('management.php'); 
    
}

    require_once('operations.php'); 
function get_inl_posts(){
    $allposts = query_posts(array('posts_per_page' => -1 )); 
    return $allposts;
}
function in_links_new(){
    $str_type = 'Ring';
    include ('structure_form.php'); 
    
}
add_action('wp_ajax_get_structure', 'get_structure_callback');

function get_structure_callback() {
	global $wpdb; // this is how you get access to the database

    $inl_type = $_POST['type']; 
    $operation = $_POST['operation'];
    $structid   =  intval($_POST['id']);
	$nodes = intval( $_POST['nodes'] );
    
    require_once('ajax.php');

	die(); // this is required to return a proper result
}
function get_inl_content($inlpostid){
    
    if($inlpostid==''){
        return '';
    }else{
        $inl_options = get_option(INLPLN_SETTINGS);
        $intro_text1 = $inl_options['inl_text_link1'];
         $intro_text2 = $inl_options['inl_text_link2'];
        $html = '';
        $data['source'] = $inlpostid;
      $inldata =  link_structures_operations('getinlpost',$data);
      $homepage = get_option('home');
      if(count($inldata)>0){
          $html.= '<p><span class="interlinks">';
        for($i=0;$i<count($inldata);$i++){
            $target1 = $inldata[$i]['target1'];
            $target2 = $inldata[$i]['target2'];
            if($inldata[$i]['anchor_text1']!=''){
                if($target1!=1000000000)
                $html.=''.$intro_text1.'  <a href="'.get_permalink( $target1 ).'">'.$inldata[$i]['anchor_text1'].'</a>.&nbsp; ';
                else   
                $html.=''.$intro_text1.'  <a href="'.$homepage.'">'.$inldata[$i]['anchor_text1'].'</a>.&nbsp; ';
            }
     
            
        }
         $html.= '</span></p>';
      }
      
      return $html;
    }
}
function getinllinks($operation){
     global $wpdb;
 
        $sql = "SELECT ID,post_title FROM  wp_posts WHERE post_status='publish' AND post_type='page' ORDER BY  ID DESC ";
$allposts = $wpdb->get_results($sql) ;
        $totposts = array();
       foreach($allposts as $allpost){
         $totpost['id'] = $allpost->ID;
         $totpost['title'] = 'Page - '.$allpost->post_title;
         $totposts[] = $totpost;
        }

 $sql = "SELECT ID,post_title FROM  wp_posts WHERE post_status='publish' AND post_type='post' ORDER BY  ID DESC ";
$allposts = $wpdb->get_results($sql) ;
        foreach($allposts as $allpost){
         $totpost['id'] = $allpost->ID;
         $totpost['title'] = 'Post - '.$allpost->post_title;
         $totposts[] = $totpost;
        }
         $totpost['id'] = 1000000000;
         $totpost['title'] = 'Home Page';
         $totposts[] = $totpost;
      // 
      $sql = "SELECT source FROM inl_link_struct_to_links GROUP BY source ORDER BY source DESC";
      if($operation=='edit'){
      $sql = "SELECT source FROM inl_link_struct_to_links 
WHERE source  NOT IN (SELECT source FROM inl_link_struct_to_links WHERE link_struct_id = ".$structid.")
GROUP BY source ORDER BY source DESC";
}
           	$found = 0;
            $data = Array();
            if ($results = $wpdb->get_results($sql, ARRAY_A)) {
		      
            
			foreach ($results as $value) {
			 
			$found++;
            }
            if($found==0){
                return $data; 
            }else{
                $data = $wpdb->get_results($sql, ARRAY_A); 
               
            }
           
		  }  
       
      $finalposts = array();
      $default['id'] = 1000000001;
         $default['title'] = 'Select One';
       
      $finalposts[] = $default;
      for($i=0;$i<count($totposts);$i++ ){
        $totpost = $totposts[$i];
        $found = false;
         for($j=0;$j<count($data);$j++ ){
            
        if($data[$j]['source']==$totpost['id']){
             $found = true;
        }
       
        
      }
         if(!$found)
        $finalposts[] =  $totpost;
      }
     
        return $finalposts;
}