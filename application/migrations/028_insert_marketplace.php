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
class Migration_insert_marketplace extends CI_Migration {


	public function up()
	{ 
		// insert function value
		 $data_menu = array(
            array('id'=>1,'nama'=>'Shopee', 'description'=> ''),
            array('id'=>2,'nama'=>'Tokopedia', 'description'=> ''),
            array('id'=>3,'nama'=>'Tiktok', 'description'=> ''),
            array('id'=>4,'nama'=>'Lazada', 'description'=> ''),
        );
        $this->db->insert_batch('marketplace', $data_menu); 
	} 

	public function down()
	{
		
	}

}