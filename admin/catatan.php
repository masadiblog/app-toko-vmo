<?php
$selData1 = mysqli_query($con, "SELECT * FROM tb_catatan WHERE id_grup='$idgrup' AND id_toko='$idtoko' ORDER BY id_catatan DESC LIMIT 15");
$resData1 = mysqli_num_rows($selData1);
?>
<div class="container">
  <div class="input-group mb-2">
    <input type="search" id="cacat" class="form-control" placeholder="Cari Catatan...">
    <span id="adcat" class="input-group-text">
      <a href="#" class="text-decoration-none text-primary" data-bs-toggle="modal" data-bs-target="#catatanModal" style="font-size:.9em;width:50px">
        <div class="d-inline-block" style="width:10px"><i class="fas fa-plus-square"></i></div>
        Baru
      </a>
    </span>
  </div>
  <div class="tab-auto border border-info" style="max-height:77vh">
    <table class="table mb-0">
      <thead>
        <tr>
          <th class="text-center" style="width:30px">#</th>
          <th>Catatan</th>
          <th style="width:30px" class="text-center psr"><i class="fas fa-angle-down"></i></th>
        </tr>
      </thead>
      <tbody id="redacat">
<?php if($resData1){ $no = 1; while($row1 = mysqli_fetch_array($selData1)){ ?>
        <tr>
          <td valign="middle" class="text-bg-light text-center"><?=$no;?></td>
          <td valign="middle" class="text-bg-light"><div><?=$row1['judul'];?></div><div><?='<i class="text-muted" style="font-size:.8em">'.$row1['tanggal'].' '.$row1['bulan'].' '.$row1['tahun'].'</i>';?> &nbsp; <a style="width:20px;font-size:.8em" valign="middle" class="text-bg-light text-center" id="btnEditCatatan" data-target="<?=$row1['id_catatan'];?>" data-judul="<?=$row1['judul'];?>" data-catatan="<?=$row1['catatan'];?>" data-bs-toggle="modal" data-bs-target="#catatanModal"><i class="fas fa-edit text-success"></i></a> &nbsp; <a style="width:20px;font-size:.8em" valign="middle" class="text-bg-light text-center" id="btnHapusCatatan" data-target="<?=$row1['id_catatan'];?>" data-judul="<?=$row1['judul'];?>"><i class="fas fa-trash text-danger"></i></a></div></td>
          <td style="width:30px" valign="middle" class="text-bg-light text-center psr" id="btnDetailCatatan" data-target="<?=$row1['id_catatan'];?>" data-judul="<?=$row1['judul'];?>" data-catatan="<?=$row1['catatan'];?>" data-tanggal="<?=$row1['tanggal'].' '.$row1['bulan'].' '.$row1['tahun'];?>" data-bs-toggle="modal" data-bs-target="#detailCatatanModal"><i class="fas fa-eye text-info"></i></td>
        </tr>
<?php $no++; } }else{ ?>
        <td colspan="4" class="bg-light border-bottom-0 py-5 text-center text-muted">Belum ada catatan!</td>
<?php } ?>
      </tbody>
    </table>
  </div>
</div>
<!-- modal add-edit -->
<div class="modal fade" id="catatanModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="catatanModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <form autocomplete="off" id="forcat" data-target="false">
            <h5 class="border-bottom pb-2"></h5>
            <div class="mb-3">
              <label for="judul" class="form-label">Judul</label>
              <input type="search" id="judul" class="form-control" placeholder="Masukkan Judul...">
              <div class="err"></div>
            </div>
            <div class="mb-3">
              <label for="catatan" class="form-label">Catatan</label>
              <textarea rows="6" id="catatan" class="form-control" placeholder="Tulis catatan..."></textarea>
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
<!-- modal detail -->
<div class="modal fade" id="detailCatatanModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <div>
            <h5 id="ticat" class="border-bottom pb-2"></h5>
            <div id="tacat" class="text-end"></div>
            <div id="tecat" class="mt-2 mb-3" style="max-height:72vh;overflow:scroll"></div>
          </div>
          <div class="border-top pt-3 text-end">
            <button type="button" id="bucat" class="btn btn-secondary" data-bs-dismiss="modal"></button>
          </div>
        </div>
      </div>
    </div>
  </div>