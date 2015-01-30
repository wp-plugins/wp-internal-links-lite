<style>
.widefat{
    width:720px !important;
}
</style>
<?php 
require_once('header.php'); 

$str_type = 'Ring';
  ?>
  
  
  <?php

if(isset($_POST) && $_POST['savestructure'] && $_POST['savestructure']=='Update Structure'){
    link_structures_operations('update',$_POST);
    $updated = 'yes';
    $msg = '<div class="updated"><p><strong>Structure Updated Successfully..</strong></p></div>';
}
 if(isset($_POST['inlaction']) && $_POST['inlaction']=='edit'){
    
    $inldata = link_structures_operations('edit',$_POST);
    $operation = 'edit';
    $structid = $inldata[0]['id'];
    $str_type = $inldata[0]['type'];
    
  require_once('structure_form.php'); 
   
  }else{

   if(isset($_POST['inlaction']) && $_POST['inlaction']=='delete'){
 
     link_structures_operations('delete',$_POST);
    
  } 
   if(isset($_POST['savestructure']) && $_POST['savestructure']=='Save Structure'){
 
     link_structures_operations('insert',$_POST);
    
  }
  
  if(isset($_POST['createstructure'])){
    
  }else{
  
  ?>
  
 
<?php 

}?>
<div style="float: left;">
  <a href="<?php echo get_site_url('', '', 'admin') . '/wp-admin/admin.php?page=in_links_new'; ?>" class="button-primary">Create New Structure</a> 

  <?php 
echo "  <h3>" . __('List of Link Structures:', 'inl') . "</h3>"; 

?>


    <form method="post" action="<?php echo str_replace('%7E', '~', $_SERVER['REQUEST_URI']); ?>">

        <table cellspacing="0" class="wp-list-table widefat posts" >

            <thead>

            <tr class="thead">

                <th class="column-username" id="username" scope="col"

                    style="width: 100px;"><?php echo __('Name', 'inl'); ?></th>

                <th class="column-username" id="username" scope="col"

                    style="width: 150px;"><?php echo __('Type', 'inl'); ?></th>


                    <th class="column-name" id="name"

                    scope="col" ><?php echo __('Actions', 'gsc'); ?></th>

             </tr>

            </thead>

            <tfoot>

            <tr class="thead">

            <th class="column-username" scope="col"

                    style="width: 100px;"><?php echo __('Name', 'gsc'); ?></th>

                <th class="column-username" scope="col"

                    style="width: 150px;"><?php echo __('Type', 'gsc'); ?></th>

              
                <th class="column-name" scope="col"><?php echo __('Actions', 'gsc'); ?></th>

            
            </tr>

            </tfoot>

        <?php

        $alldata = link_structures_operations('list','');

       

        for ($i=0;$i<count($alldata);$i++) {

           

            $data = $alldata[$i];

           
             ?>

            

                <tbody class="list:user user-list" id="users">

                <tr class="alternate" id="user-1">

                    <td class="username column-username" style="width: 100px;">

                    <?php echo $data['name']; ?>

               </td>

                    <td class="username column-username" style="width: 150px;">

                    <?php echo $data['type']; ?>

               </td>

               

                    <td class="name column-name">

                    

                    <div class="">

                   

                    <span class='edit'>

                    <a href="javascript:void(0);" title="Edit" onclick="editform('<?php echo $data[id]?>');">Edit</a> 

                    | </span>

                  

                    <span class='delete'>

                    <a href="javascript:void(0);" title="delete" onclick="deleteform('<?php echo $data[id]?>');">Delete</a> 

                    | </span>

                  


                    

                        </div>

        
                </tr>

                </tbody>

            <?php



        }

        if (count($alldata) < 1) {

            ?>



                <tbody class="list:user user-list" id="users">

                <tr class="alternate" id="user-1">

                    <th class="check-column" scope="row">

                    </th>

                    <td class="name column-name" colspan="2">

                    <?php echo __('There are no structures created yet', 'gsc'); ?>

        </td>

                </tr>

                </tbody>

            <?php



        };

        ?>

          </table>

          </form>
          <form action="" name="operationform" id="operationform" method="post">
          <input type="hidden" name="inl_link_id" id="inl_link_id" value="" />
          <input type="hidden" name="inlaction" id="inlaction" value="" />
        
          </form>



</div>

<script>

function editform(id){
    
   alert("The Lite version of this plugin does not allow editing structures, only creating and deleting them. If you want to have access to the full potential of the plugin, upgrade to a pro license at WPInternalLinks.com.")


   

}
function deleteform(id){
var r=confirm("Are you sure you want to delete this structure?");
if (r==true)
  {
  document.getElementById('inlaction').value = 'delete';

     document.getElementById('inl_link_id').value = id;

      document.operationform.submit();
  }
else
  {
  
  }
     

}
</script>
<?php }?>
