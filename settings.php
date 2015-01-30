<?php
$updated = '';
$posturl = '';
$inl_options = get_option(INLPLN_SETTINGS);
if(!isset($inl_options['inl_pos_type'])){
    $inl_options['inl_pos_type'] = array('post','page');
    update_option(INLPLN_SETTINGS,$inl_options); 
}
if(isset($_POST) && $_POST['Submit']=='Save'){
update_option(INLPLN_SETTINGS,$_POST);  
$updated = '<div class="updated"><p><strong>Settings Saved</strong></p></div>'; 

}

?>

<?php

$inl_options = get_option(INLPLN_SETTINGS);
$botselected = '';
$topselected = 'checked="checked"';
if(isset($inl_options['inl_pos_top']) && $inl_options['inl_pos_top']=='top' ){
  $topselected =  'checked="checked"';  
}else{
  $botselected =  'checked="checked"';
  $topselected = ''; 
}

?>

  

<?php 
  require_once('header.php');  
 
?>
<div style="clear: both !important;"></div>
<div class="wrap" style="width: 600px !important;float:left !important;">
<div id="poststuff">
<?php if($updated!='') echo $updated;?>
<div id="post-body">
<div id="post-body-content"  style="width: 800px !important; float:left !important;">


<div  class="stuffbox">
<h3><label for="link_name"><?php _ex('General Settings:', 'gsc') ?></label></h3>
<div class="inside" >
    <div id="inldiv" >
    <form method="post" action="<?php echo $posturl;?>" name="inlform" class="inlform" >
        <table class="form-table">
            <tbody>
          
             <tr valign="top">
                <th scope="row"><label for="name"><?php echo __('Introductory Text for link1', 'inl'); ?><span style="color: red;">*</span></label>
                </th>
                <td>
                    <input type="text" id="inl_text_link1" name="inl_text_link1" class="regular-text" value="<?php echo $inl_options['inl_text_link1']; ?>"/>
                </td>
            </tr>
           
             <tr valign="top">
                <th scope="row"><label for="name"><?php echo __('Position of the links', 'inl'); ?><span style="color: red;">*</span></label>
                </th>
                <td>
                    <input type="radio" id="inl_pos_top" name="inl_pos_top" value="top" <?php echo $topselected?>/> Top
                    <input type="radio"   id="inl_pos_top" name="inl_pos_top" value="bottom" <?php echo $botselected?>/> Bottom
                 </td>
            </tr>
               <tr valign="top">
                <th scope="row"><label for="name"><?php echo __('Types of Posts to be Listed', 'inl'); ?><span style="color: red;">*</span></label>
                </th>
                <td>
                <?php 
$post_types=get_post_types('','names'); 
$inl_post_types = $inl_options['inl_pos_type'];

foreach ($post_types as $post_type ) {
  if($post_type!='attachment' && $post_type!='revision' && $post_type!='nav_menu_item'){  
  $selected =  '';
       
  if(in_array($post_type,$inl_post_types)) {
     $selected =  'checked="checked"';  
  } 
  echo '<input type="checkbox" id="inl_pos_type[]" name="inl_pos_type[]" value="'.$post_type.'"  '.$selected.'/> '.$post_type.'<br/>';
  }
}
?>
                    
                    
                 </td>
            </tr>
            

        </p>
        </table>
        <p class="submit">
         <input type="hidden" value="<?php echo INLPLN_LICENCE?>"  name="std_inlkey"/>
        <input type="submit" value="Save" class="button-primary" name="Submit" onclick=" return validateinlsettings(this.value);"/>
          
    </form>
    </div>
    </div>
</div>


</div>
</div>


</div>
<script>
function validateinlsettings(value){
    var numberOfChecked = jQuery('input:checkbox:checked').length;
	var validate = true;
    
    if(numberOfChecked==0){
         alert('At least one post type needs to be selected');
         window.location.replace("");
        return false;
    }
    if(document.getElementById("inl_text_link1").value==''){
           alert('Introductory Text for link1 should not be empty');
        return false;
        }
     
        return validate;
    }
  
    
</script>