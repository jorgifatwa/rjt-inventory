<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Retur</h1>
        <p class="m-0">Mater Data</p>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo base_url() ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="breadcrumb-item active">Retur</li>
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
                <div class="col-sm-12 text-right">
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No. Resi</th>
                            <th>Nama Barang</th>
                            <th>Warna</th>
                            <th>Ukuran</th>
                            <th>Jumlah</th>
                            <th>Deskripsi</th>
                            <?php if($this->data['users_groups']->id == 1){ ?>
                            <th>Aksi</th>
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
<script data-main="<?php echo base_url() ?>assets/js/main/main-retur" src="<?php echo base_url() ?>assets/js/require.js"></script>