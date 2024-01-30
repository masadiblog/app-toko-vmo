<?php
if(isset($_GET['pg'])){
  if($_GET['pg'] != 'login' && $_GET['pg'] != 'register'){
    $fotyear1 = 2024;
    $fotyear2 = date('Y');
    if($fotyear2 > $fotyear1){
      $fotyear2 = ' ~ '.$fotyear2;
    }else{
      $fotyear2 = '';
    }
?>
    <footer class="container-fluid">
      <div class="fixed-bottom bg-info text-muted text-center p-3">&copy;<?=$fotyear1.$fotyear2; ?> &#149; App Toko</div>
    </footer>
<?php } } ?>
    <div class="aniload"><div class="ani"></div></div><div id="setBtnReload"></div>
    <div id="menuSlide" class="menu-slide">
      <ul class="list-group" style="white-space:nowrap">
<?php if(isset($_SESSION['login_access']) && $namaToko != ''){ if(isset($_GET['pg'])){ ?>
        <li class="list-group-item"><a class="nav-link" href="<?=$base_url;?>"><i class="fas fa-home"></i> &nbsp; Home</a></li>
<?php } ?>
        <li class="list-group-item"><a class="nav-link" href="<?=$base_url.'?pg=data-penjualan&bulan='.strtolower($month_now).'&tahun='.$year_now;?>"><i class="fas fa-table-list"></i> &nbsp; Penjualan</a></li>
        <li class="list-group-item"><a class="nav-link" href="<?=$base_url.'?pg=omha';?>"><i class="fas fa-table"></i> &nbsp; Harian</a></li>
        <li class="list-group-item"><a class="nav-link" href="<?=$base_url.'?pg=input-produk';?>"><i class="fas fa-pen"></i> &nbsp; Produk</a></li>
        <li class="list-group-item"><a class="nav-link" href="<?=$base_url.'?pg=catatan';?>"><i class="fas fa-edit"></i> &nbsp; Catatan</a></li>
        <li class="list-group-item"><a class="nav-link" href="<?=$base_url.'?pg=data-admin';?>"><i class="fas fa-user-group"></i> &nbsp;Admin</a></li>
<?php if(isset($_SESSION['level']) && $_SESSION['level'] == 'level_pemilik'){ ?>
        <li class="list-group-item"><a class="nav-link" href="<?=$base_url.'?pg=data-grup-toko';?>"><i class="fas fa-users-rectangle"></i> &nbsp;Toko</a></li>
<?php } } ?>
<?php if(isset($_SESSION['login_access'])){ ?>
        <li id="logout" class="list-group-item"><i class="fas fa-sign-out"></i> &nbsp; Logout</li>
<?php if(isset($_SESSION['user'])){ ?>
        <li class="list-group-item"><span class="text-info" style="font-size:.8em"><i class="fas fa-circle"></i></span> &nbsp; <?=substr($_SESSION['user'],0,10);?></li>
<?php } } ?>
        <li id="btnRefresh" class="list-group-item"><i class="fas fa-refresh"></i> &nbsp; Refresh</li>
      </ul>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js" integrity="sha512-GWzVrcGlo0TxTRvz9ttioyYJ+Wwk9Ck0G81D+eO63BaqHaJ3YZX9wuqjwgfcV/MrB2PhaVX9DkYVhbFpStnqpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="<?=$base_url.'files/js/script.js?v='.filemtime('files/js/script.js');?>"></script>
    <script src="<?=$base_url.'files/js/alertbox.js?v='.filemtime('files/js/alertbox.js');?>"></script>
    <script src="<?=$base_url.'files/js/register.js?v='.filemtime('files/js/register.js');?>"></script>
    <script>
      document.addEventListener('DOMContentLoaded', function(){
        const setbtnreload = qs('#setBtnReload'),
        btnreload = document.createElement('div');
        btnreload.setAttribute('ontouchmove', 'btnReload(event)');
        btnreload.setAttribute('id', 'btnreload');
        btnreload.classList.add('btnreload');
        const btnreloadicon = document.createElement('i');
        btnreloadicon.classList.add('fas', 'fa-bars');
        btnreload.appendChild(btnreloadicon);
        setbtnreload.appendChild(btnreload);
        btnreload.onclick = () => {
          btnreload.classList.toggle('hide');
          const menuSlide = qs('#menuSlide'),
          menuList = qs('#menuSlide ul'),
          listItem = qsa('#menuSlide ul > li');
          menuList.style.right = `-${menuList.offsetWidth}px`;
          menuList.style.width = `${menuList.offsetWidth}px`;
          menuSlide.classList.toggle('active');
          for(let i = 0; i < listItem.length; i++){
            if(i != listItem.length-2 && i != listItem.length-1){
              listItem[i].onclick = () => {
                qs('.aniload').classList.add('show');
              }
            }
          }
          menuSlide.onclick = () => {
          btnreload.classList.toggle('hide');
            menuSlide.classList.toggle('active');
          }
          qs('#btnRefresh').onclick = () => {
            qs('.aniload').classList.add('show');
            window.location.reload();
          }
        }
        btnreload.style.left = `${localStorage.getItem('setX')}px`;
        btnreload.style.top = `${localStorage.getItem('setY')}px`;
      });
      function btnReload(event){
        const btnreload = qs('#btnreload'),
        x = event.touches[0].clientX,
        y = event.touches[0].clientY;
        btnreload.style.left = `${x}px`;
        btnreload.style.top = `${y}px`;
        localStorage.setItem('setX', x);
        localStorage.setItem('setY', y);
      }
    </script>
  </body>
</html>