<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Transaksi</h1>
        <p class="m-0">Detail Transaksi</p>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo base_url() ?>transaksi"></i>Transaksi</a></li>
          <li class="breadcrumb-item active">Detail Transaksi</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</section>

<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-nd-6 p-2">
                      <img src="<?php echo base_url() ?>assets/images/logo-<?php echo strtolower($marketplace) ?>.png" width="50" alt="">
                    </div>
                    <div class="col-nd-6 p-2 ml-2">
                      <h5><?php echo $marketplace ?></h5>
                      <p class="text-secondary">www.<?php echo strtolower($marketplace) ?>.com</p>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 text-right">
                  <b class="text-secondary">Dibuat Oleh</b>
                  <p class="text-secondary"><?php echo $dibuat_oleh ?></p>
                </div>
              </div>
              <div class="row">
                <div class="card m-2 bg-primary col-12" style="border-radius: 25px; background-image: url(<?php echo base_url() ?>assets/images/bg-card.png); background-size: cover; ">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-6">
                        <b>No. Resi</b>
                        <p><?php echo $no_resi ?></p>
                      </div>
                      <div class="col-md-6 text-right">
                        <b>Tanggal</b>
                        <p><?php echo $tanggal ?></p>
                      </div>
                    </div>
                  </div>
                </div> 
              </div>
              <div class="row mt-4">
                <div class="col-12">
                  <b>Detail Barang</b>
                  <p class="text-secondary">Daftar Barang yang dibeli</p>
                  <table class="table text-secondary">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama Barang</th>
                        <th scope="col">Warna</th>
                        <th scope="col">Ukuran</th>
                        <th scope="col">Jumlah</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Sub Total</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $total = [];
                        $no = 1;
                        foreach ($barang_keluar as $key => $barang_keluar) { 
                          $sub_total = $barang_keluar->jumlah * $barang_keluar->harga_jual_biasa;
                          array_push($total, $sub_total);
                      ?>
                      <tr>
                        <th scope="row"><?php echo $no; ?></th>
                        <td><?php echo $barang_keluar->barang_name ?></td>
                        <td><?php echo $barang_keluar->warna_name ?></td>
                        <td><?php echo $barang_keluar->ukuran ?></td>
                        <td><?php echo $barang_keluar->jumlah ?></td>
                        <td><?php echo "Rp. ".number_format($barang_keluar->harga_jual_biasa) ?></td>
                        <td><?php echo "Rp. ".number_format($sub_total) ?></td>
                      </tr>
                      <?php $no++; } ?>
                      <tr>
                        <td colspan="6" class="text-center">
                          <h4>      
                            Total
                          </h4>  
                        </td>
                        <td>
                          <h4>      
                          <?php echo "Rp. ".number_format(array_sum($total)) ?>
                          </h4>  
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>  
      </div>
    </div>
</section>


<script data-main="<?php echo base_url() ?>assets/js/main/main-transaksi" src="<?php echo base_url() ?>assets/js/require.js"></script>