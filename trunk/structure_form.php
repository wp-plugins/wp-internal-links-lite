<?php 

$updated = '';

 $charLimit = 40;

$name = '';

$type = 'Ring';

$nodes = '';

$msg = '';

$posturl = site_url('/wp-admin/admin.php?page=in_links_management');

  require_once('header.php'); 

$disabled = 'disabled="disabled"';

if(isset($_POST) && $_POST['savestructure'] && $_POST['savestructure']=='Save Structure'){

    link_structures_operations('insert',$_POST);

    $updated = 'yes';

    $msg = '<div class="updated"><p><strong>Structure Successfully created..</strong></p></div>';

   

}

if(isset($inldata) && count($inldata)>0){

  

    $inl = $inldata[0];

    $name = $inl['name'];

    $type = $inl['type'];

    $nodes = $inl['nodes'];

}

if(isset($_POST['inlaction']) && $_POST['inlaction']== 'edit'){

    $operation = 'edit';

}



  ?>

  <div class="inlcleardiv"></div>



<div class="wrap" style="width: 900px !important;float:left !important;">

<div id="poststuff">

<?php if($updated!='') echo $msg;?>

<div id="post-body">

<div id="post-body-content"  style="width: 900px !important; float:left !important;">

<div  class="stuffbox">

<?php if( $operation == 'edit'){

  ?>


<?php    

}else{

 ?>

  <h3><label for="link_name"><?php _ex('New Structure:', 'gsc') ?></label></h3>

 <?php   

}?>



<div class="inside" >

<div class="linkstructe" > 





