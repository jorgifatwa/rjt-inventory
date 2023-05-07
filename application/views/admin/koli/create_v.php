<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Koli Baru</h1>
        <p class="m-0">Koli</p>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo base_url() ?>koli"></i>Koli</a></li>
          <li class="breadcrumb-item active">Koli Baru</li>
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
                        <label class="form-label col-sm-3" for="">Nama Koli</label>
                        <div class="col-sm-4">
                            <input class="form-control" type="text" id="name" name="name" autocomplete="off" placeholder="Nama Gudang">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="form-label col-sm-3" for="">Jumlah</label>
                        <div class="col-sm-4">
                            <input class="form-control" type="number" id="jumlah" name="jumlah" autocomplete="off" placeholder="Jumlah">
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
                            <a href="<?php echo base_url() ?>koli" class="btn btn-danger">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>


<script data-main="<?php echo base_url() ?>assets/js/main/main-koli" src="<?php echo base_url() ?>assets/js/require.js"></script>