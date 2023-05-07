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
class Migration_insert_warna extends CI_Migration {


	public function up()
	{ 
		// insert function value
		 $data_menu = array(
            array('id'=>1,'nama'=>'Abu - abu', 'description'=> ''),
            array('id'=>2,'nama'=>'Biru', 'description'=> ''),
            array('id'=>3,'nama'=>'Hijau', 'description'=> ''),
            array('id'=>4,'nama'=>'Hitam', 'description'=> ''),
            array('id'=>5,'nama'=>'Coklat', 'description'=> ''),
            array('id'=>6,'nama'=>'Putih', 'description'=> ''),
            array('id'=>7,'nama'=>'Cream', 'description'=> ''),
            array('id'=>8,'nama'=>'Merah', 'description'=> ''),
            array('id'=>9,'nama'=>'Ungu', 'description'=> ''),
            array('id'=>10,'nama'=>'Orange', 'description'=> ''),
            array('id'=>11,'nama'=>'Khaki', 'description'=> ''),
            array('id'=>12,'nama'=>'Gold', 'description'=> ''),
            array('id'=>13,'nama'=>'Silver', 'description'=> ''),
            array('id'=>14,'nama'=>'B&W', 'description'=> ''),
            array('id'=>15,'nama'=>'Biru Tosca', 'description'=> ''),
            array('id'=>16,'nama'=>'Full Black', 'description'=> ''),
            array('id'=>17,'nama'=>'List Hitam', 'description'=> ''),
            array('id'=>18,'nama'=>'List Hijau', 'description'=> ''),
            array('id'=>19,'nama'=>'List Putih', 'description'=> ''),
            array('id'=>20,'nama'=>'List Biru', 'description'=> ''),
            array('id'=>21,'nama'=>'List Abu - abu', 'description'=> ''),
            array('id'=>22,'nama'=>'Putih - Hijau', 'description'=> ''),
            array('id'=>23,'nama'=>'Putih - Biru', 'description'=> ''),
            array('id'=>24,'nama'=>'Putih - Orange', 'description'=> ''),
            array('id'=>25,'nama'=>'Hitam - Biru', 'description'=> ''),
            array('id'=>26,'nama'=>'Hitam - Kuning', 'description'=> ''),
            array('id'=>27,'nama'=>'Hitam - Putih', 'description'=> ''),
            array('id'=>28,'nama'=>'Cream - Hijau', 'description'=> ''),
        );
        $this->db->insert_batch('warna', $data_menu); 
	} 

	public function down()
	{
		
	}

}