<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Barang Masuk Baru</h1>
        <p class="m-0">Barang</p>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo base_url() ?>barang"></i>Barang</a></li>
          <li class="breadcrumb-item active">Barang Masuk Baru</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</section>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <form id="form" method="post">
                <div class="card-body">
                    <input type="hidden" id="role" value="<?php echo $this->data['users_groups']->id ?>">
                    <div class="row control-group">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Tanggal</label>
                                <input type="date" class="form-control" name="tanggal" id="tanggal" placeholder="Tanggal">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Kode Barang</label>
                                <input type="text" id="kode_barang" class="form-control" placeholder="Kode Barang">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <h3>
                        Daftar Barang Masuk
                    </h3>
                    <div class="row data-barang">                
                        
                    </div>

                    <!-- <div class="copy" hidden>
                        
                    </div> -->
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-12 text-right">
                            <a href="<?php echo base_url() ?>barang_masuk" class="btn btn-danger">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>


<script data-main="<?php echo base_url() ?>assets/js/main/main-barang-masuk" src="<?php echo base_url() ?>assets/js/require.js"></script>