<form method="post" action="<?php echo $posturl;?>" name="structureform" class="structureform" onSubmit="return validateinl();">

        <table class="form-table">

            <tbody>

              <tr valign="top">

                <th scope="row"><label for="name"><?php echo __('Type', 'inl'); ?><span style="color: red;">*</span></label>

                </th>

                <td>

                  
                    <input type="radio" class="inltype"  id="inl_type" name="inl_type" value="Ring" <?php if($type=='Ring' ) echo 'checked="checked"'; if($operation=='edit' && $type!='Ring') echo 'disabled="disabled"';?> onchange="getstucture(this.value);"/><span>Ring</span> 
                    <input type="radio" class="inltype" id="inl_type" name="inl_type" value="Hub" <?php echo 'disabled="disabled"';?> onchange="getstucture(this.value);"/><span>Hub</span> 

                    <input type="radio" class="inltype" id="inl_type" name="inl_type" value="Web" <?php  echo 'disabled="disabled"';?>  onchange="getstucture(this.value);"/><span>Web</span>  

                    <input type="radio" class="inltype"  id="inl_type" name="inl_type" value="Star" <?php  echo 'disabled="disabled"';?> onchange="getstucture(this.value);"/><span>Star</span> 

           <p class="description">Beware that you will not be able to change the structure type after it has been created, you will have to delete it and create a new one. Choose wisely!</p>

                 </td>

            </tr>

            <tr valign="top">

                <th scope="row"><label for="name"><?php echo __('Name', 'inl'); ?><span style="color: red;">*</span></label>

                </th>

                <td>

                    <input type="text" id="inl_str_name" name="inl_str_name" class="regular-text" value="<?php echo $name?>"/>

                

                <p class="description">Used for your reference only, it will not be shown in any public page</p></td>

                <td>

                <?php 

                if(isset($operation) && $operation=='edit'){

                  ?>

                    <input type="submit" value="Update Structure" class="button-primary" name="savestructure"/> </td>

      

                  <?php   

                }else{

                    ?>

                      <input type="submit" value="Save Structure" class="button-primary" name="savestructure"/> </td>

      

                    <?php   

                }

                ?>

               

            </tr>

           

           </p>

        </table>

        <div id="inlcontainer">

        <table class="dynamicstructure" width="800px;">

          <tr valign="top">

                <th scope="row"><label for="name"><?php echo __('# of Nodes', 'inl'); ?><span style="color: red;">*</span></label>

                </th>

                <td>

                    <select name="nofnodes" id="nofnodes" onchange="getblocks(this.value,this.id);" onclick="getoldblock(this.value,this.id)" style="width: 46px !important;">

                    <option value="3" <?php if($nodes==3 || $nodes=='') echo 'selected="selected"';?>>3</option>

                    <option value="4" <?php if($nodes==4) echo 'selected="selected"';?>>4</option>

                    <option value="5" <?php if($nodes==5) echo 'selected="selected"';?>>5</option>

                    <option value="6" <?php if($nodes==6) echo 'selected="selected"';?>>6</option>

                    </select>

                  <p class="description">The central node in the Hub or The Web is not taken into account. <br />Also, beware that if you modify this number while you are editing the structure, the values below will be reset. Either choose the right value first, or save the structure and then come back and edit it</p>  

                </td>

            </tr>

        <tr><td >

        <?php 

 $totposts = getinllinks($operation);

        for($i=1;$i<=3;$i++){  

            

        ?>

        

        <table>

         <tr valign="top">

         <td width="50%">

                <table width="400px;" class="inlgroup">

                <tr>

                <td><label for="name"><strong><?php echo __('Node'.$i, 'inl'); ?></strong></label></td></tr>

                <tr>

                <td><label for="name"><?php echo __('Source', 'inl'); ?><span style="color: red;">*</span></label>

                </td>

                <td>

                   <select name="source_<?php echo $i?>" id="source_<?php echo $i?>" >

                   <?php 

                   for($j=0;$j<count($totposts);$j++){

                     if(strlen($totposts[$j]['title']) > $charLimit){

                      $totposts[$j]['title'] =  substr($totposts[$j]['title'],0,$charLimit);

                    }

                     if($totposts[$j]['id']!=1000000000){

                    ?>

                    <option value="<?php echo $totposts[$j]['id']?>"><?php echo $totposts[$j]['title']?></option>

                    <?php 

                    }

                    }

                   ?>

                    

                    

                    </select>

                </td>

                </tr>

                <tr>

                <td><label for="name"><?php echo __('Target for Link 1', 'inl'); ?><span style="color: red;">*</span></label>

                </td>

                <td>

                   <select name="target1_<?php echo $i?>" id="target1_<?php echo $i?>" <?php if($i!=1)echo $disabled;?>>

                    <?php 

                   for($j=0;$j<count($totposts);$j++){

                     if(strlen($totposts[$j]['title']) > $charLimit){

                      $totposts[$j]['title'] =  substr($totposts[$j]['title'],0,$charLimit);

                    }

                    ?>

                    <option value="<?php echo $totposts[$j]['id']?>"><?php echo $totposts[$j]['title']?></option>

                    <?php 

                    }

                   ?>  

                    </select>

                </td>

                </tr>

                  <tr>

                <td><label for="name"><?php echo __('Anchor Text for Link 1', 'inl'); ?><span style="color: red;">*</span></label>

                </td>

                <td>

                   <input type="text" name="anchortext1_<?php echo $i?>" id="anchortext1_<?php echo $i?>" />

                   

                </td>

                </tr>
                <tr>

                <td><label for="name"><?php echo __('Introductory Text for link1', 'inl'); ?><span style="color: red;">*</span></label>

                </td>

                <td>

                   <input type="text" name="Introductorytext1_<?php echo $i?>" id="Introductorytext1_<?php echo $i?>" value=""/>

                   

                </td>

                </tr>

                <?php if($inl_type='Hub' && $inl_type!='Ring'){ ?>

                 <tr>

                <td><label for="name"><?php echo __('Target for Link 2', 'inl'); ?><span style="color: red;">*</span></label>

                </td>

                <td>

                   <select name="target2_<?php echo $i?>" id="target2_<?php echo $i?>" >

                     <?php 

                   for($j=0;$j<count($totposts);$j++){

                     if(strlen($totposts[$j]['title']) > $charLimit){

                      $totposts[$j]['title'] =  substr($totposts[$j]['title'],0,$charLimit);

                    }

                    ?>

                    <option value="<?php echo $totposts[$j]['id']?>"><?php echo $totposts[$j]['title']?></option>

                    <?php 

                    }

                   ?> 

                    </select>

                </td>

                </tr>

                <tr>

                <td><label for="name"><?php echo __('Anchor Text for Link 2', 'inl'); ?><span style="color: red;">*</span></label>

                </td>

                <td>

                   <input type="text" name="anchortext2_<?php echo $i?>" id="anchortext2_<?php echo $i?>" />

                 

                </td>

                </tr>

                <?php } ?>

                </table> 

              </td></tr>

              

             </table>

             

            <?php 

            if($i%2==0){

                echo '</tr><tr ><td>';

            }else{

                echo '</td><td >';

            }

            }

            ?>

            </td></tr>

        </table>

           </div>

           <input type="hidden" name="struct_type" id="struct_type" value="<?php echo $str_type;?>"/>

            <input type="hidden" name="operation" id="operation" value="<?php if(isset($operation) && $operation!='') echo $operation;?>"/>

            <input type="hidden" name="structureid" id="structureid" value="<?php if(isset($structid) && $structid!='') echo $structid;?>"/>

            <input type="hidden" name="preblock" id="preblock" value=""/>

            

    </form>

