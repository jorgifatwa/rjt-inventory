<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Ubah Order</h1>
        <p class="m-0">Order</p>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo base_url() ?>order"></i>Order</a></li>
          <li class="breadcrumb-item active">Ubah Order</li>
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
                    <input type="hidden" id="id" name="id" value="<?php echo $id ?>">
                    <input type="hidden" id="selected_paket" value="<?php echo $id_paket ?>">
                    <div class="form-group row">
                        <label class="form-label col-sm-3" for="">Pelayanan</label>
                        <div class="col-sm-9">
                            <select name="id_pelayanan" id="id_pelayanan" class="form-control">
                                <option value="">Pilih Pelayanan</option>
                                <?php foreach ($pelayanans as $pelayanan) {?>
                                <option value="<?php echo $pelayanan->id ?>" <?php if($id_pelayanan == $pelayanan->id){ echo "selected"; } ?>><?php echo $pelayanan->name ?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="form-label col-sm-3" for="">Paket</label>
                        <div class="col-sm-9">
                            <select name="id_paket" id="id_paket" class="form-control">
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="form-label col-sm-3" for="">Tanggal</label>
                        <div class="col-sm-9">
                            <input class="form-control" type="text" value="<?php echo $tanggal ?>" id="tanggal" name="tanggal" autocomplete="off" required placeholder="Tanggal">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="form-label col-sm-3" for="">Nickname</label>
                        <div class="col-sm-9">
                            <input class="form-control" type="text" id="nickname" name="nickname" value="<?php echo $nickname ?>" autocomplete="off" required placeholder="Nickname">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="form-label col-sm-3" for="">Email</label>
                        <div class="col-sm-9">
                            <input class="form-control" type="text" id="email" name="email" autocomplete="off" required placeholder="Email" value="<?php echo $email ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="form-label col-sm-3" for="">Password</label>
                        <div class="col-sm-9">
                            <input class="form-control" type="text" id="password" name="password" autocomplete="off" required placeholder="Password" value="<?php echo $password ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="form-label col-sm-3" for="">Login Via</label>
                        <div class="col-sm-9">
                            <input class="form-control" type="text" id="login_via" name="login_via" autocomplete="off" required placeholder="Login Via" value="<?php echo $login_via ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="form-label col-sm-3" for="">Request Hero</label>
                        <div class="col-sm-9">
                            <input class="form-control" type="text" id="request_hero" name="request_hero" autocomplete="off" required placeholder="Request Hero" value="<?php echo $request_hero ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="form-label col-sm-3" for="">Nomor Whatsapp</label>
                        <div class="col-sm-9">
                            <input class="form-control" type="text" id="nomor_whatsapp" name="nomor_whatsapp" autocomplete="off" required placeholder="Nomor Whatsapp" value="<?php echo $nomor_whatsapp ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="form-label col-sm-3" for="">Preview Bukti Pembayaran</label>
                        <div class="col-sm-9">
                            <center>
                                <a href="<?php echo base_url('uploads/order/'.$bukti_pembayaran) ?>" target="_blank">
                                    <img src="<?php echo base_url('uploads/order/'.$bukti_pembayaran) ?>" width="100" alt="">
                                </a>
                            </center>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="form-label col-sm-3" for="">Bukti Pembayaran</label>
                        <div class="col-sm-9">
                            <input class="form-control" type="file" id="bukti_pembayaran" name="bukti_pembayaran" autocomplete="off" placeholder="Bukti Pembayaran">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="form-label col-sm-3" for="">Catatan</label>
                        <div class="col-sm-9">
                            <textarea name="catatan" id="catatan" class="form-control" cols="30" placeholder="Catatan" rows="10"><?php echo $catatan ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-12 text-right">
                            <a href="<?php echo base_url() ?>order" class="btn btn-danger">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>


<script data-main="<?php echo base_url() ?>assets/js/main/main-order" src="<?php echo base_url() ?>assets/js/require.js"></script>


</section>
