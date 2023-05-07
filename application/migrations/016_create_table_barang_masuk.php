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
class Migration_create_table_barang_masuk extends CI_Migration {


	public function up()
	{ 
		$table = "barang_masuk";
		$fields = array(
			'id'           => [
				'type'           => 'INT(11)',
				'auto_increment' => TRUE,
				'unsigned'       => TRUE,
			],
			'id_barang'          => [
				'type' => 'TINYINT(4)',
			],
			'id_gudang'          => [
				'type' => 'TINYINT(4)',
			],
			'id_koli'          => [
				'type' => 'TINYINT(4)',
				'null' => true
			],
			'id_warna'          => [
				'type' => 'TINYINT(4)',
				'null' => true
			],
			'ukuran'          => [
				'type' => 'INT(11)',
				'null' => true
			],
			'status_ukuran'          => [
				'type' => 'VARCHAR(11)',
				'null' => true
			],
			'jumlah_koli'          => [
				'type' => 'VARCHAR(100)',
				'null' => true
			],
			'jumlah_barang'          => [
				'type' => 'VARCHAR(100)',
			],
			'tanggal'          => [
				'type' => 'DATE',
			],
			'created_at'      => [
				'type' => 'DATETIME',
			],
			'created_by'      => [
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
		$table = "barang_masuk";
		if ($this->db->table_exists($table))
		{
			$this->db->query(drop_foreign_key($table, 'api_key'));
			$this->dbforge->drop_table($table);
		}
	}

}
