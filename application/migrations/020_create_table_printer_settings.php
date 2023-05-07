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
class Migration_create_table_printer_settings extends CI_Migration {


	public function up()
	{ 
		$table = "printer_settings";
		$fields = array(
			'id'           => [
				'type'           => 'INT(11)',
				'auto_increment' => TRUE,
				'unsigned'       => TRUE,
			],  
			'jenis_printer_id'   => [
				'type'           => 'INT(11)',
			],  
			'printer_output' => [
				'type'           => 'ENUM("LAN","USB","SHARED","LINUX")',
			],  
			'alias'          => [
				'type' => 'VARCHAR(225)',
			],
			'nama_printer'          => [
				'type' => 'VARCHAR(225)',
			],
			'target_ip'          => [
				'type' => 'VARCHAR(225)',
			],
			'created_at'          => [
				'type' => 'DATETIME',
			],
			'updated_at'          => [
				'type' => 'DATETIME',
			],
			'is_deleted' => [
				'type' => 'TINYINT(4)',
			], 

		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table($table);
	 
	}


	public function down()
	{
		$table = "printer_settings";
		if ($this->db->table_exists($table))
		{ 
			$this->dbforge->drop_table($table);
		}
	}

}