<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Barang Keluar <?php if($this->data['users_groups']->id == 2){ echo "Gudang A"; }else if($this->data['users_groups']->id == 3){ echo "Gudang B"; } ?></h1>
        <p class="m-0">Master Data</p>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo base_url() ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="breadcrumb-item active">Barang Keluar</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</section>
<input type="hidden" id="role" value="<?php echo $this->data['users_groups']->id ?>">
<section class="content">
  <div class="container-fluid">
  	<div class="card mb-3">
		<div class="card-header">
			<div class="row">
				<div class="col-sm-6">
					<h3>Data Stok Barang</h3>
				</div>
			</div>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-striped table-bordered" id="table-stok" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>Nama Barang</th>
							<th>Ukuran</th>
							<th>Warna</th>
							<th>Jumlah</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>
    <div class="card mb-3">
		<div class="card-header">
			<div class="row">
				<div class="col-sm-6">
					<h3>Data Barang Keluar</h3>
				</div>
				<div class="col-sm-6 text-right">
					<?php if ($is_can_create) {?>
						<a href="<?php echo base_url() ?>barang_keluar/create" class="btn btn-primary"><i class="fa fa-plus"></i> Barang</a>
					<?php }?>
				</div>
			</div>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-striped table-bordered" id="table" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>Nama Barang</th>
							<th>Ukuran</th>
							<th>Warna</th>
							<?php if($this->data['users_groups']->id == 2){ ?>
								<th>Ke Gudang</th>
							<?php }else if($this->data['users_groups']->id == 3){ ?>
								<th>Marketplace</th>
							<?php } ?>
							<th>Jumlah</th>
							<th>Tanggal</th>
							<?php if($this->data['users_groups']->id == 1){ ?>
							<th>Action</th>
							<?php } ?>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</section>
 <script data-main="<?php echo base_url() ?>assets/js/main/main-barang-keluar" src="<?php echo base_url() ?>assets/js/require.js"></script>