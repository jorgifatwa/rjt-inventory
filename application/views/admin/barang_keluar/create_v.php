<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Barang Keluar Baru</h1>
        <p class="m-0">Barang Keluar</p>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo base_url() ?>barang_keluar"></i>Barang Keluar</a></li>
          <li class="breadcrumb-item active">Barang Keluar Baru</li>
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
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Tanggal</label>
                                <input type="hidden" id="role" value="<?php echo $this->data['users_groups']->id ?>">
                                <input type="date" name="tanggal" class="form-control" value="<?php echo date('Y-m-d') ?>" readonly>
                            </div>
                        </div>
                        <?php if($this->data['users_groups']->id != 3){ ?>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Ke Gudang</label>
                                    <?php if($this->data['users_groups']->id == 1){ ?>
                                        <select name="id_gudang" id="id_gudang" class="form-control select_gudang">
                                            <?php foreach ($gudangs as $key => $gudang) { ?>
                                                <option value="<?php echo $gudang->id ?>"><?php echo $gudang->nama ?></option>
                                            <?php } ?>
                                        </select>
                                    <?php }else if($this->data['users_groups']->id == 2){ ?>
                                        <input type="hidden" name="id_gudang" id="id_gudang" class="form-control" value="2">
                                        <input type="text" readonly name="nama_gudang" id="nama_gudang" class="form-control" value="Gudang B">
                                    <?php } ?>
                                </div>
                            </div>
                        <?php }else{ ?>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Marketplace</label>
                                    <select name="id_marketplace" id="id_marketplace" class="form-control select_marketplace">
                                        <?php foreach ($marketplaces as $key => $marketplace) { ?>
                                            <option value="<?php echo $marketplace->id ?>"><?php echo $marketplace->nama ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="<?php if($this->data['users_groups']->id != 3){ echo "col-md-12"; }else{ echo "col-md-6"; } ?>">
                            <div class="form-group">
                                <label for="">Kode Barang</label>
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="text" id="kode_barang" placeholder="Kode Barang" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if($this->data['users_groups']->id == 3){ ?>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">No. Resi</label>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <input type="text" id="no_resi" name="no_resi" placeholder="No. Resi" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <hr>
                    <div class="row mt-2">
                        <div class="col-md-9">
                            <h4>Daftar Barang Keluar</h4>
                        </div>
                    </div>
                    <div class="row data-barang">
                        
                    </div>
                    <div class="row">
                        <div class="col-md-9">
                            <h3>Total</h3>
                        </div>
                        <div class="col-md-3 text-right">
                            <h3 class="total">Rp.0</h3>
                            <input type="hidden" id="total" value="0">
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-12 text-right">
                            <a href="<?php echo base_url() ?>barang_keluar" class="btn btn-danger">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>


<script data-main="<?php echo base_url() ?>assets/js/main/main-barang-keluar" src="<?php echo base_url() ?>assets/js/require.js"></script>
