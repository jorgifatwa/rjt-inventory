<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Ubah Barang Masuk</h1>
        <p class="m-0">Barang Masuk</p>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo base_url() ?>barang_masuk"></i>Barang Masuk</a></li>
          <li class="breadcrumb-item active">Ubah Barang Masuk</li>
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
                    <div class="form-group row">
                        <label class="form-label col-sm-3" for="">Tanggal</label>
                        <div class="col-sm-4">
                            <input class="form-control" type="date" id="tanggal" name="tanggal" autocomplete="off" required placeholder="Stock" value="<?php echo $tanggal ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="form-label col-sm-3" for="">Nama Barang</label>
                        <div class="col-sm-4">
                            <input class="form-control" type="hidden" id="id" name="id" autocomplete="off" required placeholder="Nama Barang" value="<?php echo $id ?>">
                            <input class="form-control" type="hidden" id="" name="id_barang" autocomplete="off" required placeholder="Nama Barang" value="<?php echo $id_barang ?>" readonly>
                            <input class="form-control" type="text" id="nama_barang" name="nama_barang" autocomplete="off" required placeholder="Nama Barang" value="<?php echo $barang_name ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="form-label col-sm-3" for="">Jumlah</label>
                        <div class="col-sm-4">
                            <input class="form-control" type="number" id="jumlah" name="jumlah" autocomplete="off" required placeholder="Harga Modal" value="<?php echo $jumlah ?>">
                        </div>
                    </div>
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


</section>
