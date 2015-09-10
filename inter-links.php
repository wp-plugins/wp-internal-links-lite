<?php
/*
Plugin Name: No Sweat WP Internal Links Lite
Plugin URI: http://nosweatplugins.com/get-no-sweat-wp-internal-links-pro/?utm_source=plugin&utm_medium=link&utm_campaign=description
Description: No Sweat WP Internal Links allows you to easily create (and change on the fly) powerful internal linking structures within your site, that both Google and your visitors love.
Version: 2.4.3   
Author: Mikel Perez, Inaki Ramirez & Tony Shepherd
Author URI:  http://nosweatplugins.com/get-no-sweat-wp-internal-links-pro/?utm_source=plugin&utm_medium=link&utm_campaign=description
*/

define( INLPLN1, plugins_url('/', __FILE__) );
define( INLPLN_SETTINGS, 'inl_settings' );
define( INLPLNDIR, dirname(__FILE__) );
define( INLPLN_AFFILIATE_SETTINGS, 'INLPLN_AFFILIATE_SETTINGS' );
define ( 'INLPLN_VERSION', '2.4.2' );
define('INLPLNAJAXURL', home_url( "/" ).'wp-admin/admin-ajax.php');
register_activation_hook(__FILE__,'il_pln_activation');

add_action( 'admin_menu', 'adminMenuNL' );
add_action( 'init', 'inl_plugin_init' );
function inl_plugin_init(){
if ( is_admin() ) {
   
	if(INLPLN_VERSION=='2.4.2' && get_option('INLPLN_ACTIVATED')==''){
		update_option( 'INLPLN_ACTIVATED', date('Y-m-d') );
	}
}
}

