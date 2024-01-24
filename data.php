<?php
$dataModal = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tb_modal WHERE id_grup='$idgrup' AND id_toko='$idtoko'"));
$sel_penjualan = mysqli_query($con, "SELECT * FROM tb_penjualan WHERE id_grup='$idgrup' AND id_toko='$idtoko' AND tanggal='$tanggal' AND bulan='$bulan' AND tahun='$tahun' ORDER BY id_penjualan DESC");
$res_penjualan = mysqli_num_rows($sel_penjualan);
if($res_penjualan === 0){
  mysqli_query($con, "DELETE FROM tb_pengeluaran WHERE id_grup='$idgrup' AND id_toko='$idtoko' AND tanggal='$tanggal' AND bulan='$bulan' AND tahun='$tahun'");
}
?>
<div class="container px-1">
<?php if(!(isset($_GET['pg']))){ ?>
  <div id="pilihTanggal" class="row my-0 mx-auto mb-2" style="max-width:557px">
    <div class="col-3">
      <select id="selTanggal" class="form-control text-center p-1">
        <option selected="" value="">- -</option>
<?php
for($tgl = 1; $tgl < 31; $tgl++){
  if($tgl < 10){
    $tgl = '0'.$tgl;
  }
  $valTanggal = $tgl;
  if($valTanggal == $tanggal){
    $selected = 'selected ';
  }else{
    $selected = '';
  }
?>
        <option <?=$selected;?>value="<?=$valTanggal;?>"><?=$valTanggal;?></option>
<?php } ?>
      </select>
    </div>
    <div class="col-4 px-2">
      <select id="selBulan" class="form-control text-center p-1">
        <option selected="" value="">- - - - -</option>
<?php
$bl = ['januari', 'februari', 'maret', 'april', 'mei', 'juni', 'juli', 'agustus', 'september', 'oktober', 'november', 'desember'];
for($bln = 0; $bln < count($bl); $bln++){
  $valBulan = $bl[$bln];
  if($valBulan == $bulan){
    $selected = 'selected ';
  }else{
    $selected = '';
  }
?>
        <option <?=$selected;?>value="<?=$valBulan;?>"><?=ucwords($valBulan);?></option>
<?php } ?>
      </select>
    </div>
    <div class="col-3 pe-2">
      <select id="selTahun" class="form-control text-center p-1">
        <option selected="" value="">- - -</option>
<?php
$th1 = date('Y');
$thn = [$th1-2, $th1-1, $th1];
for($th = 0; $th < count($thn); $th++){
  $valTahun = $thn[$th];
  if($valTahun == $tahun){
    $selected = 'selected ';
  }else{
    $selected = '';
  }
?>
        <option <?=$selected;?>value="<?=$valTahun;?>"><?=$valTahun;?></option>
<?php } ?>
      </select>
    </div>
    <div class="col-2">
      <button type="button" class="btn text-bg-info py-1" style="width:37px;height:34px"><i class="fas fa-angle-right"></i></button>
    </div>
  </div>
<?php } if($res_penjualan){ ?>
  <div class="tab-auto">
    <table class="table table-hover mb-0" style="white-space:wrap">
      <thead>
        <tr>
          <th>Merek</th>
          <th>Harga</th>
          <th>Laba</th>
          <th style="width:60px" colspan="2" class="text-center"><i class="fas fa-angle-down"></i></th>
        </tr>
      </thead>
      <tbody>
<?php
while($row_penjualan = mysqli_fetch_array($sel_penjualan)){
  if(preg_match('/\./i', $row_penjualan['jumlah'])){
    $data_jumlah = str_replace('.', ',',$row_penjualan['jumlah']);
  }else{
    $data_jumlah = number_format($row_penjualan['jumlah'],0,',','.');
  }
?>
        <tr>
          <td valign="middle"><?=$row_penjualan['nama'];?></td>
          <td valign="middle" style="white-space:nowrap"><?=number_format($row_penjualan['harga'],0,',','.').' × '.$data_jumlah;?></td>
          <td valign="middle"><?=number_format($row_penjualan['laba'],0,',','.');?></td>
          <td style="width:32px" valign="middle" class="text-center" id="btn-edit" valign="middle" data-bs-toggle="modal" data-bs-target="#editPenjualan" data-id="<?=$row_penjualan['id_penjualan'];?>" data-nama="<?=$row_penjualan['nama'];?>" data-harga="<?=$row_penjualan['harga'];?>" data-jumlah="<?=$data_jumlah;?>" data-modal="<?=$row_penjualan['modal'];?>"><i class="fas fa-edit text-success"></i></td>
        <td style="width:32px" valign="middle" class="text-center" id="btn-hapus" data-id="<?=$row_penjualan['id_penjualan'];?>" data-nama="<?=$row_penjualan['nama'];?>"><i class="fas fa-trash text-danger"></i></span>
          </td>
        </tr>
<?php } ?>
      </tbody>
    </table>
  </div>
  <!-- modal edit item penjualan -->
  <div class="modal fade" id="editPenjualan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <form autocomplete="off" id="edit-penjualan">
            <h5 class="border-bottom pb-2">Edit Data Penjualan</h5>
            <div class="mb-3">
              <label for="nama" class="form-label">Nama / Merek</label>
              <input type="search" id="nama" class="form-control" placeholder="Masukkan Nama / Merek..." readonly="">
              <div class="err"></div>
            </div>
            <div class="row mb-3">
              <div class="col">
                <label for="harga" class="form-label">Harga Jual</label>
                <input type="search" id="harga" class="form-control" placeholder="Masukkan Harga Jual...">
                <div class="err"></div>
              </div>
              <div class="col">
                <label for="jumlah" class="form-label">Jumlah</label>
                <input type="search" id="jumlah" class="form-control" placeholder="Masukkan Jumlah...">
                <div class="err"></div>
              </div>
            </div>
            <div class="text-end">
              <button type="button" id="batalEdit" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
              <button type="submit" class="btn text-bg-info">Perbarui</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
<?php
$sum_omset = mysqli_query($con, "SELECT SUM(harga * jumlah) AS omset FROM tb_penjualan WHERE id_grup='$idgrup' AND id_toko='$idtoko' AND tanggal='$tanggal' AND bulan='$bulan' AND tahun='$tahun'");
$row_sp = mysqli_fetch_array($sum_omset);
$omset = $row_sp['omset'];
$sum_laba = mysqli_query($con, "SELECT SUM((harga * jumlah) - (modal * jumlah)) AS laba FROM tb_penjualan WHERE id_grup='$idgrup' AND id_toko='$idtoko' AND tanggal='$tanggal' AND bulan='$bulan' AND tahun='$tahun'");
$row_sl = mysqli_fetch_array($sum_laba);
$laba = $row_sl['laba'];
$sum_pengeluaran = mysqli_query($con, "SELECT SUM(pengeluaran) AS pengeluaran FROM tb_pengeluaran WHERE id_grup='$idgrup' AND id_toko='$idtoko' AND tanggal='$tanggal' AND bulan='$bulan' AND tahun='$tahun'");
$row_spg = mysqli_fetch_array($sum_pengeluaran);
$pengeluaran = $row_spg['pengeluaran'];
if($pengeluaran > $laba){
  $textColorPg = 'text-danger';
}else{
  $textColorPg = 'text-warning';
}
if($omset > $pengeluaran){
  $textColorSO = ' text-bg-info';
}else{
  $textColorSO = ' text-bg-danger';
}
if($laba > $pengeluaran){
  $textColorSL = ' text-bg-primary';
}else{
  $textColorSL = ' text-bg-danger';
}
$omset_kotor = $omset - $pengeluaran;
if($omset > $pengeluaran){
  $textColorOk = ' text-primary';
}else{
  $textColorOk = ' text-danger';
}
$omset_bersih = ($omset - $pengeluaran) - ($laba);
$sisa_laba = $laba - $pengeluaran;
?>
  <table class="table table-dark my-3">
    <tbody>
      <tr>
        <td>Data Masuk</td>
        <td>:</td>
        <td><?=$res_penjualan.' baris';?></td>
      </tr>
      <tr>
        <td>Penjualan</td>
        <td>:</td>
        <td><?=number_format($omset,0,',','.');?></td>
      </tr>
      <tr>
        <td>Keuntungan</td>
        <td>:</td>
        <td class="text-info"><?=number_format($laba,0,',','.');?></td>
      </tr>
      <tr>
        <td>Pengeluaran</td>
        <td>:</td>
        <td class="<?=$textColorPg;?>"><?=number_format($pengeluaran,0,',','.');?><span style="width:25px" id="btn-adpe" class="float-end ms-3"><i class="fas fa-plus-square text-primary"></i></span><?php if($pengeluaran != null){ ?><span style="width:25px" id="btn-depe" class="float-end"><i class="fas fa-eye text-primary"></i></span><?php } ?></td>
      </tr>
      <tr>
        <td>Omset Kotor</td>
        <td>:</td>
        <td><span class="<?=$textColorOk;?>"><?=number_format($omset_kotor,0,',','.');?></span></td>
      </tr>
      <tr>
        <td>Omset Bersih</td>
        <td>:</td>
        <td><span class="fw-bold py-1 px-2 rounded<?=$textColorSO;?>"><?=number_format($omset_bersih,0,',','.');?></span></td>
      </tr>
      <tr>
        <td>Laba Bersih</td>
        <td>:</td>
        <td><span class="fw-bold py-1 px-2 rounded<?=$textColorSL;?>"><?=number_format($sisa_laba,0,',','.');?></span></td>
      </tr>
    </tbody>
  </table>
  <div class="box-depe">
    <table class="table mb-0">
      <thead>
        <tr>
          <th class="text-light">Pengeluaran</th>
          <th class="text-light">Keterangan</th>
          <th id="tutup" class="text-center"><span class="text-bg-light fw-normal py-1 px-2 rounded"><i class="fas fa-times"></i></span></th>
        </tr>
      </thead>
      <tbody>
<?php
$sel_pengeluaran = mysqli_query($con, "SELECT * FROM tb_pengeluaran WHERE id_grup='$idgrup' AND id_toko='$idtoko' AND tanggal='$tanggal' AND bulan='$bulan' AND tahun='$tahun' ORDER BY id_pengeluaran DESC");
$sum_pengeluaran = mysqli_query($con, "SELECT SUM(pengeluaran) AS pengeluaran FROM tb_pengeluaran WHERE id_grup='$idgrup' AND id_toko='$idtoko' AND tanggal='$tanggal' AND bulan='$bulan' AND tahun='$tahun'");
$row_spg = mysqli_fetch_array($sum_pengeluaran);
while($row_pgr = mysqli_fetch_array($sel_pengeluaran)){
?>
        <tr>
          <td valign="middle"><?=number_format($row_pgr['pengeluaran'],0,',','.');?></td>
          <td valign="middle"><?=$row_pgr['keterangan'];?></td>
          <td valign="middle" class="text-center" id="btn-hapus" data-id="<?=$row_pgr['id_pengeluaran'];?>" data-pengeluaran="<?=$row_pgr['pengeluaran'];?>" data-keterangan="<?=$row_pgr['keterangan'];?>"><i class="fas fa-trash text-danger"></i></td>
        </tr>
<?php } ?>
      </tbody>
      <tfoot>
        <tr>
          <td class="text-light fw-bold">Total</td>
          <td colspan="2" class="text-end text-light fw-bold"><?=number_format($row_spg['pengeluaran'],0,',','.');?></td>
        </tr>
      </tfoot>
    </table>
  </div>
  <div class="box-adpe">
    <form autocomplete="off" id="form-adpe">
      <h5 class="border-bottom pb-2 mb-3">Tambah Pengeluaran</h5>
      <div class="mb-3">
        <label for="pengeluaran" class="form-label">Pengeluaran</label>
        <input type="search" id="pengeluaran" class="form-control">
        <div class="err"></div>
      </div>
      <div class="mb-3">
        <label for="keterangan" class="form-label">Keterangan</label>
        <textarea id="keterangan" cols="30" rows="3" class="form-control"></textarea>
        <div class="err"></div>
      </div>
      <div class="text-end">
        <input type="hidden" id="tanggal" value="<?=$tanggal;?>">
        <input type="hidden" id="bulan" value="<?=$bulan;?>">
        <input type="hidden" id="tahun" value="<?=$tahun;?>">
        <button type="button" class="btn btn-secondary">Batal</button>
        <button type="submit" class="btn btn-primary">Tambah</button>
      </div>
    </form>
  </div>
<?php }else{
if(isset($_SESSION['grup']) && $_SESSION['grup'] == 0){
?>
  <div class="container my-5">
    <form autocomplete="off" id="grup" class="shadow rounded p-3">
      <h5 class="border-bottom text-center pb-2 mb-3">Buat Grup</h5>
      <div class="row">
        <label for="nama" class="form-label">Nama Grup</label>
          <div class="col-8">
            <input type="search" id="nama" class="form-control">
          </div>
          <div class="col-2">
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        <div class="err"></div>
      </div>
    </form>
  </div>
  <div class="text-center">
    <img src="<?=$base_url.'files/img/icon-512x512.png';?>" alt="Icon App Toko" class="w-50 my-5"/>
  </div>
<?php
}else if(isset($_SESSION['toko']) && $_SESSION['toko'] == 0){
?>
  <div class="container my-5">
    <form autocomplete="off" id="input-toko" class="shadow rounded p-3">
      <h5 class="border-bottom text-center pb-2 mb-3">Buat Toko</h5>
      <div class="row">
        <label for="nama" class="form-label">Nama Toko</label>
          <div class="col-8">
            <input type="search" id="nama" class="form-control">
          </div>
          <div class="col-2">
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        <div class="err"></div>
      </div>
    </form>
  </div>
  <div class="text-center">
    <img src="<?=$base_url.'files/img/icon-512x512.png';?>" alt="Icon App Toko" class="w-50 my-5"/>
  </div>
<?php
}else{
  if($dataModal){
?>
  <div class="my-5 text-center">
    <p class="text-muted">Belum ada penjualan hari ini!</p>
    <p><a href="#" id="btnInputPenjualan" class="badge text-bg-info text-decoration-none fw-normal py-2 px-3">Input Penjualan</a></p>
  </div>
<?php }else{ ?>
  <div class="my-5 text-center">
    <p class="text-danger">Belum Ada Data!</p>
    <p><a href="<?=$base_url.'?pg=input-modal';?>" class="badge text-bg-info text-decoration-none fw-normal py-2 px-3">Input Data</a></p>
  </div>
<?php } ?>
  <div class="text-center">
    <img src="<?=$base_url.'files/img/icon-512x512.png';?>" alt="Icon App Toko" class="w-50 my-5"/>
  </div>
<?php } } ?>
</div>
<?php if($dataModal){ ?>
<div class="container p-0">
  <form autocomplete="off" id="harian" class="form-fixbot">
    <input type="search" id="nama" placeholder="Nama/Merek">
    <input type="search" id="harga" placeholder="Harga Jual" readonly>
    <input type="search" id="jumlah" placeholder="Jumlah" readonly>
    <input type="hidden" id="modal">
    <input type="hidden" id="tanggal" value="<?=$tanggal;?>">
    <input type="hidden" id="bulan" value="<?=ucwords($bulan);?>">
    <input type="hidden" id="tahun" value="<?=$tahun;?>">
    <button type="submit"><i class="fa-solid fa-arrow-up-from-bracket"></i></button>
  </form>
  <div class="box-result"></div>
  <div class="mores"></div>
</div>
<?php }else{
if(!(isset($_GET['pg']))){
  $fotyear01 = 2024;
  $fotyear02 = date('Y');
  if($fotyear02 > $fotyear01){
    $fotyear02 = ' ~ '.$fotyear02;
  }else{
    $fotyear02 = '';
  }
?>
<div id="footer" class="fixed-bottom bg-info text-secondary text-center p-3">&copy;<?=$fotyear01.$fotyear02; ?> &#149; App Toko</div>
<?php } } ?>