<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Transaksi</h1>
        <p class="m-0">Detail Transaksi</p>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo base_url() ?>transaksi"></i>Transksi</a></li>
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
                      <img src="<?php echo base_url() ?>assets/images/logo-shopee.png" width="50" alt="">
                    </div>
                    <div class="col-nd-6 p-2 ml-2">
                      <h5>Shopee</h5>
                      <p class="text-secondary">www.shopee.com</p>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 text-right">
                  <b class="text-secondary">Dibuat Oleh</b>
                  <p class="text-secondary">Operator B</p>
                </div>
              </div>
              <div class="row">
                <div class="card m-2 bg-primary col-12" style="border-radius: 25px; background-image: url(<?php echo base_url() ?>assets/images/bg-card.png); background-size: cover; ">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-6">
                        <b>No. Resi</b>
                        <p>12389476128974361293</p>
                      </div>
                      <div class="col-md-6 text-right">
                        <b>Tanggal</b>
                        <p>02 Februari 2023</p>
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
                      <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                        <td>@mdo</td>
                        <td>@mdo</td>
                        <td>@mdo</td>
                      </tr>
                      <tr>
                        <td colspan="6" class="text-center">
                          <h4>      
                            Total
                          </h4>  
                        </td>
                        <td>
                          <h4>      
                          Rp. 2.000.000
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