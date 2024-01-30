<?php
if(isset($_GET['tanggal']) && isset($_GET['bulan']) && isset($_GET['tahun'])){
  $dataPenjualan = $_GET['tanggal'].' '.ucwords($_GET['bulan']).' '.$_GET['tahun'];
}else if(isset($_GET['bulan']) && isset($_GET['tahun'])){
  $dataPenjualan = ' Bulan '.ucwords($_GET['bulan']).' '.$_GET['tahun'];
}else if(isset($_GET['tahun'])){
  $dataPenjualan = ' Tahun '.$_GET['tahun'];
}else{
  $dataPenjualan = '';
}
?>
<div class="container p-1">
  <h5 class="text-center">Data Penjualan <?=$dataPenjualan;?></h5>
  <div class="mb-2 mx-auto ps-1 pe-2" style="max-width:557px">
    <form autocomplete="off" id="get-data">
      <div class="row">
        <div class="col-3">
          <select id="tanggal" class="form-control text-center p-1">
            <option selected value="">- - -</option>
<?php
if(isset($_GET['tanggal'])){
  $get_tanggal = $_GET['tanggal'];
}else{
  $get_tanggal = '';
}
for($tgl = 1; $tgl < 32; $tgl++){
  if($tgl < 10){
    $tgl = '0'.$tgl;
  }
  $tanggal = $tgl;
  if($tanggal == $get_tanggal){
    $tasel = 'selected ';
  }else{
    $tasel = $date_now;
  }
?>
            <option <?=$tasel;?>value="<?=$tanggal;?>"><?=$tanggal;?></option>
<?php } ?>
          </select>
        </div>
        <div class="col-4">
          <select id="bulan" class="form-control text-center p-1">
            <option selected value="">- - -</option>
<?php
if(isset($_GET['bulan'])){
  $get_bulan = $_GET['bulan'];
}else{
  $get_bulan = '';
}
$bln = ['januari', 'februari', 'maret', 'april', 'mei', 'juni', 'juli', 'agustus', 'september', 'oktober', 'november', 'desember'];
for($xb = 0; $xb < count($bln); $xb++){
  $bulan = $bln[$xb];
  if($bulan == $get_bulan){
    $busel = 'selected ';
  }else{
    $busel = '';
  }
?>
            <option <?=$busel;?>value="<?=$bulan;?>"><?=ucwords($bulan);?></option>
<?php } ?>
          </select>
        </div>
        <div class="col-3">
          <select id="tahun" class="form-control text-center p-1">
            <option selected value="">- - -</option>
<?php
if(isset($_GET['tahun'])){
  $get_tahun = $_GET['tahun'];
}else{
  $get_tahun = '';
}
$dis_tahun = mysqli_query($con, "SELECT DISTINCT(tahun) FROM tb_penjualan WHERE id_grup='$idgrup' AND id_toko='$idtoko' ORDER BY tahun DESC");
if(mysqli_num_rows($dis_tahun)){
  while($row_dt = mysqli_fetch_array($dis_tahun)){
    $dataTahun = $row_dt['tahun'];
    if($dataTahun == $get_tahun){
      $tasel = 'selected ';
    }else{
      $tasel = '';
    }
?>
            <option <?=$tasel;?>value="<?=$dataTahun;?>"><?=$dataTahun;?></option>
<?php } }else{ ?>
            <option selected="" value="<?=$tahun;?>"><?=$tahun;?></option>
<?php } ?>
          </select>
        </div>
        <div class="col-2">
          <button type="submit" class="btn text-bg-info py-1" style="width:37px;height:34px"><i class="fas fa-arrow-right"></i></button>
        </div>
      </div>
    </form>
  </div>
