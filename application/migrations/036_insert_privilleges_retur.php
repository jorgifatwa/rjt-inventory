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
class Migration_insert_privilleges_retur extends CI_Migration {


	public function up()
	{ 
		// insert function value
		 $data_menu = array(
            array('id'=>21,'role_id'=>3, 'menu_id'=> 18, 'function_id'=> 1),
            array('id'=>22,'role_id'=>3, 'menu_id'=> 18, 'function_id'=> 2),
            array('id'=>23,'role_id'=>3, 'menu_id'=> 18, 'function_id'=> 5),
        );
        $this->db->insert_batch('privilleges', $data_menu); 
	} 

	public function down()
	{
		
	}

}