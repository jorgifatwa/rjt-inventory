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
class Migration_insert_koli extends CI_Migration {


	public function up()
	{ 
		// insert function value
		 $data_menu = array(
            array('id'=>1,'nama'=>'Type A', 'jumlah'=> 50, 'description'=> ''),
            array('id'=>2,'nama'=>'Type B', 'jumlah'=> 40, 'description'=> ''),
        );
        $this->db->insert_batch('koli', $data_menu); 
	} 

	public function down()
	{
		
	}

}