<?php
if(isset($_GET['tanggal']) && isset($_GET['bulan']) && isset($_GET['tahun'])){
  $tanggal = $_GET['tanggal'];
  $bulan = $_GET['bulan'];
  $tahun = $_GET['tahun'];
  $selData = mysqli_query($con, "SELECT * FROM tb_penjualan WHERE id_grup='$idgrup' AND id_toko='$idtoko' AND tanggal='$tanggal' AND bulan='$bulan' AND tahun='$tahun'");
  if(mysqli_num_rows($selData)){
?>
  <div class="tab-auto" style="max-height:74vh">
    <table class="table mb-0" style="white-space:wrap">
      <thead>
        <tr>
          <th>No</th>
          <th>Merek</th>
          <th>Harga</th>
          <th>Laba</th>
        </tr>
      </thead>
      <tbody>
<?php
    $no = 1;
    while($rowData = mysqli_fetch_array($selData)){
      $merek = $rowData['nama'];
      $harga = $rowData['harga'];
      $jumlah = $rowData['jumlah'];
      $laba = $rowData['laba'];
?>
        <tr>
          <td valign="middle"><?=$no;?></td>
          <td valign="middle"><?=$merek;?></td>
          <td valign="middle"><?=number_format($harga,0,',','.').'×'.$jumlah;?></td>
          <td valign="middle"><?=number_format($laba,0,',','.');?></td>
        </tr>
<?php $no++; } ?>
      </tbody>
<?php
$selData2 = mysqli_query($con, "SELECT SUM(harga * jumlah) AS omset, SUM(laba) AS laba FROM tb_penjualan WHERE id_grup='$idgrup' AND id_toko='$idtoko' AND tanggal='$tanggal' AND bulan='$bulan' AND tahun='$tahun'");
$rowData2 = mysqli_fetch_array($selData2);
$selData3 = mysqli_query($con, "SELECT SUM(pengeluaran) AS pengeluaran FROM tb_pengeluaran WHERE id_grup='$idgrup' AND id_toko='$idtoko' AND tanggal='$tanggal' AND bulan='$bulan' AND tahun='$tahun'");
$rowData3 = mysqli_fetch_array($selData3);
$omset = $rowData2['omset'];
$laba = $rowData2['laba'];
$pengeluaran = $rowData3['pengeluaran'];
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
$omset_bersih = ($omset - $pengeluaran) - ($laba);
$laba_bersih = $laba - $pengeluaran;
?>
      <tfooter>
        <tr>
          <td colspan="2" class="text-bg-dark">Data Masuk</td>
          <td class="text-bg-dark">:</td>
          <td class="text-bg-dark"><?=mysqli_num_rows($selData);?> baris</td>
        </tr>
        <tr>
          <td colspan="2" class="text-bg-dark">Penjualan</td>
          <td class="text-bg-dark">:</td>
          <td class="text-bg-dark"><?=number_format($omset,0,',','.');?></td>
        </tr>
        <tr>
          <td colspan="2" class="text-bg-dark">Keuntungan</td>
          <td class="text-bg-dark">:</td>
          <td class="text-bg-dark"><?=number_format($laba,0,',','.');?></td>
        </tr>
        <tr>
          <td colspan="2" class="text-bg-dark">Pengeluaran</td>
          <td class="text-bg-dark">:</td>
          <td class="text-bg-dark"><?=number_format($pengeluaran,0,',','.');?></td>
        </tr>
        <tr>
          <td colspan="2" class="text-bg-dark">Omset Kotor</td>
          <td class="text-bg-dark">:</td>
          <td class="text-bg-dark"><span class="fw-bold text-info"><?=number_format($omset_kotor,0,',','.');?></span></td>
        </tr>
        <tr>
          <td colspan="2" class="text-bg-dark">Omset Bersih</td>
          <td class="text-bg-dark">:</td>
          <td class="text-bg-dark"><span class="fw-bold py-1 px-2 rounded<?=$textColorSO;?>"><?=number_format($omset_bersih,0,',','.');?></span></td>
        </tr>
        <tr>
          <td colspan="2" class="text-bg-dark">Laba Bersih</td>
          <td class="text-bg-dark">:</td>
          <td class="text-bg-dark"><span class="fw-bold py-1 px-2 rounded<?=$textColorSL;?>"><?=number_format($laba_bersih,0,',','.');?></span></td>
        </tr>
<?php
$selData4 = mysqli_query($con, "SELECT * FROM tb_pengeluaran WHERE id_grup='$idgrup' AND id_toko='$idtoko' AND tanggal='$tanggal' AND bulan='$bulan' AND tahun='$tahun'");
if(mysqli_num_rows($selData4)){
?>
        <tr>
          <td colspan="4" class="text-bg-success text-center">Detail Pengeluaran</td>
        </tr>
<?php
while($rowData4 = mysqli_fetch_array($selData4)){
?>
        <tr>
          <td valign="middle" colspan="3"><?=$rowData4['keterangan'];?></td>
          <td valign="middle" class="text-end"><?=number_format($rowData4['pengeluaran'],0,',','.');?></td>
        </tr>
<?php } ?>
        <tr>
          <td colspan="2" class="text-bg-dark">Total Pengeluaran</td>
          <td colspan="2" class="text-bg-dark text-end"><?=number_format($pengeluaran,0,',','.');?></td>
        </tr>
<?php } ?>
      </tfooter>
    </table>
  </div>
<?php }
}else if(isset($_GET['bulan']) && isset($_GET['tahun'])){
  $bulan = ucwords($_GET['bulan']);
  $tahun = $_GET['tahun'];
  $selData = mysqli_query($con, "SELECT DISTINCT tanggal FROM tb_penjualan WHERE id_grup='$idgrup' AND id_toko='$idtoko' AND bulan='$bulan' AND tahun='$tahun'");
  if(mysqli_num_rows($selData)){
?>
  <div class="tab-auto" style="max-height:41vh">
    <table class="table mb-0" style="white-space:nowrap">
      <thead style="white-space:nowrap">
        <tr>
          <th>TGL</th>
          <th>Penjualan</th>
          <th>Keuntungan</th>
          <th>Pengeluaran</th>
          <th>Omset Bersih</th>
          <th>Laba Bersih</th>
          <th class="psr"><i class="fas fa-angle-down"></i></th>
        </tr>
      </thead>
      <tbody>
<?php
    while($rowData = mysqli_fetch_array($selData)){
      $tanggal = $rowData['tanggal'];
      $selData2 = mysqli_query($con, "SELECT SUM(harga * jumlah) AS omset, SUM(laba) AS laba FROM tb_penjualan WHERE id_grup='$idgrup' AND id_toko='$idtoko' AND tanggal='$tanggal' AND bulan='$bulan' AND tahun='$tahun'");
      $rowData2 = mysqli_fetch_array($selData2);
      $selData3 = mysqli_query($con, "SELECT SUM(pengeluaran) AS keluar FROM tb_pengeluaran WHERE id_grup='$idgrup' AND id_toko='$idtoko' AND tanggal='$tanggal' AND bulan='$bulan' AND tahun='$tahun'");
      $rowData3 = mysqli_fetch_array($selData3);
      $penjualan = $rowData2['omset'];
      $keuntungan = $rowData2['laba'];
      $pengeluaran = $rowData3['keluar'];
      $omset_bersih = ($penjualan - $pengeluaran) - ($keuntungan);
      $laba_bersih = $keuntungan - $pengeluaran;
?>
        <tr>
          <td valign="middle"><?=$tanggal;?></td>
          <td valign="middle"><?=number_format($penjualan,0,',','.');?></td>
          <td valign="middle"><?=number_format($keuntungan,0,',','.');?></td>
          <td valign="middle"><?=number_format($pengeluaran,0,',','.');?></td>
          <td valign="middle"><?=number_format($omset_bersih,0,',','.');?></td>
          <td valign="middle"><?=number_format($laba_bersih,0,',','.');?></td>
          <td valign="middle" class="psr"><a href="<?=$base_url.'?pg=data-penjualan&tanggal='.$tanggal.'&bulan='.strtolower($bulan).'&tahun='.$tahun;?>"><i class="fas fa-info-circle"></i></a></td>
        </tr>
<?php } ?>
      </tbody>
    </table>
  </div>
<?php }
}else if(isset($_GET['tahun'])){
  $tahun = $_GET['tahun'];
  $selData = mysqli_query($con, "SELECT DISTINCT(bulan) FROM tb_penjualan WHERE id_grup='$idgrup' AND id_toko='$idtoko' AND tahun='$tahun'");
  if(mysqli_num_rows($selData)){
?>
  <div class="tab-auto" style="max-height:74vh">
    <table class="table mb-0" style="white-space:nowrap">
      <thead>
        <tr>
          <th>Bulan</th>
          <th>Penjualan</th>
          <th>Keuntungan</th>
          <th>Pengeluaran</th>
          <th>Laba Bersih</th>
          <th class="text-center psr"><i class="fas fa-angle-down"></i></th>
        </tr>
      </thead>
      <tbody>
<?php
    while($rowData = mysqli_fetch_array($selData)){
      $bulan = $rowData['bulan'];
      $selData2 = mysqli_query($con, "SELECT SUM(harga * jumlah) AS omset, SUM(laba) AS laba FROM tb_penjualan WHERE id_grup='$idgrup' AND id_toko='$idtoko' AND bulan='$bulan' AND tahun='$tahun'");
      $rowData2 = mysqli_fetch_array($selData2);
      $selData3 = mysqli_query($con, "SELECT SUM(pengeluaran) AS keluar FROM tb_pengeluaran WHERE id_grup='$idgrup' AND id_toko='$idtoko' AND bulan='$bulan' AND tahun='$tahun'");
      $rowData3 = mysqli_fetch_array($selData3);
      $omset = $rowData2['omset'];
      $laba = $rowData2['laba'];
      $keluar = $rowData3['keluar'];
      $bersih = $laba - $keluar;
?>
        <tr>
          <td valign="middle"><?=$bulan;?></td>
          <td valign="middle"><?=number_format($omset,0,',','.');?></td>
          <td valign="middle"><?=number_format($laba,0,',','.');?></td>
          <td valign="middle"><?=number_format($keluar,0,',','.');?></td>
          <td valign="middle"><?=number_format($bersih,0,',','.');?></td>
          <td valign="middle" class="psr"><a href="<?=$base_url.'?pg=data-penjualan&bulan='.strtolower($bulan).'&tahun='.$tahun;?>"><i class="fas fa-info-circle"></i></a></td>
        </tr>
<?php } ?>
      </tbody>
    </table>
  </div>
<?php }
}else{
?>
  <div class="tab-auto" style="max-height:74vh">
    <table class="table mb-0" style="white-space:nowrap">
      <thead>
        <tr>
          <th>Tahun</th>
          <th>Penjualan</th>
          <th>Keuntungan</th>
          <th>Pengeluaran</th>
          <th>Laba Bersih</th>
          <th><i class="fas fa-angle-down"></i></th>
        </tr>
      </thead>
      <tbody>
<?php
  $selData = mysqli_query($con, "SELECT DISTINCT(tahun) FROM tb_penjualan WHERE id_grup='$idgrup' AND id_toko='$idtoko'");
  while($rowData = mysqli_fetch_array($selData)){
    $tahun = $rowData['tahun'];
    $selData2 = mysqli_query($con, "SELECT SUM(harga * jumlah) AS omset, SUM((harga * jumlah) - (modal * jumlah)) AS laba FROM tb_penjualan WHERE id_grup='$idgrup' AND id_toko='$idtoko' AND tahun='$tahun'");
    $rowData2 = mysqli_fetch_array($selData2);
    $selData3 = mysqli_query($con, "SELECT SUM(pengeluaran) AS keluar FROM tb_pengeluaran WHERE id_grup='$idgrup' AND id_toko='$idtoko' AND tahun='$tahun'");
    $rowData3 = mysqli_fetch_array($selData3);
    $omset = $rowData2['omset'];
    $laba = $rowData2['laba'];
    $keluar = $rowData3['keluar'];
    $bersih = $laba - $keluar;
?>
        <tr>
          <td valign="middle"><?=$tahun;?></td>
          <td valign="middle"><?=number_format($omset,0,',','.');?></td>
          <td valign="middle"><?=number_format($laba,0,',','.');?></td>
          <td valign="middle"><?=number_format($keluar,0,',','.');?></td>
          <td valign="middle"><?=number_format($bersih,0,',','.');?></td>
          <td valign="middle" class="psr"><a href="<?=$base_url.'?pg=data-penjualan&tahun='.$tahun;?>"><i class="fas fa-info-circle"></i></a></td>
        </tr>
<?php } ?>
      </tbody>
    </table>
  </div>
<?php } ?>
<?php if(!(isset($_GET['tanggal'])) && isset($_GET['bulan']) && isset($_GET['tahun'])){
$selData5 = mysqli_query($con, "SELECT SUM(harga * jumlah) AS penjualan, SUM(laba) AS keuntungan FROM tb_penjualan WHERE id_grup='$idgrup' AND id_toko='$idtoko' AND bulan='$bulan' AND tahun='$tahun'");
$selData6 = mysqli_query($con, "SELECT SUM(pengeluaran) AS pengeluaran FROM tb_pengeluaran WHERE id_grup='$idgrup' AND id_toko='$idtoko' AND bulan='$bulan' AND tahun='$tahun'");
$rowData5 = mysqli_fetch_array($selData5);
$rowData6 = mysqli_fetch_array($selData6);
$penjualan = $rowData5['penjualan'];
$keuntungan = $rowData5['keuntungan'];
$pengeluaran = $rowData6['pengeluaran'];
if($pengeluaran < $penjualan){
  $omset_bersih = ($penjualan - $keuntungan) - ($pengeluaran);
}else{
  $omset_bersih = 0;
}
$laba_bersih = $keuntungan - $pengeluaran;
?>
  <table class="table table-dark mb-4">
    <tbody>
      <tr>
        <td colspan="3" class="text-bg-success text-center fw-bold">Total Data Penjualan /<?=mysqli_num_rows($selData);?> Hari</td>
      </tr>
      <tr>
        <td>Penjualan</td>
        <td>:</td>
        <td class="text-end"><?=number_format($penjualan,0,',','.');?></td>
      </tr>
      <tr>
        <td>Keuntungan</td>
        <td>:</td>
        <td class="text-end"><?=number_format($keuntungan,0,',','.');?></td>
      </tr>
      <tr>
        <td>Pengeluaran</td>
        <td>:</td>
        <td class="text-end"><?=number_format($pengeluaran,0,',','.');?></td>
      </tr>
      <tr>
        <td>Omset Bersih</td>
        <td>:</td>
        <td class="text-end"><?=number_format($omset_bersih,0,',','.');?></td>
      </tr>
      <tr>
        <td>Laba Bersih</td>
        <td>:</td>
        <td class="text-end"><?=number_format($laba_bersih,0,',','.');?></td>
      </tr>
    </tbody>
  </table>
<?php } ?>
</div>