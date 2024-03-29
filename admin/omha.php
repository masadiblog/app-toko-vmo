<?php
function listBulan($bulan){
  switch($bulan){
    case 'Januari': $bulan = '01'; break;
    case 'Februari': $bulan = '02'; break;
    case 'Maret': $bulan = '03'; break;
    case 'April': $bulan = '04'; break;
    case 'Mei': $bulan = '05'; break;
    case 'Juni': $bulan = '06'; break;
    case 'Juli': $bulan = '07'; break;
    case 'Agustus': $bulan = '08'; break;
    case 'September': $bulan = '09'; break;
    case 'Oktober': $bulan = '10'; break;
    case 'November': $bulan = '11'; break;
    case 'Desember': $bulan = '12'; break;
  }
  return $bulan;
}
if(isset($_GET['bulan']) && $_GET['bulan'] != ''){
  $getBulan = ucwords($_GET['bulan']);
}else{
  $getBulan = $month_now;
}
if(isset($_GET['tahun']) && $_GET['tahun'] != ''){
  $getTahun = $_GET['tahun'];
}else{
  $getTahun = $year_now;
}
$dataOmset = mysqli_query($con, "SELECT * FROM tb_omha WHERE id_grup='$idgrup' AND id_toko='$idtoko' AND bulan='$getBulan' AND tahun='$getTahun' ORDER BY tanggal ASC");
$sumOmset = mysqli_query($con, "SELECT SUM(omset) AS omset FROM tb_omha WHERE id_grup='$idgrup' AND id_toko='$idtoko' AND bulan='$getBulan' AND tahun='$getTahun'");
$rowSumOmset = mysqli_fetch_array($sumOmset);
$sumKeluar = mysqli_query($con, "SELECT SUM(jumlah) AS jumlah FROM tb_keluar WHERE id_grup='$idgrup' AND id_toko='$idtoko' AND bulan='$getBulan' AND tahun='$getTahun' ORDER BY tanggal ASC");
$rowSumKeluar = mysqli_fetch_array($sumKeluar);
$sumMasuk = mysqli_query($con, "SELECT SUM(jumlah) AS jumlah FROM tb_masuk WHERE id_grup='$idgrup' AND id_toko='$idtoko' AND bulan='$getBulan' AND tahun='$getTahun' ORDER BY tanggal ASC");
$rowSumMasuk = mysqli_fetch_array($sumMasuk);
$totalOmset = $rowSumOmset['omset'];
$totalKeluar = $rowSumKeluar['jumlah'];
$sisaOmset = $totalOmset - $totalKeluar;
$totalMasuk = $rowSumMasuk['jumlah'];
$omsetBersih = ($totalOmset - $totalKeluar) + ($totalMasuk);
?>
<div class="container px-1">
  <div class="d-flex justify-content-between align-items-center text-bg-dark py-1 px-2 mb-2 rounded" style="font-size:.9em">
    <h1 class="m-0" style="font-size:1em">Harian</h1>
    <div class="text-center">
      <a href="#" id="btnOmset" data-bs-toggle="modal" data-bs-target="#omsetModal" class="text-decoration-none badge bg-light text-primary fw-normal"><div style="width:12px" class="d-inline-block"><i class="fas fa-square-plus"></i></div> Omset</a>
      <a href="#" id="btnKeluar" data-bs-toggle="modal" data-bs-target="#kemasModal" class="text-decoration-none badge bg-light text-primary fw-normal"><div style="width:12px" class="d-inline-block ms-1"><i class="fas fa-square-plus"></i></div> Keluar</a>
      <a href="#" id="btnMasuk" data-bs-toggle="modal" data-bs-target="#kemasModal" class="text-decoration-none badge bg-light text-primary fw-normal"><div style="width:12px" class="d-inline-block ms-1"><i class="fas fa-square-plus"></i></div> Masuk</a>
      <a href="#" id="btnTanggal" data-ls-bulan="januari,februari,maret,april,mei,juni,juli,agustus,september,oktober,november,desember" data-ls-tahun="<?=($year_now).','.($year_now-1).','.($year_now-2).','.($year_now-3).','.($year_now-4);?>" class="text-decoration-none badge bg-light text-primary fw-normal"><div style="width:14px" class="d-inline-block ms-1"><i class="fas fa-circle-chevron-right"></i></div> Sortir</a>
    </div>
  </div>