</div>

</div>

</div>

</div>

</div>

</div>

</div>



<script type="text/javascript" >



function getstucture(value){

     jQuery('#inlcontainer').block({ 



                message: 'Processing.....', 



                css: { border: '3px solid #a00' } 



            }); 

    var type = document.getElementById("struct_type").value=value;

   

	var data = {

		action: 'get_structure',

		nodes: jQuery('#nofnodes').val(),

        type: type,

        operation:jQuery('#operation').val(),

        id:jQuery('#structureid').val(),

	};



	// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php

	jQuery.post(ajaxurl, data, function(response) {

	  

	   jQuery('#inlcontainer').html(response);

        if(document.getElementById("struct_type").value=='Hub'){

        jQuery('.dynamicstructure select').each(function (i){

            target1= '';

            if(i==1){

                jQuery(this).change(function (j){

                    var selectedIndex = jQuery('option:selected', '#'+this.id).index();

                     //jQuery('.dynamicstructure select').each(function (k){

                        jQuery("select[id*=target1]").each(function(k){

                   

                  jQuery('#'+this.id+' option:eq('+selectedIndex+')').attr('selected', true);

                  jQuery('#'+this.id+' option:eq('+selectedIndex+')').attr('selected', true);

              

                    

            });




                    });

               

            }

       

        

       });

       }

       if(document.getElementById("struct_type").value=='Ring'){

        jQuery("select[id*=source]").each(function (i){

                jQuery(this).change(function (j){

                    if(i==0){

                    var selectedIndex = jQuery('option:selected', '#'+this.id).index();

                   jQuery('#target1_'+jQuery('#nofnodes').val()+' option:eq('+selectedIndex+')').attr('selected', true);

                   }

                    if(i!=0 && i<jQuery('#nofnodes').val()){

                    var selectedIndex = jQuery('option:selected', '#'+this.id).index();

                   jQuery('#target1_'+i+' option:eq('+selectedIndex+')').attr('selected', true);

                   }

            });

        });

         jQuery("select[id*=target1_]").each(function (i){

            i=i+1;

                jQuery(this).change(function (j){

                    if(i==jQuery('#nofnodes').val()){

                    var selectedIndex = jQuery('option:selected', '#'+this.id).index();

                   jQuery('#source_1 option:eq('+selectedIndex+')').attr('selected', true);

                   }

                    if( i< jQuery('#nofnodes').val()){

                    var selectedIndex = jQuery('option:selected', '#'+this.id).index();

                   jQuery('#source_'+(i+1)+' option:eq('+selectedIndex+')').attr('selected', true);

                   }

            });

        });

       }

        if(document.getElementById("struct_type").value=='Web'){

        jQuery('.dynamicstructure select').each(function (i){

            target1= '';

            if(i==1){

                jQuery(this).change(function (j){

                    var selectedIndex = jQuery('option:selected', '#'+this.id).index();

                     //jQuery('.dynamicstructure select').each(function (k){

                        jQuery("select[id*=target1]").each(function(k){

                   

                  jQuery('#'+this.id+' option:eq('+selectedIndex+')').attr('selected', true);

                  jQuery('#'+this.id+' option:eq('+selectedIndex+')').attr('selected', true);

              

                    

            });



                   

                   //  });

                   

                    



                    });

               

            }

         jQuery("select[id*=source]").each(function (i){

                jQuery(this).change(function (j){

                    if(i==0){

                    var selectedIndex = jQuery('option:selected', '#'+this.id).index();

                   jQuery('#target2_'+jQuery('#nofnodes').val()+' option:eq('+selectedIndex+')').attr('selected', true);

                   }

                    if(i!=0 && i<jQuery('#nofnodes').val()){

                    var selectedIndex = jQuery('option:selected', '#'+this.id).index();

                   jQuery('#target2_'+i+' option:eq('+selectedIndex+')').attr('selected', true);

                   }

            });

        });

         jQuery("select[id*=target2_]").each(function (i){

            i=i+1;

                jQuery(this).change(function (j){

                    if(i==jQuery('#nofnodes').val()){

                    var selectedIndex = jQuery('option:selected', '#'+this.id).index();

                   jQuery('#source_1 option:eq('+selectedIndex+')').attr('selected', true);

                   }

                    if( i< jQuery('#nofnodes').val()){

                    var selectedIndex = jQuery('option:selected', '#'+this.id).index();

                   jQuery('#source_'+(i+1)+' option:eq('+selectedIndex+')').attr('selected', true);

                   }

            });

        });

        

       });

       }

       if(document.getElementById("struct_type").value=='Star'){

          jQuery("select[id*=source]").each(function (i){

                jQuery(this).change(function (j){

                    if(i==0){

                    var selectedIndex = jQuery('option:selected', '#'+this.id).index();

                   jQuery('#target1_'+jQuery('#nofnodes').val()+' option:eq('+selectedIndex+')').attr('selected', true);

                    jQuery('#target2_'+(jQuery('#nofnodes').val()-1)+' option:eq('+selectedIndex+')').attr('selected', true);

            

                   }
                   if(i==1){

                    var selectedIndex = jQuery('option:selected', '#'+this.id).index();

                  jQuery('#target1_'+i+' option:eq('+selectedIndex+')').attr('selected', true);
                 
                    jQuery('#target2_'+(jQuery('#nofnodes').val())+' option:eq('+selectedIndex+')').attr('selected', true);

            

                   }
                   if(i==2){

                    var selectedIndex = jQuery('option:selected', '#'+this.id).index();

                  jQuery('#target1_'+i+' option:eq('+selectedIndex+')').attr('selected', true);
                 
                    jQuery('#target2_1 option:eq('+selectedIndex+')').attr('selected', true);

            

                   }
                    if(i==3){

                    var selectedIndex = jQuery('option:selected', '#'+this.id).index();
                    jQuery('#target1_'+i+' option:eq('+selectedIndex+')').attr('selected', true);
                    jQuery('#target2_2 option:eq('+selectedIndex+')').attr('selected', true);
                    }
                    if(i==4){

                    var selectedIndex = jQuery('option:selected', '#'+this.id).index();
                    jQuery('#target1_'+i+' option:eq('+selectedIndex+')').attr('selected', true);
                    jQuery('#target2_3 option:eq('+selectedIndex+')').attr('selected', true);
                    }
                     if(i==5){

                    var selectedIndex = jQuery('option:selected', '#'+this.id).index();
                    jQuery('#target1_'+i+' option:eq('+selectedIndex+')').attr('selected', true);
                    jQuery('#target2_4 option:eq('+selectedIndex+')').attr('selected', true);
                    }
 

                  

            });

        });

         

       }

       

	
 jQuery('#inlcontainer').unblock(); 
	});

    

}

