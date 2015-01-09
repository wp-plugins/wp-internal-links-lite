<?php 
function link_structures_operations($action,$data)
{       
  
   global $wpdb;
   	   $current_user = wp_get_current_user();
       $modby = $current_user->user_login;
  
	switch ($action) {
       case 'delete':
     
			 $id = $data['inl_link_id'];
          // print_r($data);
			$wpdb->query("DELETE FROM inl_link_structures WHERE id=$id");
            $wpdb->query("DELETE FROM inl_link_struct_to_links WHERE link_struct_id=$id");
            return true;
           
		break;
        case 'update':
     		 $id = $data['structureid'];
          $inl_str_name = $data['inl_str_name'];
                $inl_type = $data['inl_type'];
                $nofnodes = $data['nofnodes'];
                // print_r($data);
		
            $sql="UPDATE  inl_link_structures SET name='$inl_str_name',type='$inl_type',nodes=$nofnodes WHERE id=".$id;       
          
            $wpdb->query($sql);
         	$wpdb->query("DELETE FROM inl_link_struct_to_links WHERE link_struct_id=$id");
             for($i=1;$i<=$nofnodes;$i++){
                $source = $data['source_'.$i];
                 $target1 = $data['target1_'.$i];
                  if($inl_type=='Hub' || $inl_type=='Web'){
                    $target1 = $data['target1_1'];
                  }
                $anchor_text1 = $data['anchortext1_'.$i];
                $Introductorytext1 = $data['Introductorytext1_'.$i];
                $target2 = 0;
                $anchor_text2 = '';
                 if($inl_type!='Hub' && $inl_type!='Ring'  ){
                $target2 = $data['target2_'.$i];
                $anchor_text2 = $data['anchortext2_'.$i];
             
                }
                $sql = "INSERT INTO inl_link_struct_to_links (source,target1,target2,anchor_text1,anchor_text2,link_struct_id,
               create_date,created_by,mod_date,Introductory_text1) VALUES ($source,$target1,$target2,'$anchor_text1', '$anchor_text2', $id,'$curdate','$modby','$curdate','$Introductorytext1')";
               
                $wpdb->query($sql);
		      
               }
            return true;
           
		break;
      
		case 'insert':
      
                $inl_str_name = $data['inl_str_name'];
                $inl_type = $data['inl_type'];
                $nofnodes = $data['nofnodes'];
                $curdate = date( 'Y-m-d H:i:s');
               
          	
                if(($inl_str_name==''))
                return 'Please fill all the fields';
                $wpdb->query("INSERT INTO inl_link_structures (name,type,nodes,create_date,mod_date,mod_by) VALUES ('$inl_str_name', '$inl_type', $nofnodes,'$curdate','$curdate','$modby')");
		       $link_struct_id = mysql_insert_id();
            
               for($i=1;$i<=$nofnodes;$i++){
                $source = $data['source_'.$i];
                $target1 = $data['target1_'.$i];
                  if($inl_type=='Hub' || $inl_type=='Web'){
                    $target1 = $data['target1_1'];
                  }
                
                $anchor_text1 = $data['anchortext1_'.$i];
                 $Introductorytext1 = $data['Introductorytext1_'.$i];
                $target2 = 0;
                $anchor_text2 = '';
                if($inl_type!='Hub' && $inl_type!='Ring'  ){

                $target2 = $data['target2_'.$i];
                $anchor_text2 = $data['anchortext2_'.$i];
             
                }
                $sql = "INSERT INTO inl_link_struct_to_links (source,target1,target2,anchor_text1,anchor_text2,link_struct_id,
               create_date,created_by,mod_date,Introductory_text1) VALUES ($source,$target1,$target2,'$anchor_text1', '$anchor_text2', $link_struct_id,'$curdate','$modby','$curdate','$Introductorytext1')";
               
                $wpdb->query($sql);
		      
               }
            
           
            
            break;
    
   
        case 'list':
             
	        $sql = "SELECT * FROM inl_link_structures " ;
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
               return $data; 
            }
           
		  }
	        
    
		break;
   case 'getinlpost':
                $postid =  $data['source'];
              $sql = "SELECT * FROM inl_link_struct_to_links WHERE  source=". $postid;
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
               return $data; 
            }
           
		  }
	        
    
		break;
        default:
        
        	break;
	}
    
    
}
function getinlAffiliateURL(){
	$affiliateid = get_option(INLPLN_AFFILIATE_SETTINGS);
	$url = 'http://jvz5.com/c/';
	if($affiliateid!=''){
	$url.= $affiliateid;
	$url.='/140554';
	}else{
	return 'http://nosweatplugins.com/get-no-sweat-wp-internal-links-pro/?utm_source=plugin&utm_medium=link&utm_campaign=header';
	} 
return $url;
}

