<?php
function inlpln_lite_create_tables()
{ global $wpdb;
    if ($wpdb->get_var("SHOW TABLES LIKE 'inl_link_structures'") != 'inl_link_structures')
    {
        $sql = "CREATE  TABLE IF NOT EXISTS `inl_link_structures` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL ,
  `type` VARCHAR(10) NOT NULL ,
  `nodes` int NOT NULL ,
  `create_date` TIMESTAMP NULL ,
  `mod_date` TIMESTAMP NULL ,
  `mod_by` VARCHAR(50) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;";
        $wpdb->query($sql);
    }
     if ($wpdb->get_var("SHOW TABLES LIKE 'inl_link_struct_to_links'") != 'inl_link_struct_to_links')
    {
        $sql = "CREATE  TABLE IF NOT EXISTS `inl_link_struct_to_links` (
  `links_id` INT NOT NULL AUTO_INCREMENT,
  `source` INT NULL,
  `target1` INT  NULL,
  `target2` INT  NULL,
  `anchor_text1` VARCHAR(200) NULL ,
  `anchor_text2` VARCHAR(200) NULL ,
  `link_struct_id` INT NOT NULL ,
  `create_date` TIMESTAMP NULL ,
  `created_by` VARCHAR(50) NULL ,
  `mod_date` TIMESTAMP NULL ,
  PRIMARY KEY (`links_id`) )
ENGINE = InnoDB;";
        $wpdb->query($sql);
    }
    if ($wpdb->get_var("SHOW TABLES LIKE 'inl_link_struct_to_links'") == 'inl_link_struct_to_links')
    {
    $sql = "ALTER TABLE inl_link_struct_to_links ADD COLUMN `Introductory_text1` VARCHAR(200) NULL ";
    $wpdb->query($sql);
  }
  
  
}