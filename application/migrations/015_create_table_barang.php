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
class Migration_create_table_barang extends CI_Migration {


	public function up()
	{ 
		$table = "barang";
		$fields = array(
			'id'           => [
				'type'           => 'INT(11)',
				'auto_increment' => TRUE,
				'unsigned'       => TRUE,
			],
			'kode_barang'          => [
				'type' => 'VARCHAR(100)',
			],
			'nama'          => [
				'type' => 'VARCHAR(100)',
			],
			'harga_modal'      => [
				'type' => 'INT(11)',
			],
			'harga_jual_biasa'      => [
				'type' => 'INT(11)',
			],
			'harga_jual_campaign'      => [
				'type' => 'INT(11)',
				'null'       => TRUE,
			],
			'harga_jual_flash_sale'      => [
				'type' => 'INT(11)',
				'null'       => TRUE,
			],
			'harga_jual_bottom'      => [
				'type' => 'INT(11)',
			],
			'description'      => [
				'type' => 'TEXT',
			],
			'created_at'      => [
				'type' => 'DATETIME',
			],
			'updated_at'      => [
				'type' => 'DATETIME',
			],
			'created_by'      => [
				'type' => 'TINYINT(4)',
			],
			'updated_by'      => [
				'type' => 'TINYINT(4)',
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
		$table = "barang";
		if ($this->db->table_exists($table))
		{
			$this->db->query(drop_foreign_key($table, 'api_key'));
			$this->dbforge->drop_table($table);
		}
	}

}
