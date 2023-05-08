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
class Migration_insert_barang extends CI_Migration {


	public function up()
	{ 
		// insert function value
		 $data_menu = array(
            array('id'=>1,'kode_barang'=>'B001', 'nama'=> 'Fuccino', 'harga_modal'=> 77574, 'harga_jual_biasa'=> 139000, 'harga_jual_campaign'=> 135000, 'harga_jual_flash_sale'=> 129000, 'harga_jual_bottom'=> 119000, 'description'=> ''),
            array('id'=>2,'kode_barang'=>'B002', 'nama'=> 'Air Defender', 'harga_modal'=> 105400, 'harga_jual_biasa'=> 149000, 'harga_jual_campaign'=> 145000, 'harga_jual_flash_sale'=> 145000, 'harga_jual_bottom'=> 135000, 'description'=> ''),
            array('id'=>3,'kode_barang'=>'B003', 'nama'=> 'SandWolf', 'harga_modal'=> 80814, 'harga_jual_biasa'=> 125000, 'harga_jual_campaign'=> 119000, 'harga_jual_flash_sale'=> 119000, 'harga_jual_bottom'=> 110000, 'description'=> ''),
            array('id'=>4,'kode_barang'=>'B004', 'nama'=> 'Nuclear Fusion', 'harga_modal'=> 62400, 'harga_jual_biasa'=> 99000, 'harga_jual_campaign'=> 99000, 'harga_jual_flash_sale'=> 99000, 'harga_jual_bottom'=> 93000, 'description'=> ''),
            array('id'=>5,'kode_barang'=>'B005', 'nama'=> 'Aero Force', 'harga_modal'=> 144400, 'harga_jual_biasa'=> 197000, 'harga_jual_campaign'=> 197000, 'harga_jual_flash_sale'=> 194400, 'harga_jual_bottom'=> 184400, 'description'=> ''),
            array('id'=>6,'kode_barang'=>'B006', 'nama'=> 'Ultra Dynamic', 'harga_modal'=> 68000, 'harga_jual_biasa'=> 139000, 'harga_jual_campaign'=> 135000, 'harga_jual_flash_sale'=> 125000, 'harga_jual_bottom'=> 11800, 'description'=> ''),
            array('id'=>7,'kode_barang'=>'B007', 'nama'=> 'Air balance ', 'harga_modal'=> 64000, 'harga_jual_biasa'=> 129000, 'harga_jual_campaign'=> 125000, 'harga_jual_flash_sale'=> 125000, 'harga_jual_bottom'=> 115000, 'description'=> ''),
            array('id'=>8,'kode_barang'=>'B008', 'nama'=> 'Air Kenzo', 'harga_modal'=> 68244, 'harga_jual_biasa'=> 109000, 'harga_jual_campaign'=> 99000, 'harga_jual_flash_sale'=> 99000, 'harga_jual_bottom'=> 95000, 'description'=> ''),
            array('id'=>9,'kode_barang'=>'B009', 'nama'=> 'Anti Gravity', 'harga_modal'=> 80000, 'harga_jual_biasa'=> 149000, 'harga_jual_campaign'=> 139000, 'harga_jual_flash_sale'=> 139000, 'harga_jual_bottom'=> 129000, 'description'=> ''),
            array('id'=>10,'kode_barang'=>'B0010', 'nama'=> 'Black Stealh', 'harga_modal'=> 60000, 'harga_jual_biasa'=> 99000, 'harga_jual_campaign'=> 99000, 'harga_jual_flash_sale'=> 99000, 'harga_jual_bottom'=> 90000, 'description'=> ''),
            array('id'=>11,'kode_barang'=>'B0011', 'nama'=> 'Shinjuku', 'harga_modal'=> 72556, 'harga_jual_biasa'=> 139000, 'harga_jual_campaign'=> 135000, 'harga_jual_flash_sale'=> 135000, 'harga_jual_bottom'=> 125000, 'description'=> ''),
            array('id'=>12,'kode_barang'=>'B0012', 'nama'=> 'Street Runner', 'harga_modal'=> 61610, 'harga_jual_biasa'=> 119000, 'harga_jual_campaign'=> 115000, 'harga_jual_flash_sale'=> 115000, 'harga_jual_bottom'=> 109000, 'description'=> ''),
            array('id'=>13,'kode_barang'=>'B0013', 'nama'=> 'Black Jade', 'harga_modal'=> 92658, 'harga_jual_biasa'=> 155000, 'harga_jual_campaign'=> 149000, 'harga_jual_flash_sale'=> 149000, 'harga_jual_bottom'=> 139000, 'description'=> ''),
            array('id'=>14,'kode_barang'=>'B0014', 'nama'=> 'Neyra', 'harga_modal'=> 95000, 'harga_jual_biasa'=> 145000, 'harga_jual_campaign'=> 0, 'harga_jual_flash_sale'=> 0, 'harga_jual_bottom'=> 130000, 'description'=> ''),
            array('id'=>15,'kode_barang'=>'B0015', 'nama'=> 'Satella', 'harga_modal'=> 115000, 'harga_jual_biasa'=> 140000, 'harga_jual_campaign'=> 0, 'harga_jual_flash_sale'=> 0, 'harga_jual_bottom'=> 135000, 'description'=> ''),
            array('id'=>16,'kode_barang'=>'B0016', 'nama'=> 'Alvaro', 'harga_modal'=> 95000, 'harga_jual_biasa'=> 130000, 'harga_jual_campaign'=> 0, 'harga_jual_flash_sale'=> 0, 'harga_jual_bottom'=> 115000, 'description'=> ''),
            array('id'=>17,'kode_barang'=>'B0017', 'nama'=> 'Carolus', 'harga_modal'=> 78000, 'harga_jual_biasa'=> 120000, 'harga_jual_campaign'=> 0, 'harga_jual_flash_sale'=> 0, 'harga_jual_bottom'=> 115000, 'description'=> ''),
            array('id'=>18,'kode_barang'=>'B0018', 'nama'=> 'Riveign', 'harga_modal'=> 96000, 'harga_jual_biasa'=> 130000, 'harga_jual_campaign'=> 0, 'harga_jual_flash_sale'=> 0, 'harga_jual_bottom'=> 119000, 'description'=> ''),
            array('id'=>19,'kode_barang'=>'B0019', 'nama'=> 'Basies', 'harga_modal'=> 90000, 'harga_jual_biasa'=> 110000, 'harga_jual_campaign'=> 0, 'harga_jual_flash_sale'=> 0, 'harga_jual_bottom'=> 110000, 'description'=> ''),
            array('id'=>20,'kode_barang'=>'B0020', 'nama'=> 'Hugo', 'harga_modal'=> 85000, 'harga_jual_biasa'=> 115000, 'harga_jual_campaign'=> 0, 'harga_jual_flash_sale'=> 0, 'harga_jual_bottom'=> 105000, 'description'=> ''),
            array('id'=>21,'kode_barang'=>'B0021', 'nama'=> 'Obside', 'harga_modal'=> 95000, 'harga_jual_biasa'=> 129000, 'harga_jual_campaign'=> 0, 'harga_jual_flash_sale'=> 0, 'harga_jual_bottom'=> 115000, 'description'=> ''),
            array('id'=>22,'kode_barang'=>'B0022', 'nama'=> 'Zanders', 'harga_modal'=> 105000, 'harga_jual_biasa'=> 145000, 'harga_jual_campaign'=> 0, 'harga_jual_flash_sale'=> 0, 'harga_jual_bottom'=> 125000, 'description'=> ''),
            array('id'=>23,'kode_barang'=>'B0023', 'nama'=> 'Luminous', 'harga_modal'=> 85000, 'harga_jual_biasa'=> 140000, 'harga_jual_campaign'=> 0, 'harga_jual_flash_sale'=> 0, 'harga_jual_bottom'=> 130000, 'description'=> ''),
            array('id'=>24,'kode_barang'=>'B0024', 'nama'=> 'Lazert', 'harga_modal'=> 95000, 'harga_jual_biasa'=> 135000, 'harga_jual_campaign'=> 0, 'harga_jual_flash_sale'=> 0, 'harga_jual_bottom'=> 110000, 'description'=> ''),
            array('id'=>25,'kode_barang'=>'B0025', 'nama'=> 'Bounce', 'harga_modal'=> 75000, 'harga_jual_biasa'=> 110000, 'harga_jual_campaign'=> 0, 'harga_jual_flash_sale'=> 0, 'harga_jual_bottom'=> 95000, 'description'=> ''),
            array('id'=>26,'kode_barang'=>'B0026', 'nama'=> 'Wanwoo', 'harga_modal'=> 81000, 'harga_jual_biasa'=> 125000, 'harga_jual_campaign'=> 0, 'harga_jual_flash_sale'=> 0, 'harga_jual_bottom'=> 101000, 'description'=> ''),
            array('id'=>27,'kode_barang'=>'B0027', 'nama'=> 'Isthar Own', 'harga_modal'=> 87000, 'harga_jual_biasa'=> 127000, 'harga_jual_campaign'=> 0, 'harga_jual_flash_sale'=> 0, 'harga_jual_bottom'=> 107000, 'description'=> ''),
            array('id'=>28,'kode_barang'=>'B0028', 'nama'=> 'Martin Lutter', 'harga_modal'=> 95000, 'harga_jual_biasa'=> 162000, 'harga_jual_campaign'=> 0, 'harga_jual_flash_sale'=> 0, 'harga_jual_bottom'=> 115000, 'description'=> ''),
            array('id'=>29,'kode_barang'=>'B0029', 'nama'=> 'Veccino', 'harga_modal'=> 95000, 'harga_jual_biasa'=> 145000, 'harga_jual_campaign'=> 0, 'harga_jual_flash_sale'=> 0, 'harga_jual_bottom'=> 115000, 'description'=> ''),
            array('id'=>30,'kode_barang'=>'B0030', 'nama'=> 'Orion ', 'harga_modal'=> 95000, 'harga_jual_biasa'=> 147000, 'harga_jual_campaign'=> 0, 'harga_jual_flash_sale'=> 0, 'harga_jual_bottom'=> 115000, 'description'=> ''),
            array('id'=>31,'kode_barang'=>'B0031', 'nama'=> 'Alkira', 'harga_modal'=> 90000, 'harga_jual_biasa'=> 130000, 'harga_jual_campaign'=> 0, 'harga_jual_flash_sale'=> 0, 'harga_jual_bottom'=> 110000, 'description'=> ''),
            array('id'=>32,'kode_barang'=>'B0032', 'nama'=> 'Braxton', 'harga_modal'=> 95000, 'harga_jual_biasa'=> 135000, 'harga_jual_campaign'=> 0, 'harga_jual_flash_sale'=> 0, 'harga_jual_bottom'=> 115000, 'description'=> ''),
            array('id'=>33,'kode_barang'=>'B0033', 'nama'=> 'Fade Khina', 'harga_modal'=> 230000, 'harga_jual_biasa'=> 270000, 'harga_jual_campaign'=> 0, 'harga_jual_flash_sale'=> 0, 'harga_jual_bottom'=> 250000, 'description'=> ''),
            array('id'=>34,'kode_barang'=>'B0034', 'nama'=> 'Going Merry', 'harga_modal'=> 162000, 'harga_jual_biasa'=> 190000, 'harga_jual_campaign'=> 0, 'harga_jual_flash_sale'=> 0, 'harga_jual_bottom'=> 182000, 'description'=> ''),
            array('id'=>35,'kode_barang'=>'B0035', 'nama'=> 'Brussel', 'harga_modal'=> 142000, 'harga_jual_biasa'=> 179000, 'harga_jual_campaign'=> 0, 'harga_jual_flash_sale'=> 0, 'harga_jual_bottom'=> 162000, 'description'=> ''),
            array('id'=>36,'kode_barang'=>'B0036', 'nama'=> 'Deep Venom', 'harga_modal'=> 100000, 'harga_jual_biasa'=> 140000, 'harga_jual_campaign'=> 0, 'harga_jual_flash_sale'=> 0, 'harga_jual_bottom'=> 120000, 'description'=> ''),
            array('id'=>37,'kode_barang'=>'B0037', 'nama'=> 'Phantom Slayer', 'harga_modal'=> 106000, 'harga_jual_biasa'=> 146000, 'harga_jual_campaign'=> 0, 'harga_jual_flash_sale'=> 0, 'harga_jual_bottom'=> 126000, 'description'=> ''),
            array('id'=>38,'kode_barang'=>'B0038', 'nama'=> 'Invoker Master', 'harga_modal'=> 123000, 'harga_jual_biasa'=> 159000, 'harga_jual_campaign'=> 0, 'harga_jual_flash_sale'=> 0, 'harga_jual_bottom'=> 143000, 'description'=> ''),
            array('id'=>39,'kode_barang'=>'B0039', 'nama'=> 'Holly Baldwin', 'harga_modal'=> 102000, 'harga_jual_biasa'=> 142000, 'harga_jual_campaign'=> 0, 'harga_jual_flash_sale'=> 0, 'harga_jual_bottom'=> 122000, 'description'=> ''),
        );
        $this->db->insert_batch('barang', $data_menu); 
	} 

	public function down()
	{
		
	}

}