<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Barang</h1>
        <p class="m-0">Master Data</p>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo base_url() ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="breadcrumb-item active">Barang</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</section>

<section class="content">
  <div class="container-fluid">
    <div class="card mb-3">
		<div class="card-header">
			<div class="row">
				<div class="col-sm-12 text-right">
					<?php if ($is_can_create) {?>
						<a href="<?php echo base_url() ?>barang/create" class="btn btn-primary"><i class="fa fa-plus"></i> Barang</a>
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
							<th>Harga Modal</th>
							<th>Harga Jual Biasa</th>
							<th>Harga Jual Campaign</th>
							<th>Harga Jual Flash Sale</th>
							<th>Harga Jual Bottom</th>
							<th>Deskripsi</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</section>
 <script data-main="<?php echo base_url() ?>assets/js/main/main-barang" src="<?php echo base_url() ?>assets/js/require.js"></script>