<?php if(mysqli_num_rows($dataOmset)){ ?>
  <div class="px-3 text-center" style="font-size:.85em;margin-bottom:-2px;position:relative;z-index:99">
    <div class="d-inline-block px-2 rounded-top-3 text-light" style="background-color:#06abcc;font-size:.9em">Data Omset Bulan <?=$getBulan.' '.$getTahun;?></div>
  </div>
  <div class="tab-auto" style="max-height:39vh;margin-bottom:.25rem;font-size:.95em">
    <table class="table mb-0">
      <thead>
        <tr>
          <th class="text-center" style="width:50px">TGL</th>
          <th>Omset</th>
          <th colspan="2" class="text-center"><i class="fas fa-angle-down"></i></th>
        </tr>
      </thead>
      <tbody>
<?php
while($rowOmset = mysqli_fetch_array($dataOmset)){
  $bulan = listBulan($rowOmset['bulan']);
  $dataTanggal = $rowOmset['tahun'].'-'.$bulan.'-'.$rowOmset['tanggal'];
?>
        <tr>
          <td class="text-center"><?=$rowOmset['tanggal'];?></td>
          <td><?=number_format($rowOmset['omset'],0,',','.');?></td>
          <td id="btn_edoms" data-id="<?=$rowOmset['id_omha'];?>" data-omset="<?=number_format($rowOmset['omset'],0,',','.');?>" data-tanggal="<?=$dataTanggal;?>" data-bs-toggle="modal" data-bs-target="#omsetModal" style="width:30px" class="text-center"><i class="fas fa-edit text-success"></i></td>
          <td id="btn_haoms" data-id="<?=$rowOmset['id_omha'];?>" style="width:30px" class="text-center"><i class="fas fa-trash text-danger"></i></td>
        </tr>
<?php } ?>
      </tbody>
    </table>
    <div style="position:sticky;bottom:0;font-size:.9em" class="text-bg-dark text-center py-1">
<?php
if($totalKeluar != '' || $totalMasuk != ''){
  if($totalKeluar != ''){
?>
      <div class="d-flex justify-content-center align-items-center" style="margin:.25rem 0"><?='<span class="text-bg-secondary rounded px-2">'.number_format($totalOmset,0,',','.').'</span>&nbsp;<span class="badge text-bg-danger rounded">-</span>&nbsp;<span class="text-bg-secondary rounded px-2">'.number_format($totalKeluar,0,',','.').'</span>';?></div>
<?php } if($totalMasuk != ''){ ?>
      <div class="d-flex justify-content-center align-items-center" style="margin:.25rem 0"><?='<span class="text-bg-secondary rounded px-2">'.number_format($sisaOmset,0,',','.').'</span>&nbsp;<span class="badge text-bg-success rounded">+</span>&nbsp;<span class="text-bg-secondary rounded px-2">'.number_format($totalMasuk,0,',','.').'</span>';?></div>
<?php } } ?>
      <div class="d-flex justify-content-between align-items-center px-3" style="margin:.25rem 0">
        <div>Omset <span class="badge text-bg-light rounded-circle"><?=mysqli_num_rows($dataOmset);?></span> Hari</div>
        <span class="text-bg-primary rounded px-2 fw-bold"><?=number_format($omsetBersih,0,',','.');?></span>
      </div>
    </div>
  </div>
<?php
}
$dataKeluar = mysqli_query($con, "SELECT * FROM tb_keluar WHERE id_grup='$idgrup' AND id_toko='$idtoko' AND bulan='$getBulan' AND tahun='$getTahun' ORDER BY tanggal ASC");
if(mysqli_num_rows($dataKeluar)){
?>
  <div class="tab-auto" style="max-height:18.5vh;margin-bottom:.25rem;font-size:.9em">
    <table class="table mb-0">
      <thead>
        <tr>
          <th class="text-center" style="width:50px">TGL</th>
          <th>Nama</th>
          <th>Keluar</th>
          <th colspan="3" class="text-center"><i class="fas fa-angle-down"></i></th>
        </tr>
      </thead>
      <tbody>
<?php while($rowKeluar = mysqli_fetch_array($dataKeluar)){ ?>
        <tr>
          <td valign="middle" class="text-center"><?=$rowKeluar['tanggal'];?></td>
          <td valign="middle" style="white-space:wrap"><?=$rowKeluar['nama'];?></td>
          <td valign="middle"><?=number_format($rowKeluar['jumlah'],0,',','.');?></td>
          <td valign="middle" id="btn_detail_kemas" data-id="<?=$rowKeluar['id_keluar'];?>" data-push="detail-keluar" style="width:30px" class="text-center"><i class="fas fa-eye text-primary"></i></td>
          <td valign="middle" id="btn_edit_kemas" data-id="<?=$rowKeluar['id_keluar'];?>" data-push="edit-keluar" data-bs-toggle="modal" data-bs-target="#kemasModal" style="width:30px" class="text-center"><i class="fas fa-edit text-success"></i></td>
          <td valign="middle" id="btn_hapus_kemas" data-id="<?=$rowKeluar['id_keluar'];?>" data-push="hapus-keluar" style="width:30px" class="text-center"><i class="fas fa-trash text-danger"></i></td>
        </tr>
<?php } ?>
      </tbody>
    </table>
    <div style="position:sticky;bottom:0;font-size:.9em" class="text-bg-dark text-center py-1 px-3">
      <div class="d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center"><span class="badge text-bg-light rounded-circle"><?=mysqli_num_rows($dataKeluar);?></span>&nbsp;Data Keluar</div>
        <span class="text-bg-danger rounded px-2 fw-bold"><?=number_format($totalKeluar,0,',','.');?></span>
      </div>
    </div>
  </div>
<?php
}
$dataMasuk = mysqli_query($con, "SELECT * FROM tb_masuk WHERE id_grup='$idgrup' AND id_toko='$idtoko' AND bulan='$getBulan' AND tahun='$getTahun' ORDER BY tanggal ASC");
if(mysqli_num_rows($dataMasuk)){
?>
  <div class="tab-auto" style="max-height:18.5vh;font-size:.9em">
    <table class="table mb-0">
      <thead>
        <tr>
          <th class="text-center" style="width:50px">TGL</th>
          <th>Nama</th>
          <th>Masuk</th>
          <th colspan="3" class="text-center"><i class="fas fa-angle-down"></i></th>
        </tr>
      </thead>
      <tbody>
<?php while($rowMasuk = mysqli_fetch_array($dataMasuk)){ ?>
        <tr>
          <td valign="middle" class="text-center"><?=$rowMasuk['tanggal'];?></td>
          <td valign="middle" style="white-space:wrap"><?=$rowMasuk['nama'];?></td>
          <td valign="middle"><?=number_format($rowMasuk['jumlah'],0,',','.');?></td>
          <td valign="middle" id="btn_detail_kemas" data-id="<?=$rowMasuk['id_masuk'];?>" data-push="detail-masuk" style="width:30px" class="text-center"><i class="fas fa-eye text-primary"></i></td>
          <td valign="middle" id="btn_edit_kemas" data-id="<?=$rowMasuk['id_masuk'];?>" data-push="edit-masuk" data-bs-toggle="modal" data-bs-target="#kemasModal" style="width:30px" class="text-center"><i class="fas fa-edit text-success"></i></td>
          <td valign="middle" id="btn_hapus_kemas" data-id="<?=$rowMasuk['id_masuk'];?>" data-push="hapus-masuk" style="width:30px" class="text-center"><i class="fas fa-trash text-danger"></i></td>
        </tr>
<?php } ?>
      </tbody>
    </table>
    <div style="position:sticky;bottom:0;font-size.9em" class="text-bg-dark text-center py-1 px-3">
      <div class="d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center"><span class="badge text-bg-light rounded-circle"><?=mysqli_num_rows($dataMasuk);?></span>&nbsp;Data Masuk</div>
        <span class="text-bg-success rounded px-2 fw-bold"><?=number_format($totalMasuk,0,',','.');?></span>
      </div>
    </div>
  </div>
<?php } ?>
</div>
<?php
$omsetHariIni = mysqli_query($con, "SELECT tanggal, bulan, tahun, SUM(harga * jumlah) AS omset, SUM((harga * jumlah) - (modal * jumlah)) AS laba FROM tb_penjualan WHERE tanggal='$date_now' AND bulan='$month_now' AND tahun='$year_now' AND id_grup='$idgrup' AND id_toko='$idtoko'");
$pengeluaranHariIni = mysqli_query($con, "SELECT SUM(pengeluaran) AS pengeluaran FROM tb_pengeluaran WHERE tanggal='$date_now' AND bulan='$month_now' AND tahun='$year_now' AND id_grup='$idgrup' AND id_toko='$idtoko'");
if(mysqli_num_rows($omsetHariIni)){
  $row_ohi = mysqli_fetch_array($omsetHariIni);
  $row_phi = mysqli_fetch_array($pengeluaranHariIni);
  $omset = ($row_ohi['omset'] - $row_ohi['laba']) - $row_phi['pengeluaran'];
  $valOmset = number_format($omset,0,',','.');
  $tanggal = $row_ohi['tanggal'];
  $bulan = listBulan($row_ohi['bulan']);
  $tahun = $row_ohi['tahun'];
  $valTanggal = $tahun.'-'.$bulan.'-'.$tanggal;
}else{
  $valOmset = $valTanggal = '';
}
?>
<div class="modal fade" id="omsetModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <form autocomplete="off" id="omsetForm" data-target="" data-push="">
            <h5 class="border-bottom pb-2">Input Omset</h5>
            <div class="mb-3">
              <label for="omset" class="form-label">Omset</label>
              <input type="search" id="omset" class="form-control" value="<?=$valOmset;?>">
              <div class="err"></div>
            </div>
            <div class="mb-3">
              <label for="tanggal" class="form-label">Tanggal</label>
              <input type="date" id="tanggal" class="form-control" value="<?=$valTanggal;?>">
              <div class="err"></div>
            </div>
            <div class="text-end">
              <button type="button" id="batal" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
              <button type="submit" class="btn text-bg-info">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  
<div class="modal fade" id="kemasModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <form autocomplete="off" id="kemasForm" data-target="" data-push="">
            <h5 class="border-bottom pb-2">Input Keluar</h5>
            <div class="mb-3">
              <label for="nama" class="form-label">Nama</label>
              <input type="search" id="nama" class="form-control">
              <div class="err"></div>
            </div>
            <div class="mb-3">
              <label for="jumlah" class="form-label">Jumlah</label>
              <input type="search" id="jumlah" class="form-control">
              <div class="err"></div>
            </div>
            <div class="mb-3">
              <label for="keterangan" class="form-label">Keterangan</label>
              <textarea id="keterangan" rows="2" class="form-control"></textarea>
              <div class="err"></div>
            </div>
            <div class="mb-3">
              <label for="tanggal" class="form-label">Tanggal</label>
              <input type="date" id="tanggal" class="form-control">
              <div class="err"></div>
            </div>
            <div class="text-end">
              <button type="button" id="batal" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
              <button type="submit" class="btn text-bg-info">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>