function getoldblock(value,id){

   

    document.getElementById('preblock').value = value;

}

function getblocks(){



    

    if(document.getElementById("struct_type").value!='Hub' && jQuery('#operation').val()=='edit'){

    var r=confirm("if you change the number of nodes of an existing Ring, Web or Star you will have to make sure that all links between sources and targets match appropriately, and modify some values manually. Are you sure you want to change this value?");

if (r==true)

  {

  

  }

else

  {

    

            var myform=document.getElementById("nofnodes")

for (var i=0; i<myform.options.length; i++){ //loop through all form elements

 

 if (myform.options[i].value == document.getElementById('preblock').value){

   

  myform.options[i].selected=true;

 }

}

  return false;

  }

  }

    jQuery('#inlcontainer').block({ 



                message: 'Processing.....', 



                css: { border: '3px solid #a00' } 



            }); 

    var type = document.getElementById("struct_type").value;

   	var data = {

		action: 'get_structure',

		nodes: jQuery('#nofnodes').val(),

        type: type,

        operation:jQuery('#operation').val(),

        id:jQuery('#structureid').val(),

	};



	jQuery.post(ajaxurl, data, function(response) {

	   jQuery('#inlcontainer').html(response);

          if(document.getElementById("struct_type").value=='Hub'){

        jQuery('.dynamicstructure select').each(function (i){

            target1= '';

            if(i==1){

                  var selectedIndex = jQuery('option:selected', '#'+this.id).index();

                        jQuery("select[id*=target1]").each(function(k){

                   

                  jQuery('#'+this.id+' option:eq('+selectedIndex+')').attr('selected', true);

                  jQuery('#'+this.id+' option:eq('+selectedIndex+')').attr('selected', true);

              

                    

            });

                jQuery(this).change(function (j){

                    var selectedIndex = jQuery('option:selected', '#'+this.id).index();

                         jQuery("select[id*=target1]").each(function(k){

                   

                  jQuery('#'+this.id+' option:eq('+selectedIndex+')').attr('selected', true);

                  jQuery('#'+this.id+' option:eq('+selectedIndex+')').attr('selected', true);

              

                    

            });

             });

               

            }

       

        

       });

       

       }

        if(document.getElementById("struct_type").value=='Ring'){

        jQuery("select[id*=source]").each(function (i){

                jQuery(this).change(function (j){

                    if(i==0){

                    var selectedIndex = jQuery('option:selected', '#'+this.id).index();

                   jQuery('#target1_'+jQuery('#nofnodes').val()+' option:eq('+selectedIndex+')').attr('selected', true);

                   }

                    if(i!=0 && i<jQuery('#nofnodes').val()){

                    var selectedIndex = jQuery('option:selected', '#'+this.id).index();

                   jQuery('#target1_'+i+' option:eq('+selectedIndex+')').attr('selected', true);

                   }

            });

        });

         jQuery("select[id*=target1_]").each(function (i){

            i=i+1;

                jQuery(this).change(function (j){

                    if(i==jQuery('#nofnodes').val()){

                    var selectedIndex = jQuery('option:selected', '#'+this.id).index();

                   jQuery('#source_1 option:eq('+selectedIndex+')').attr('selected', true);

                   }

                    if( i< jQuery('#nofnodes').val()){

                    var selectedIndex = jQuery('option:selected', '#'+this.id).index();

                   jQuery('#source_'+(i+1)+' option:eq('+selectedIndex+')').attr('selected', true);

                   }

            });

        });

       }

        

       

        

	
 jQuery('#inlcontainer').unblock(); 
	});

   

}



