<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Barang Baru</h1>
        <p class="m-0">Barang</p>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo base_url() ?>barang"></i>Barang</a></li>
          <li class="breadcrumb-item active">Barang Baru</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</section>

<section class="content">
    <div class="container-fluid">
        <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group row">
                                <label class="form-label col-sm-3" for="">Nama Barang</label>
                                <div class="col-sm-9">
                                    <input type="hidden" name="kode_barang" value="<?php echo $kode_barang ?>">
                                    <p>: <?php echo $nama ?></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="form-label col-sm-3" for="">Harga Modal</label>
                                <div class="col-sm-9">
                                    <p>: <?php echo "Rp. ".number_format($harga_modal) ?></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="form-label col-sm-3" for="">Harga Jual Biasa</label>
                                <div class="col-sm-9">
                                    <p>: <?php echo "Rp. ".number_format($harga_jual_biasa) ?></p>
                                </div>
                            </div>
                            <?php foreach ($ppns as $key => $ppn) { ?>
                                <div class="form-group row">
                                    <label class="form-label col-sm-3" for="">Harga <?php echo $ppn->marketplace_name ?></label>
                                    <div class="col-sm-9">
                                        <input type="hidden" name="id_marketplace[]" value="<?php echo $ppn->id_marketplace ?>">
                                        <p>: <?php echo "Rp. ".$ppn->harga_marketplace ?></p>
                                    </div>
                                </div>
                            <?php } ?>                     
                            <div class="form-group row">
                                <label class="form-label col-sm-3" for="">Harga Jual Campaign</label>
                                <div class="col-sm-9">
                                    <p>: <?php echo "Rp. ".$harga_jual_campaign ?></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="form-label col-sm-3" for="">Harga Jual Flash Sale</label>
                                <div class="col-sm-9">
                                    <p>: <?php echo "Rp. ".$harga_jual_flash_sale ?></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="form-label col-sm-3" for="">Harga Jual Bottom</label>
                                <div class="col-sm-9">
                                    <p>: <?php echo "Rp. ".$harga_jual_bottom ?></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="form-label col-sm-3" for="">Deskripsi</label>
                                <div class="col-sm-9">
                                    <p>: <?php echo $description ?></p>
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
                            <a href="<?php echo base_url() ?>barang" class="btn btn-danger">Kembali</a>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</section>


<script data-main="<?php echo base_url() ?>assets/js/main/main-barang" src="<?php echo base_url() ?>assets/js/require.js"></script>
