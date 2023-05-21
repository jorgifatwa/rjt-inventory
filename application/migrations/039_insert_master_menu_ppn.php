<?php
/**
 * @author   Natan Felles <natanfelles@gmail.com>
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Migration_create_table_api_limits
 *
 * @property CI_DB_forge         $dbforge
 * @property CI_DB_query_builder $db
 */
class Migration_insert_master_menu_ppn extends CI_Migration {


	public function up()
	{ 
		// insert function value
		 $data_menu = array(
            array('id'=>19,'module_id'=>1, 'name'=>'PPN', 'url'=>'ppn', 'parent_id'=>10, 'icon'=>"fa fa-circle-o", 'sequence'=>5), 
        );
        $this->db->insert_batch('menu', $data_menu); 
	} 

	public function down()
	{
		
	}

}