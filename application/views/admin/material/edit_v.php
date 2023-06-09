<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Ubah Material</h1>
        <p class="m-0">Material</p>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo base_url() ?>material"></i>Material</a></li>
          <li class="breadcrumb-item active">Ubah Material</li>
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
                        <label class="form-label col-sm-3" for="">Nama Material</label>
                        <div class="col-sm-4">
                            <input class="form-control" value="<?php echo $name; ?>" type="text" id="name" name="name" autocomplete="off" placeholder="Nama Material">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="form-label col-sm-3" for="">Kapasitas</label>
                        <div class="col-sm-2">
                            <input class="form-control number" type="text" id="capacity" name="capacity" autocomplete="off" placeholder="Kapasitas" value="<?php echo $capacity ?>">
                        </div>
                        <div class="col-sm-2">
                            <select id="uom" name="uom" class="form-control">
                                <option value="">Pilih Satuan</option>
                                <option value="bcm" <?php echo $uom == 'bcm' ? 'selected' : '' ?>>BCM</option>
                                <option value="ton" <?php echo $uom == 'ton' ? 'selected' : '' ?>>Ton</option>
                            </select>
                        </div>

                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-12 text-right">
                            <a href="<?php echo base_url() ?>material" class="btn btn-danger">Batal
                            </a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<script data-main="<?php echo base_url() ?>assets/js/main/main-material" src="<?php echo base_url() ?>assets/js/require.js"></script>
</section>