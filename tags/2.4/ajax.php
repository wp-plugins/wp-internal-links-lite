    <table class="form-table" width="800px;"> <tr valign="top">
                <th scope="row"><label for="name"><?php echo __('# of Nodes', 'inl'); ?><span style="color: red;">*</span></label>
                </th>
                <td>
                    <select name="nofnodes" id="nofnodes" onchange="getblocks(this.value,this.id);" onclick="getoldblock(this.value,this.id)" style="width: 46px !important;">
                   <?php 
                   
                   if($inl_type=='Star'){
                    if($nodes<4){
                        $nodes =4;
                    }
                    ?>
                     <option value="4" <?php if($nodes==4) echo 'selected="selected"';?>>4</option>
                    <option value="5" <?php if($nodes==5) echo 'selected="selected"';?>>5</option>
                    <option value="6" <?php if($nodes==6) echo 'selected="selected"';?>>6</option>
                  
                    <?php
                   }else{?>
                    <option value="3" <?php if($nodes==3 || $nodes=='') echo 'selected="selected"';?>>3</option>
                    <option value="4" <?php if($nodes==4) echo 'selected="selected"';?>>4</option>
                    <option value="5" <?php if($nodes==5) echo 'selected="selected"';?>>5</option>
                    <option value="6" <?php if($nodes==6) echo 'selected="selected"';?>>6</option>
                    <?php } ?>
                    </select>
                  <p class="description">The central node in the Hub or The Web is not taken into account. <br />Also, beware that if you modify this number while you are editing the structure, the values below will be reset. Either choose the right value first, or save the structure and then come back and edit it</p>  
                </td>
            </tr></table>
    <table class="dynamicstructure" width="800px;">
    

        <tr><td >

        <?php 

        $disabled = 'disabled="disabled"';

   $charLimit = 40;

 $totposts = getinllinks($operation);


        

        

      if(isset($operation) && $operation=='edit' && $structid!=''){

        $data['inl_link_id'] = $structid;

        $inldata = link_structures_operations('edit',$data);

        $inlfinaldata = '';

        for($j=0;$j<count($inldata);$j++){

         $inlfinaldata[$j+1] = $inldata[$j];   

        }

       

      }

      
        
        for($i=1;$i<=$nodes;$i++){  

            

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

                    <option value="<?php echo $totposts[$j]['id']?>" <?php if(isset($inlfinaldata[$i]['source']) && $inlfinaldata[$i]['source']==$totposts[$j]['id']) echo 'selected="selected"'?>><?php echo $totposts[$j]['title']?></option>

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

                   <select name="target1_<?php echo $i?>" id="target1_<?php echo $i?>" <?php if($i!=1 && ($inl_type=='Hub' || $inl_type=='Web' ))echo $disabled;?> >

                    <?php 

                   for($j=0;$j<count($totposts);$j++){

                     if(strlen($totposts[$j]['title']) > $charLimit){

                      $totposts[$j]['title'] =  substr($totposts[$j]['title'],0,$charLimit);

                    }

                    ?>

                    <option value="<?php echo $totposts[$j]['id']?>" <?php if(isset($inlfinaldata[$i]['target1']) && $inlfinaldata[$i]['target1']==$totposts[$j]['id'] ) echo 'selected="selected"'?>><?php echo $totposts[$j]['title']?></option>

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

                   <input type="text" name="anchortext1_<?php echo $i?>" id="anchortext1_<?php echo $i?>" value="<?php if(isset($inlfinaldata[$i]['anchor_text1']) && $inlfinaldata[$i]['anchor_text1']!='') echo $inlfinaldata[$i]['anchor_text1'];?>"/>

                   

                </td>

                </tr>
                <tr>

                <td><label for="name"><?php echo __('Introductory Text', 'inl'); ?><span style="color: red;">*</span></label>

                </td>

                <td>

                   <input type="text" name="Introductorytext1_<?php echo $i?>" id="Introductorytext1_<?php echo $i?>" value="<?php echo $introductorytext;?>"/>

                   

                </td>

                </tr>

                <?php if($inl_type!='Hub' && $inl_type!='Ring'){ ?>

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

                    <option value="<?php echo $totposts[$j]['id']?>" <?php if(isset($inlfinaldata[$i]['target2']) && $inlfinaldata[$i]['target2']==$totposts[$j]['id']) echo 'selected="selected"'?>><?php echo $totposts[$j]['title']?></option>

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

                   <input type="text" name="anchortext2_<?php echo $i?>" id="anchortext2_<?php echo $i?>" value="<?php if(isset($inlfinaldata[$i]['anchor_text2']) && $inlfinaldata[$i]['anchor_text2']!='') echo $inlfinaldata[$i]['anchor_text2'];?>"/>

                 

                </td>

                </tr>

                <?php }?>

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