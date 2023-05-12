<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Retur Baru</h1>
        <p class="m-0">Retur</p>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo base_url() ?>transaksi"></i>Transaksi</a></li>
          <li class="breadcrumb-item active">Retur Baru</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</section>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <form id="form" method="post" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="form-group row">
                        <label class="form-label col-sm-3" for="">Nama Barang</label>
                        <div class="col-sm-4">
                          <select name="id_barang" id="id_barang" class="form-control">
                            <option value="">Pilih Barang</option>
                            <?php foreach ($barang_keluar as $key => $barang_keluar) { ?>
                              <option value="<?php echo $barang_keluar->id_barang ?>"><?php echo $barang_keluar->barang_name ?></option>
                            <?php } ?>
                          </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="form-label col-sm-3" for="">Warna</label>
                        <div class="col-sm-4 warna">
                          <select name="id_warna" id="id_warna" class="form-control">
                            <option value="">Pilih Warna</option>
                          </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="form-label col-sm-3" for="">Ukuran</label>
                        <div class="col-sm-4 ukuran">
                          <select name="ukuran" id="ukuran" class="form-control">
                            <option value="">Pilih Ukuran</option>
                          </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="form-label col-sm-3" for="">Jumlah</label>
                        <div class="col-sm-4">
                          <input type="number" class="form-control" name="jumlah" id="jumlah" placeholder="Jumlah">
                          <input type="hidden" name="id_transaksi" id="id_transaksi" value="<?php echo $id_transaksi ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="form-label col-sm-3" for="">Deskripsi</label>
                        <div class="col-sm-4">
                            <textarea name="description" id="description" class="form-control" placeholder="Deskripsi" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-12 text-right">
                            <a href="<?php echo base_url() ?>warna" class="btn btn-danger">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>


<script data-main="<?php echo base_url() ?>assets/js/main/main-transaksi" src="<?php echo base_url() ?>assets/js/require.js"></script>