function il_pln_activation(){
inlpln_lite_create_tables();
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

	add_menu_page(__('No Sweat WP Internal Links','menu-test'), __('No Sweat WP Internal Links','menu-test'), 'manage_options', 'in_links', 'in_links_intro' ,INLPLN1.'images/favicon.png');
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
     $inl_options = get_option(INLPLN_SETTINGS);
  
     $introductorytext = $inl_options['inl_text_link1'];
   
                  
    require_once('ajax.php');

	die(); // this is required to return a proper result
}
function get_inl_content($inlpostid){
    
    if($inlpostid==''){
        return '';
    }else{
        $inl_options = get_option(INLPLN_SETTINGS);
          $html = '';
        $data['source'] = $inlpostid;
      $inldata =  link_structures_operations('getinlpost',$data);
      $homepage = get_option('home');
      if(count($inldata)>0){
          $html.= '<p><span class="interlinks">';
        for($i=0;$i<count($inldata);$i++){
            $target1 = $inldata[$i]['target1'];
            $target2 = $inldata[$i]['target2'];
           $intro_text1 = $inldata[$i]['Introductory_text1']; 
           if($intro_text1==''){
              $intro_text1 = $inl_options['inl_text_link1'];
           }
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
 $inl_options = get_option(INLPLN_SETTINGS);
 $inl_post_types = $inl_options['inl_pos_type'];
  $totposts = array();
 for($i=0;$i<count($inl_post_types);$i++){
    $sql = "SELECT ID,post_title FROM  ".$wpdb->prefix."posts WHERE post_status='publish' AND post_type='".$inl_post_types[$i]."' ORDER BY  ID DESC ";
$allposts = $wpdb->get_results($sql) ;
       
       foreach($allposts as $allpost){
         $totpost['id'] = $allpost->ID;
         $totpost['title'] = $allpost->post_title;
         $totposts[] = $totpost;
        }
    
 }
//        
//
// $sql = "SELECT ID,post_title FROM  wp_posts WHERE post_status='publish' AND post_type='custompost1' ORDER BY  ID DESC ";
//$allposts = $wpdb->get_results($sql) ;
//        foreach($allposts as $allpost){
//         $totpost['id'] = $allpost->ID;
//         $totpost['title'] = 'Post - '.$allpost->post_title;
//         $totposts[] = $totpost;
//        }
usort($totposts, 'cmp'); 
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
 function cmp($a, $b) {

    return (strcmp(strtolower ($a['title']),strtolower ($b['title'])));
}
add_action('admin_notices', 'inlpln_notices');
add_action('wp_ajax_inlpln_dismiss', 'inlpln_dismiss');
function show_inlpln_promotion_msgs(){
	$messages = array();

if (false !== file_get_contents("http://nosweatplugins.com/messages_Internallinks.txt")) {
$msgfile = fopen("http://nosweatplugins.com/messages_Internallinks.txt", "r") or die("Unable to open file!");
//$msgfile = fopen(INLPLNDIR.'/lib/messages_internal_links.txt', "r") or die("Unable to open file!");
// Output one line until end-of-file
while(!feof($msgfile)) {
//	echo fgets($msgfile);
   $msg = json_decode(fgets($msgfile),true);
 //  print_r($msg);
 //  die;
   $messages[] = $msg[0];
}
fclose($msgfile);
}
return $messages; 
}
function inlpln_notices()
{   $messages = show_inlpln_promotion_msgs();
//	echo '<pre>';
//	print_r($messages);
	$today = date('Y-m-d');
	$activateddate = get_option('INLPLN_ACTIVATED');
     $dismissedays = get_option('INLPLN_DISMISS');
	 if($dismissedays!=''){
	 	$dismissedays = explode(',',$dismissedays);
	 }else{
	 	$dismissedays = array();
	 }
	if(!empty($messages)){  
		$showmsg = '';
		$days = 'no';
		$finaldate = '';
	    for($i=0;$i<count($messages);$i++){
			$msg = $messages[$i]; 
	    	if($msg['days']==$today && !in_array(trim($msg['days']),$dismissedays)){
			 $days = $msg['days'];
			 $showmsg = $msg['msg'];
			 break;	
			 }
	 		 
		 }
		 if($days=='no' && $showmsg==''){
		 	$found =0;
		 	for($i=0;$i<count($messages);$i++){
		 	 	
			 $msg = $messages[$i];
			
			 $isdate = date_parse($msg['days']);
			 
             if($isdate['error_count']!=0){
			 $finaldate = date('Y-m-d', strtotime($activateddate." +".$msg['days']." days"));
			//echo $finaldate.'<br/>';	 
              if($today>=$finaldate){
			   $days = $msg['days'];
			   $showmsg = $msg['msg'];
			 	
			 } 
			if($today<=$finaldate){
			  
			 	break;
			 }
	 		 
             }
		 	}
		 }
	
	 if(!in_array(trim($days),$dismissedays) && $showmsg!='' && $days!='no'){
	 		
	 		echo '<style>.nsp_container{margin-top:10px;}.dismiss_il{float:right;cursor:pointer;font-weight: bold;}</style>'.$showmsg.'<div style="clear:both;"></div>';
	 		?>	 		
	 		<script type="text/javascript"><!--
     	 		jQuery( ".dismiss_il" ).click(function() {
     	 			jQuery( this).parent().fadeOut( "slow" );
     	 			 jQuery.post('<?php echo INLPLNAJAXURL?>',

     	 			        { action:'inlpln_dismiss',
     	 			            days:jQuery( this).parent().attr("id")

     	 			        },  function(data){
										
        	 			         });
	 			
	 			});
			//-->
			</script>
	 		<?php 
	 	
	 }	     
	  
	}
    
}
function inlpln_dismiss(){
	$days = $_POST['days'].','.get_option('INLPLN_DISMISS');
	update_option('INLPLN_DISMISS',$days);
}
function inlpln_activate_affiliate(){
$af_code = get_option(INLPLN_AFFILIATE_SETTINGS);
if($af_code==''){
	if (false !== file_get_contents(INLPLNDIR.'/lib/affiliate.txt')) {
		$msgfile = fopen(INLPLNDIR.'/lib/affiliate.txt', "r") or die("Unable to open file!");
			while(!feof($msgfile)) {
			 $af_code = fgets($msgfile);
			}
		fclose($msgfile);
	}
}
	if($af_code!='')
 	update_option(INLPLN_AFFILIATE_SETTINGS,$af_code);
}