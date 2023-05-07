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
class Migration_insert_privilleges extends CI_Migration {


	public function up()
	{ 
		// insert function value
		 $data_menu = array(
            array('id'=>1,'role_id'=>2, 'menu_id'=> 12, 'function_id'=> 1),
            array('id'=>2,'role_id'=>2, 'menu_id'=> 12, 'function_id'=> 2),
            array('id'=>3,'role_id'=>2, 'menu_id'=> 12, 'function_id'=> 5),
            array('id'=>4,'role_id'=>2, 'menu_id'=> 11, 'function_id'=> 1),
            array('id'=>5,'role_id'=>2, 'menu_id'=> 11, 'function_id'=> 2),
            array('id'=>6,'role_id'=>2, 'menu_id'=> 11, 'function_id'=> 5),
            array('id'=>7,'role_id'=>2, 'menu_id'=> 1, 'function_id'=> 1),
            array('id'=>8,'role_id'=>2, 'menu_id'=> 10, 'function_id'=> 1),
            array('id'=>9,'role_id'=>3, 'menu_id'=> 12, 'function_id'=> 1),
            array('id'=>10,'role_id'=>3, 'menu_id'=> 12, 'function_id'=> 2),
            array('id'=>11,'role_id'=>3, 'menu_id'=> 12, 'function_id'=> 5),
            array('id'=>12,'role_id'=>3, 'menu_id'=> 11, 'function_id'=> 1),
            array('id'=>13,'role_id'=>3, 'menu_id'=> 11, 'function_id'=> 2),
            array('id'=>14,'role_id'=>3, 'menu_id'=> 11, 'function_id'=> 5),
            array('id'=>15,'role_id'=>3, 'menu_id'=> 1, 'function_id'=> 1),
            array('id'=>16,'role_id'=>3, 'menu_id'=> 10, 'function_id'=> 1)
        );
        $this->db->insert_batch('privilleges', $data_menu); 
	} 

	public function down()
	{
		
	}

}