<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Ubah Barang</h1>
        <p class="m-0">Barang</p>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo base_url() ?>barang"></i>Barang</a></li>
          <li class="breadcrumb-item active">Ubah Barang</li>
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
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group row">
                                <label class="form-label col-sm-3" for="">Nama Barang</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="hidden" id="id" name="id" autocomplete="off" required placeholder="Nama Barang" value="<?php echo $id ?>">
                                    <input class="form-control" type="text" id="nama" name="nama" autocomplete="off" required placeholder="Nama Barang" value="<?php echo $nama ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="form-label col-sm-3" for="">Harga Modal</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="number" id="harga_modal" name="harga_modal" autocomplete="off" required placeholder="Harga Modal" value="<?php echo $harga_modal ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="form-label col-sm-3" for="">Harga Jual Biasa</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="number" id="harga_jual_ biasa" name="harga_jual_biasa" autocomplete="off" required placeholder="Harga Jual Biasa" value="<?php echo $harga_jual_biasa ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="form-label col-sm-3" for="">Harga Jual Grosir</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="number" id="harga_jual_grosir" name="harga_jual_grosir" autocomplete="off" required placeholder="Harga Jual Grosir" value="<?php echo $harga_jual_grosir ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="form-label col-sm-3" for="">Deskripsi</label>
                                <div class="col-sm-9">
                                    <textarea name="description" id="description" class="form-control" cols="30" rows="10"><?php echo $description ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="col-md-12">
                                <div style="margin-top: 50%">
                                    <center>
                                    <?php 
                                        $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
                                        echo '<img width="150" src="data:image/png;base64,' . base64_encode($generator->getBarcode($kode_barang, $generator::TYPE_CODE_128)) . '">';
                                        echo '<h4>'.$kode_barang.'</h4>';
                                    ?>
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-12 text-right">
                            <a href="<?php echo base_url() ?>barang" class="btn btn-danger">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>


<script data-main="<?php echo base_url() ?>assets/js/main/main-barang" src="<?php echo base_url() ?>assets/js/require.js"></script>


</section>