getstucture('<?php echo $str_type;?>'); 

function validateinl(){

    var validate = true;

    if(document.getElementById("inl_str_name").value==''){

           alert('Name should not be empty');

        return false;

        }

            $defaultvalue = false;

           jQuery("select").each(function(i){

                   

                 if(jQuery('#'+this.id).val() == '1000000001'){

                    $defaultvalue =  true;

                 }

                  

              

                    

            });

       

       if(document.getElementById("struct_type").value=='Hub'){

        

             jQuery("select[id*=source_]").each(function(i){

                   

                  var fistval = jQuery('#'+this.id).val();

                  jQuery("select[id*=source_]").each(function(j){

                   var  innerval = jQuery('#'+this.id).val();

                    if(fistval == innerval && j!=i){

                        

                         validate = false; 

                       

                    }

                    

                    });

              

                    

            })

       if(validate){

        

      }else{

        alert('All sources must be unique');

         return validate;

      }

     jQuery("select[id*=source_]").each(function(i){

                   

                  var fistval = jQuery('#'+this.id).val();

                  jQuery("select[id*=target1_]").each(function(j){

                   var  innerval = jQuery('#'+this.id).val();

                    if(fistval == innerval && j==i){

                        

                         validate = false; 

                       

                    }

                    

                    });

              

                    

            });

            if(validate){

        

      }else{

        alert('The central node must not match any of the sources');

         return validate;

      }

       for(k=1;k<=jQuery('#nofnodes').val();k++){

           if(document.getElementById("anchortext1_"+k).value==''){

           alert('Anchor Text should not be empty');

        return false;

        }

           

       }

      }

      if(document.getElementById("struct_type").value=='Ring'){

        jQuery("select[id*=source_]").each(function(i){

                   

                  var fistval = jQuery('#'+this.id).val();

                  jQuery("select[id*=source_]").each(function(j){

                   var  innerval = jQuery('#'+this.id).val();

                    if(fistval == innerval && j!=i){

                        

                         validate = false; 

                       

                    }

                    

                    });

              

                    

            })

       if(validate){

        

      }else{

        alert('All sources must be unique');

         return validate;

      }

      var ringsource=new Array(); 

      var ringtarget=new Array(); // regular array (add an optional integer



       for(k=1;k<=jQuery('#nofnodes').val();k++){

           

           if((k+1)<=jQuery('#nofnodes').val()){

            ringsource[k] = k;

             ringtarget[k] = k+1;

           }else{

            ringsource[k] = k;

             ringtarget[k] = 1;

           }

          

        }

        for(k=1;k<=jQuery('#nofnodes').val();k++){

            if(document.getElementById("target1_"+ringsource[k]).value!=document.getElementById("source_"+ringtarget[k]).value){

             alert('Target should equal to Source to make a Ring');

        return false;

            }

        

       }

       for(k=1;k<=jQuery('#nofnodes').val();k++){

           if(document.getElementById("anchortext1_"+k).value==''){

           alert('Anchor Text should not be empty');

        return false;

        }

           

       }
        for(k=1;k<=jQuery('#nofnodes').val();k++){

           if(document.getElementById("Introductorytext1_"+k).value==''){

           alert('Introductory Text should not be empty');

        return false;

        }

           

       }

       }

      if(document.getElementById("struct_type").value=='Web'){

       

             jQuery("select[id*=source_]").each(function(i){

                   

                  var fistval = jQuery('#'+this.id).val();

                  jQuery("select[id*=source_]").each(function(j){

                   var  innerval = jQuery('#'+this.id).val();

                    if(fistval == innerval && j!=i){

                        

                         validate = false; 

                       

                    }

                    

                    });

              

                    

            })

       if(validate){

        

      }else{

        alert('All sources must be unique');

         return validate;

      }

     jQuery("select[id*=source_]").each(function(i){

                   

                  var fistval = jQuery('#'+this.id).val();

                  jQuery("select[id*=target1_]").each(function(j){

                   var  innerval = jQuery('#'+this.id).val();

                    if(fistval == innerval && j==i){

                        

                         validate = false; 

                       

                    }

                    

                    });

              

                    

            });

            if(validate){

        

      }else{

        alert('The central node must not match any of the sources');

         return validate;

      }

    

      var ringsource=new Array(); 

      var ringtarget=new Array(); // regular array (add an optional integer



       for(k=1;k<=jQuery('#nofnodes').val();k++){

           

           if((k+1)<=jQuery('#nofnodes').val()){

            ringsource[k] = k;

             ringtarget[k] = k+1;

           }else{

            ringsource[k] = k;

             ringtarget[k] = 1;

           }

          

        }

        for(k=1;k<=jQuery('#nofnodes').val();k++){

            if(document.getElementById("target2_"+ringsource[k]).value!=document.getElementById("source_"+ringtarget[k]).value){

             alert('Target2 should equal to Source to make a Ring');

        return false;

            }

        

       }

       for(k=1;k<=jQuery('#nofnodes').val();k++){

           if(document.getElementById("anchortext1_"+k).value==''){

           alert('Anchor Text1 should not be empty');

        return false;

        }

           

       }

       for(k=1;k<=jQuery('#nofnodes').val();k++){

           if(document.getElementById("anchortext2_"+k).value==''){

           alert('Anchor Text2 should not be empty');

        return false;

        }

           

       }

       

       }

        if(document.getElementById("struct_type").value=='Star'){

        jQuery("select[id*=source_]").each(function(i){

                   

                  var fistval = jQuery('#'+this.id).val();

                  jQuery("select[id*=source_]").each(function(j){

                   var  innerval = jQuery('#'+this.id).val();

                    if(fistval == innerval && j!=i){

                        

                         validate = false; 

                       

                    }

                    

                    });

              

                    

            })

       if(validate){

        

      }else{

        alert('All sources must be unique');

         return validate;

      }

      var ringsource=new Array(); 

      var ringtarget=new Array(); // regular array (add an optional integer



       for(k=1;k<=jQuery('#nofnodes').val();k++){

           

           if((k+1)<=jQuery('#nofnodes').val()){

            ringsource[k] = k;

             ringtarget[k] = k+1;

           }else{

            ringsource[k] = k;

             ringtarget[k] = 1;

           }

          

        }

        for(k=1;k<=jQuery('#nofnodes').val();k++){

            if(document.getElementById("target1_"+ringsource[k]).value!=document.getElementById("source_"+ringtarget[k]).value){

             alert('Target should equal to Source to make a Ring');

        return false;

            }

        

       }

        var ringtarget2=new Array(); 

      var ringsource=new Array(); // regular array (add an optional integer

        var totnodes = jQuery('#nofnodes').val();

        for(k=1;k<=jQuery('#nofnodes').val();k++){

          if((k+2)<=jQuery('#nofnodes').val()){

            ringtarget2[k] = k;

             ringsource[k] = k+2;

           }else if((k+1)<=jQuery('#nofnodes').val()){

            ringtarget2[k] = k;

             ringsource[k] = 1;

           }else{

             ringtarget2[k] = k;

             ringsource[k] = 2;

           }

          

        }

            for(k=1;k<=jQuery('#nofnodes').val();k++){

            if(document.getElementById("target2_"+ringtarget2[k]).value!=document.getElementById("source_"+ringsource[k]).value){

             alert('Target2 should equal to (Node + 1) Source to make a Ring');

        return false;

            }

        

       }

       for(k=1;k<=jQuery('#nofnodes').val();k++){

           if(document.getElementById("anchortext1_"+k).value==''){

           alert('Anchor Text1 should not be empty');

        return false;

        }

           

       }

       for(k=1;k<=jQuery('#nofnodes').val();k++){

           if(document.getElementById("anchortext2_"+k).value==''){

           alert('Anchor Text2 should not be empty');

        return false;

        }

           

       }

       }

      if($defaultvalue){

            alert('There is one default value please select any link');

              return false;

        }

    

      return validate;

}

</script>