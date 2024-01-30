function qs(x){
  return document.querySelector(x);
}
function qsa(x){
  return document.querySelectorAll(x);
}

document.addEventListener('DOMContentLoaded', function(){
  
if(qs('.aniload') != null){
  qs('.aniload').classList.add('down');
}

function ani_show(){
  qs('.aniload').classList.add('show');
}

function ani_hide(){
  qs('.aniload').classList.remove('show');
}

function modal_hide(x){
  bootstrap.Modal.getOrCreateInstance(x).hide();
}

if(qs('#btn-back') != null){
  qs('#btn-back').onclick = () => {
    window.history.back();
    ani_show();
  }
}

if(qs('#app-title') != null){
  qs('#app-title').onclick = () => {
    ani_show();
  }
}

if(qs('#pilihTanggal') != null){
  const pilihTanggal = qs('#pilihTanggal button[type=button]'),
  tanggal = qs('#pilihTanggal #selTanggal'),
  bulan = qs('#pilihTanggal #selBulan'),
  tahun = qs('#pilihTanggal #selTahun');
  pilihTanggal.onclick = (e) => {
    e.preventDefault();
    if(tanggal.value != '' && bulan.value != '' && tahun.value != ''){
      ani_show();
      window.location.href = '?tanggal='+tanggal.value+'-'+bulan.value+'-'+tahun.value;
    }
  }
}

if(qs('#login') != null){
  const form = qs('#login'),
  username = qs('#login #username'),
  password = qs('#login #password'),
  shp = qs('#login #shp'),
  eye = shp.innerHTML,
  err = qsa('#login .err'),
  remember = qs('#login #remember');
  shp.onclick = () => {
    if(password.type == 'password'){
      shp.innerHTML = '<i class="fas fa-eye-slash"></i>';
      password.type = 'text';
    }else{
      shp.innerHTML = eye;
      password.type = 'password';
    }
  }
  form.onsubmit = (e) => {
    e.preventDefault();
    for(let i = 0; i < err.length; i++){
      err[i].innerText = '';
    }
    if(username.value == ''){
      username.focus();
      err[0].innerText = 'Masukkan username!';
      return false;
    }else if(password.value == ''){
      password.focus();
      err[1].innerText = 'Masukkan password!';
      return false;
    }else{
      const data = new FormData();
      data.append('username', username.value);
      data.append('password', password.value);
      data.append('remember', remember.checked);
      data.append('login', true);
      const pro = new XMLHttpRequest();
      pro.open('post', 'pro.php', true);
      pro.onloadstart = function(){
        ani_show();
      };
      pro.onreadystatechange = function(){
        if(this.readyState === 4 && this.status === 200){
          const res = JSON.parse(this.responseText);
          ani_hide();
          if(res.oke === true){
            window.location.href = res.drc;
          }else if(res.not_user === true){
            username.focus();
            err[0].innerText = res.msg;
            return false;
          }else if(res.not_pass === true){
            password.focus();
            err[1].innerText = res.msg;
            return false;
          }
        }
      };
      pro.send(data);
    }
  }
}

if(qs('#logout') != null){
  const logout = qsa('#logout');
  for(let i = 0; i < logout.length; i++){
    logout[i].onclick = () => {
      alertBox({
        title: 'Konfirmasi',
        text: 'Ingin keluar?',
        icon: 'warning',
        not: 'Batal',
        oke: 'Keluar',
      });
      next = () => {
        const data = new FormData();
        data.append('logout', true);
        const pro = new XMLHttpRequest();
        pro.open('post', 'pro.php', true);
        pro.onloadstart = function(){
          ani_show();
        };
        pro.onreadystatechange = function(){
          if(this.readyState === 4 && this.status === 200){
            const res = JSON.parse(this.responseText);
            ani_hide();
            if(res.oke === true){
              window.location.href = res.drc;
            }
          }
        };
        pro.send(data);
      }
    }
  }
}

if(qs('#register') != null){
  const form = qs('#register'),
  username = qs('#register #username'),
  password = qs('#register #password'),
  konfirmasi = qs('#register #konfirmasi'),
  shp = qs('#register #shp'),
  eye = shp.innerHTML,
  shc = qs('#register #shc'),
  err = qsa('#register .err');
  shp.onclick = () => {
    if(password.type == 'password'){
      shp.innerHTML = '<i class="fas fa-eye-slash"></i>';
      password.type = 'text';
    }else{
      shp.innerHTML = eye;
      password.type = 'password';
    }
  }
  shc.onclick = () => {
    if(konfirmasi.type == 'password'){
      shc.innerHTML = '<i class="fas fa-eye-slash"></i>';
      konfirmasi.type = 'text';
    }else{
      shc.innerHTML = eye;
      konfirmasi.type = 'password';
    }
  }
  form.onsubmit = (e) => {
    e.preventDefault();
    for(let i = 0; i < err.length; i++){
      err[i].innerText = '';
    }
    if(username.value == ''){
      username.focus();
      err[0].innerText = 'Masukkan username!';
      return false;
    }else if(username.value.length < 6){
      username.focus();
      err[0].innerText = 'Minimal 6 karakter!';
      return false;
    }else if(username.value.length > 30){
      username.focus();
      err[0].innerText = 'Maksimal 30 karakter!';
      return false;
    }else if(!(username.value.match(/[a-z]/))){
      username.focus();
      err[0].innerText = 'Minimal 1 huruf kecil!';
      return false;
    }else if(!(username.value.match(/[A-Z]/))){
      username.focus();
      err[0].innerText = 'Minimal 1 huruf besar!';
      return false;
    }else if(!(username.value.match(/[0-9]/))){
      username.focus();
      err[0].innerText = 'Minimal 1 angka!';
      return false;
    }else if(password.value == ''){
      password.focus();
      err[1].innerText = 'Masukkan password!';
      return false;
    }else if(password.value.length < 6){
      password.focus();
      err[1].innerText = 'Minimal 6 karakter!';
      return false;
    }else if(password.value.length > 20){
      password.focus();
      err[1].innerText = 'Maksimal 20 karakter!';
      return false;
    }else if(!(password.value.match(/[a-z]/))){
      password.focus();
      err[1].innerText = 'Minimal 1 huruf kecil!';
      return false;
    }else if(!(password.value.match(/[A-Z]/))){
      password.focus();
      err[1].innerText = 'Minimal 1 huruf besar!';
      return false;
    }else if(!(password.value.match(/[0-9]/))){
      password.focus();
      err[1].innerText = 'Minimal 1 angka!';
      return false;
    }else if(konfirmasi.value == ''){
      konfirmasi.focus();
      err[2].innerText = 'Masukkan konfirmasi password!';
      return false;
    }else if(konfirmasi.value != password.value){
      konfirmasi.focus();
      err[2].innerText = 'Konfirmasi password salah!';
      return false;
    }else{
      const data = new FormData();
      data.append('username', username.value);
      data.append('password', password.value);
      data.append('register', true);
      const pro = new XMLHttpRequest();
      pro.open('post', 'pro.php', true);
      pro.onloadstart = function(){
        ani_show();
      };
      pro.onreadystatechange = function(){
        if(this.readyState === 4 && this.status === 200){
          const res = JSON.parse(this.responseText);
          ani_hide();
          if(res.oke === true){
            alertBox({
              title: res.title,
              text: res.text,
              icon: res.icon,
              oke: res.btn,
            });
            next = () => {
              window.location.href = res.drc;
            }
          }else if(res.not === true){
            alertBox({
              title: res.title,
              text: res.text,
              icon: res.icon,
              not: res.btn,
            });
            return false;
          }else if(res.not_user === true){
            username.focus();
            err[0].innerText = res.msg;
            return false;
          }
        }
      };
      pro.send(data);
    }
  }
}

if(qs('#input-admin') != null){
  const form = qs('#input-admin'),
  username = qs('#input-admin #username'),
  password = qs('#input-admin #password'),
  konfirmasi = qs('#input-admin #konfirmasi'),
  toko = qs('#input-admin #toko'),
  shp = qs('#input-admin #shp'),
  eye = shp.innerHTML,
  shc = qs('#input-admin #shc'),
  err = qsa('#input-admin .err'),
  batalInput = qs('#batalInput');
  shp.onclick = () => {
    if(password.type == 'password'){
      shp.innerHTML = '<i class="fas fa-eye-slash"></i>';
      password.type = 'text';
    }else{
      shp.innerHTML = eye;
      password.type = 'password';
    }
  }
  shc.onclick = () => {
    if(konfirmasi.type == 'password'){
      konfirmasi.type = 'text';
      shc.innerHTML = '<i class="fas fa-eye-slash"></i>';
    }else{
      konfirmasi.type = 'password';
      shc.innerHTML = eye;
    }
  }
  form.onsubmit = (e) => {
    e.preventDefault();
    for(let i = 0; i < err.length; i++){
      err[i].innerText = '';
    }
    if(username.value == ''){
      username.focus();
      err[0].innerText = 'Masukkan username!';
      return false;
    }else if(username.value.length < 6){
      username.focus();
      err[0].innerText = 'Minimal 6 karakter!';
      return false;
    }else if(username.value.length > 30){
      username.focus();
      err[0].innerText = 'Maksimal 30 karakter!';
      return false;
    }else if(!(username.value.match(/[a-z]/))){
      username.focus();
      err[0].innerText = 'Minimal 1 huruf kecil!';
      return false;
    }else if(!(username.value.match(/[A-Z]/))){
      username.focus();
      err[0].innerText = 'Minimal 1 huruf besar!';
      return false;
    }else if(!(username.value.match(/[0-9]/))){
      username.focus();
      err[0].innerText = 'Minimal 1 angka!';
      return false;
    }else if(password.value == ''){
      password.focus();
      err[1].innerText = 'Masukkan password!';
      return false;
    }else if(password.value.length < 6){
      password.focus();
      err[1].innerText = 'Minimal 6 karakter!';
      return false;
    }else if(password.value.length > 20){
      password.focus();
      err[1].innerText = 'Maksimal 20 karakter!';
      return false;
    }else if(!(password.value.match(/[a-z]/))){
      password.focus();
      err[1].innerText = 'Minimal 1 huruf kecil!';
      return false;
    }else if(!(password.value.match(/[A-Z]/))){
      password.focus();
      err[1].innerText = 'Minimal 1 huruf besar!';
      return false;
    }else if(!(password.value.match(/[0-9]/))){
      password.focus();
      err[1].innerText = 'Minimal 1 angka!';
      return false;
    }else if(konfirmasi.value == ''){
      konfirmasi.focus();
      err[2].innerText = 'Masukkan konfirmasi password!';
      return false;
    }else if(konfirmasi.value != password.value){
      konfirmasi.focus();
      err[2].innerText = 'Konfirmasi password salah!';
      return false;
    }else if(toko.value == ''){
      toko.focus();
      err[3].innerText = 'Pilih toko!';
      return false;
    }else{
      const data = new FormData();
      data.append('username', username.value);
      data.append('password', password.value);
      data.append('toko', toko.value);
      data.append('input-admin', true);
      const pro = new XMLHttpRequest();
      pro.open('post', 'pro.php', true);
      pro.onloadstart = function(){
        ani_show();
      };
      pro.onreadystatechange = function(){
        if(this.readyState === 4 && this.status === 200){
          const res = JSON.parse(this.responseText);
          ani_hide();
          if(res.oke === true){
            modal_hide(qs('.modal'));
            alertBox({
              title: res.title,
              text: res.text,
              icon: res.icon,
              oke: res.btn,
            });
            next = () => {
              window.location.href = res.drc;
            }
          }else if(res.not === true){
            alertBox({
              title: res.title,
              text: res.text,
              icon: res.icon,
              not: res.btn,
            });
            return false;
          }else if(res.not_user === true){
            username.focus();
            err[0].innerText = res.msg;
            return false;
          }
        }
      };
      pro.send(data);
    }
  }
  batalInput.onclick = () => {
    form.reset();
    for(let i = 0; i < err.length; i++){
      err[i].innerText = '';
    }
    qs('#inputToko').classList.add('d-none');
    qs('#errNama').innerText = '';
  }
}

if(qs('#editAdmin') != null){
  const admin = qsa('#editAdmin');
  for(let i = 0; i < admin.length; i++){
    admin[i].onclick = (e) => {
      e.preventDefault();
      const dataId = admin[i].getAttribute('data-id'),
      dataUser = admin[i].getAttribute('data-user'),
      form = qs('#edit-admin'),
      username = qs('#edit-admin #username'),
      password = qs('#edit-admin #password'),
      shp = qs('#edit-admin #shp'),
      eye = shp.innerHTML,
      iduser = qs('#edit-admin #data-id'),
      err = qsa('#edit-admin .err'),
      batalEdit = qs('#edit-admin #batalEdit');
      username.value = dataUser;
      iduser.value = dataId;
      shp.onclick = () => {
        if(password.type == 'password'){
          password.type = 'text';
          shp.innerHTML = '<i class="fas fa-eye-slash"></i>';
        }else{
          password.type = 'password';
          shp.innerHTML = eye;
        }
      }
      form.onsubmit = (e) => {
        e.preventDefault();
        for(let i = 0; i < err.length; i++){
          err[i].innerText = '';
        }
        if(username.value == ''){
          username.focus();
          err[0].innerText = 'Masukkan username!';
          return false;
        }else if(username.value.length < 6){
          username.focus();
          err[0].innerText = 'Minimal 6 karakter!';
          return false;
        }else if(username.value.length > 30){
          username.focus();
          err[0].innerText = 'Maksimal 30 karakter!';
          return false;
        }else if(!(username.value.match(/[a-z]/))){
          username.focus();
          err[0].innerText = 'Minimal 1 huruf kecil!';
          return false;
        }else if(!(username.value.match(/[A-Z]/))){
          username.focus();
          err[0].innerText = 'Minimal 1 huruf besar!';
          return false;
        }else if(!(username.value.match(/[0-9]/))){
          username.focus();
          err[0].innerText = 'Minimal 1 angka!';
          return false;
        }else if(password.value != '' && password.value.length < 6){
          password.focus();
          err[1].innerText = 'Minimal 6 karakter!';
          return false;
        }else if(password.value != '' && password.value.length > 20){
          password.focus();
          err[1].innerText = 'Maksimal 20 karakter!';
          return false;
        }else if(password.value != '' && !(password.value.match(/[a-z]/))){
          password.focus();
          err[1].innerText = 'Minimal 1 huruf kecil!';
          return false;
        }else if(password.value != '' && !(password.value.match(/[A-Z]/))){
          password.focus();
          err[1].innerText = 'Minimal 1 huruf besar!';
          return false;
        }else if(password.value != '' && !(password.value.match(/[0-9]/))){
          password.focus();
          err[1].innerText = 'Minimal 1 angka!';
          return false;
        }else if(iduser.value == ''){
          alert('Error');
          return false;
        }else{
          const data = new FormData();
          data.append('username', username.value);
          data.append('password', password.value);
          data.append('iduser', iduser.value);
          data.append('edit-admin', true);
          const pro = new XMLHttpRequest();
          pro.onloadstart = function(){
            ani_show();
          };
          pro.open('post', 'pro.php', true);
          pro.onreadystatechange = function(){
            if(this.readyState === 4 && this.status === 200){
              const res = JSON.parse(this.responseText);
              ani_hide();
              if(res.oke === true){
                modal_hide(qsa('.modal')[1]);
                form.reset();
                alertBox({
                  title: res.title,
                  text: res.text,
                  icon: res.icon,
                  oke: res.btn,
                });
                next = () => {
                  window.location.reload();
                }
              }else if(res.not === true){
                alertBox({
                  title: res.title,
                  text: res.text,
                  icon: res.icon,
                  not: res.btn,
                });
                return false;
              }else if(res.not_user === true){
                username.focus();
                err[0].innerText = res.msg;
                return false;
              }
            }
          };
          pro.send(data);
        }
        batalEdit.onclick = () => {
          form.reset();
          for(let i = 0; i < err.length; i++){
            err[i].innerText = '';
          }
        }
      }
    }
  }
}

if(qs('#hapusAdmin') != null){
  const hapus = qsa('#hapusAdmin');
  for(let i = 0; i < hapus.length; i++){
    hapus[i].onclick = (e) => {
      let rtext, user = hapus[i].getAttribute('data-user');
      if(hapus.length > 1){
        rtext = 'Hapus admin <b>'+user+'</b> ?';
      }else{
        rtext = 'Yakin ingin menghapus akun Anda?';
      }
      alertBox({
        title: 'Konfirmasi',
        text: rtext,
        icon: 'warning',
        not: 'Batal',
        oke: 'Hapus',
      });
      next = () => {
        const data = new FormData();
        data.append('dataId', hapus[i].getAttribute('data-id'));
        data.append('hapus-admin', true);
        const pro = new XMLHttpRequest();
        pro.open('post', 'pro.php', true);
        pro.onloadstart = function(){
          ani_show();
        };
        pro.onreadystatechange = function(){
          if(this.readyState === 4 && this.status === 200){
            const res = JSON.parse(this.responseText);
            ani_hide();
            if(res.oke === true){
              alertBox({
                title: res.title,
                text: res.text,
                icon: res.icon,
                oke: res.btn,
              });
              next = () => {
                window.location.reload();
              }
            }else if(res.not === true){
              alertBox({
                title: res.title,
                text: res.text,
                icon: res.icon,
                not: res.btn,
              });
              return false;
            }
          }
        };
        pro.send(data);
      }
    }
  }
}

if(qs('#grup') != null){
  const form = qs('#grup'),
  nama = qs('#grup #nama'),
  err = qs('#grup .err');
  nama.oninput = () => {
    nama.value = ucfirst(nama.value);
  }
  form.onsubmit = (e) => {
    e.preventDefault();
    err.innerText = '';
    if(nama.value == ''){
      nama.focus();
      err.innerText = 'Masukkan nama grup!';
      return false;
    }else if(nama.value.length > 30){
      nama.focus();
      err.innerText = 'Maksimal 30 karakter!';
      return false;
    }else{
      const data = new FormData();
      data.append('nama', nama.value);
      data.append('input-grup', true);
      const pro = new XMLHttpRequest();
      pro.open('post', 'pro.php', true);
      pro.onloadstart = function(){
        ani_show();
      };
      pro.onreadystatechange = function(){
        if(this.readyState === 4 && this.status === 200){
          const res = JSON.parse(this.responseText);
          ani_hide();
          if(res.oke === true){
            nama.blur();
            alertBox({
              title: res.title,
              text: res.text,
              icon: res.icon,
              oke: res.btn,
            });
            next = () => {
              window.location.reload();
            }
          }else if(res.not === true){
            alertBox({
              title: res.title,
              text: res.text,
              icon: res.icon,
              not: res.btn,
            });
            return false;
          }else if(res.not_nama === true){
            nama.focus();
            err.innerHTML = res.msg;
            return false;
          }
        }
      };
      pro.send(data);
    }
  }
}

if(qs('#editGrup') != null){
  const editGrup = qs('#editGrup'),
  dataId = editGrup.getAttribute('data-id'),
  dataNama = editGrup.getAttribute('data-nama');
  editGrup.onclick = () => {
    const form = qs('#edit-grup'),
    nama = qs('#edit-grup #nama'),
    err = qs('#edit-grup .err'),
    batalEdit = qs('#edit-grup #batalEdit');
    nama.value = dataNama;
    nama.oninput = () => {
      nama.value = ucfirst(nama.value);
    }
    form.onsubmit = (e) => {
      e.preventDefault();
      err.innerText = '';
      if(nama.value == ''){
        nama.focus();
        err.innerText = 'Masukkan nama grup!';
        return false;
      }else if(nama.value.length > 30){
        nama.focus();
        err.innerText = 'Maksimal 30 karakter!';
        return false;
      }else{
        const data = new FormData();
        data.append('dataId', dataId);
        data.append('nama', nama.value);
        data.append('edit-grup', true);
        const pro = new XMLHttpRequest();
        pro.open('post', 'pro.php', true);
        pro.onloadstart = function(){
          ani_show();
        };
        pro.onreadystatechange = function(){
          if(this.readyState === 4 && this.status === 200){
            const res = JSON.parse(this.responseText);
            ani_hide();
            if(res.oke === true){
              modal_hide(qs('.modal'));
              alertBox({
                title: res.title,
                text: res.text,
                icon: res.icon,
                oke: res.btn,
              });
              next = () => {
                window.location.reload();
              }
            }else if(res.not === true){
              alertBox({
                title: res.title,
                text: res.text,
                icon: res.icon,
                not: res.btn,
              });
              return false;
            }else if(res.not_nama === true){
              nama.focus();
              err.innerText = res.msg;
              return false;
            }
          }
        };
        pro.send(data);
      }
    }
    batalEdit.onclick = () => {
      form.reset();
      err.innerText = '';
    }
  }
}

if(qs('#hapusGrup') != null){
  const hapusGrup = qs('#hapusGrup');
  hapusGrup.onclick = () => {
    alertBox({
      title: 'Konfirmasi',
      text: '<p class="fw-bold text-danger">Perhatian!!!</p><p>Jika pilih hapus grup maka akan menghapus semua data toko termasuk seluruh data penjualan!</p>',
      icon: 'warning',
      not: 'Batal',
      oke: 'Hapus',
    });
   next = () => {
      const data = new FormData();
      data.append('dataId', hapusGrup.getAttribute('data-id'));
      data.append('hapus-grup', true);
      const pro = new XMLHttpRequest();
      pro.open('post', 'pro.php', true);
      pro.onloadstart = function(){
        ani_show();
      };
      pro.onreadystatechange = function(){
        if(this.readyState === 4 && this.status === 200){
          const res = JSON.parse(this.responseText);
          ani_hide();
          if(res.oke === true){
            alertBox({
              title: res.title,
              text: res.text,
              icon: res.icon,
              oke: res.btn,
            });
            next = () => {
              window.location.reload();
            }
          }else if(res.not === true){
            alertBox({
              title: res.title,
              text: res.text,
              icon: res.icon,
              not: res.btn,
            });
            return false;
          }
        }
      };
      pro.send(data);
    }
  }
}

if(qs('#input-toko') != null){
  const form = qs('#input-toko'),
  nama = qs('#input-toko #nama'),
  err = qs('#input-toko .err');
  nama.oninput = () => {
    nama.value = ucfirst(nama.value);
  }
  form.onsubmit = (e) => {
    e.preventDefault();
    err.innerText = '';
    if(nama.value == ''){
      nama.focus();
      err.innerText = 'Masukkan nama toko!';
      return false;
    }else if(nama.value.length > 30){
      nama.focus();
      err.innerText = 'Maksimal 30 karakter!';
      return false;
    }else{
      const data = new FormData();
      data.append('nama', nama.value);
      data.append('input-toko', true);
      const pro = new XMLHttpRequest();
      pro.open('post', 'pro.php', true);
      pro.onloadstart = function(){
        ani_show();
      };
      pro.onreadystatechange = function(){
        if(this.readyState === 4 && this.status === 200){
          const res = JSON.parse(this.responseText);
          ani_hide();
          if(res.oke === true){
            nama.blur();
            alertBox({
              title: res.title,
              text: res.text,
              icon: res.icon,
              oke: res.btn,
            });
            next = () => {
              window.location.reload();
            }
          }else if(res.not === true){
            alertBox({
              title: res.title,
              text: res.text,
              icon: res.icon,
              not: res.btn,
            });
            return false;
          }else if(res.not_nama === true){
            nama.focus();
            err.innerHTML = res.msg;
            return false;
          }
        }
      };
      pro.send(data);
    }
  }
}

if(qs('#editToko') != null){
  const editToko = qsa('#editToko');
  for(let i = 0; i < editToko.length; i++){
    editToko[i].onclick = () => {
      const dataId = editToko[i].getAttribute('data-id'),
      dataNama = editToko[i].getAttribute('data-nama'),
      form = qs('#edit-toko'),
      nama = qs('#edit-toko #nama'),
      err = qs('#edit-toko .err');
      nama.value = dataNama;
      nama.oninput = () => {
        nama.value = ucfirst(nama.value);
      }
      form.onsubmit = (e) => {
        e.preventDefault();
        err.innerText = '';
        if(nama.value == ''){
          nama.focus();
          err.innerText = 'Masukkan nama toko!';
          return false;
        }else if(nama.value.length > 30){
          nama.focus();
          err.innerText = 'Maksimal 30 karakter!';
          return false;
        }else{
          const data = new FormData();
          data.append('dataId', dataId);
          data.append('nama', nama.value);
          data.append('edit-toko', true);
          const pro = new XMLHttpRequest();
          pro.open('post', 'pro.php', true);
          pro.onloadstart = function(){
            ani_show();
          };
          pro.onreadystatechange = function(){
            if(this.readyState === 4 && this.status === 200){
              const res = JSON.parse(this.responseText);
              ani_hide();
              if(res.oke === true){
                modal_hide(qsa('.modal')[1]);
                alertBox({
                  title: res.title,
                  text: res.text,
                  icon: res.icon,
                  oke: res.btn,
                });
                next = () => {
                  window.location.reload();
                }
              }else if(res.not === true){
                alertBox({
                  title: res.title,
                  text: res.text,
                  icon: res.icon,
                  not: res.btn,
                });
                return false;
              }else if(res.not_nama === true){
                nama.focus();
                err.innerText = res.msg;
                return false;
              }
            }
          };
          pro.send(data);
        }
      }
    }
  }
}

if(qs('#hapusToko') != null){
  const hapusToko = qsa('#hapusToko');
  for(let i = 0; i < hapusToko.length; i++){
    hapusToko[i].onclick = () => {
      alertBox({
        title: 'Konfirmasi',
        text: '<p class="fw-bold text-danger">Perhatian!!!</p><p>Jika pilih hapus toko maka akan menghapus seluruh data penjualan toko!</p>',
        icon: 'warning',
        not: 'Batal',
        oke: 'Hapus',
      });
      next = () => {
        const data = new FormData();
        data.append('dataId', hapusToko[i].getAttribute('data-id'));
        data.append('hapus-toko', true);
        const pro = new XMLHttpRequest();
        pro.open('post', 'pro.php', true);
        pro.onloadstart = function(){
          ani_show();
        };
        pro.onreadystatechange = function(){
          if(this.readyState === 4 && this.status === 200){
            const res = JSON.parse(this.responseText);
            ani_hide();
            if(res.oke === true){
              alertBox({
                title: res.title,
                text: res.text,
                icon: res.icon,
                oke: res.btn,
              });
              next = () => {
                window.location.reload();
              }
            }else if(res.not === true){
              alertBox({
                title: res.title,
                text: res.text,
                icon: res.icon,
                not: res.btn,
              });
              return false;
            }
          }
        };
        pro.send(data);
      }
    }
  }
}

if(qs('.input-toko') != null){
  qs('.input-toko').onclick = (e) => {
    e.preventDefault();
    let inputToko = qs('#inputToko');
    inputToko.classList.toggle('d-none');
    const namaToko = qs('#inputToko #namaToko'),
    simpanToko = qs('#inputToko #simpanToko'),
    errNama = qs('#inputToko #errNama');
    namaToko.focus();
    namaToko.oninput = () => {
      namaToko.value = ucfirst(namaToko.value);
    }
    simpanToko.onclick = (e) => {
      e.preventDefault();
      errNama.innerText = '';
      if(namaToko.value == ''){
        namaToko.focus();
        errNama.innerText = 'Masukkan nama toko!';
        return false;
      }else if(namaToko.value.length > 30){
        namaToko.focus();
        errNama.innerText = 'Maksimal 30 karakter!';
        return false;
      }else{
        const data = new FormData();
        data.append('namaToko', namaToko.value);
        data.append('input-toko-baru', true);
        const pro = new XMLHttpRequest();
        pro.open('post', 'pro.php', true);
        pro.onloadstart = function(){
          ani_show();
        };
        pro.onreadystatechange = function(){
          if(this.readyState === 4 && this.status === 200){
            const res = JSON.parse(this.responseText);
            ani_hide();
            if(res.oke === true){
              alertBox({
                title: res.title,
                text: res.text,
                icon: res.icon,
                oke: res.btn,
              });
              inputToko.classList.toggle('d-none');
              namaToko.value = '';
              qs('#input-admin #toko').innerHTML = res.list;
            }else if(res.not === true){
              alertBox({
                title: res.title,
                text: res.text,
                icon: res.icon,
                not: res.btn,
              });
              return false;
            }else if(res.not_nama === true){
              namaToko.focus();
              errNama.innerText = res.msg;
              return false;
            }
          }
        };
        pro.send(data);
      }
    }
  }
}

if(qs('#harian') != null){
  const form = qs('#harian'),
  nama = qs('#harian #nama'),
  harga = qs('#harian #harga'),
  jumlah = qs('#harian #jumlah'),
  modal = qs('#harian #modal'),
  tanggal = qs('#harian #tanggal'),
  bulan = qs('#harian #bulan'),
  tahun = qs('#harian #tahun'),
  box = qs('.box-result'),
  mores = qs('.mores');
  if(qs('#btnInputPenjualan') != null){
    const btnInpen = qs('#btnInputPenjualan');
    btnInpen.onclick = (e) => {
      e.preventDefault();
      nama.focus();
      btnInpen.classList.add('d-none');
    }
  }
  nama.oninput = () => {
    if(nama.value != ''){
      const data = new FormData();
      data.append('nama', nama.value);
      data.append('load-data', true);
      const pro = new XMLHttpRequest();
      pro.open('post', 'pro.php', true);
      pro.onreadystatechange = function(){
        if(this.readyState === 4 && this.status === 200){
          box.classList.add('active');
          box.innerHTML = this.responseText;
          const item = qsa('#item');
          for(let i = 0; i < item.length; i++){
            item[i].onclick = () => {
              nama.value = item[i].innerText;
              modal.value = item[i].getAttribute('data-modal');
              box.classList.remove('active');
              box.innerHTML = '';
              harga.removeAttribute('readonly');
              harga.focus();
              mores.classList.add('active');
              mores.innerText = 'Modal : '+fornum(item[i].getAttribute('data-modal'));
            }
          }
        }
      };
      pro.send(data);
    }else{
      box.classList.remove('active');
      box.innerHTML = '';
      harga.setAttribute('readonly', '');
    }
    mores.classList.remove('active');
  }
  harga.oninput = () => {
    harga.value = fornum(harga.value);
    if(harga.value.length > 4){
      jumlah.removeAttribute('readonly');
    }else{
      jumlah.setAttribute('readonly','');
    }
  }
  jumlah.oninput = () => {
    jumlah.value = fornum(jumlah.value);
    mores.classList.remove('active');
  }
  form.onsubmit = (e) => {
    e.preventDefault();
    jumlah.blur();
    if(nama.value == ''){
      nama.focus();
      return false;
    }else if(harga.value == ''){
      harga.focus();
      return false;
    }else if(jumlah.value == ''){
      jumlah.focus();
      return false;
    }else{
      const data = new FormData();
      data.append('nama', nama.value);
      data.append('harga', harga.value);
      data.append('jumlah', jumlah.value);
      data.append('modal', modal.value);
      data.append('tanggal', tanggal.value);
      data.append('bulan', bulan.value);
      data.append('tahun', tahun.value);
      data.append('input-penjualan', true);
      const pro = new XMLHttpRequest();
      pro.open('post', 'pro.php', true);
      pro.onloadstart = function(){
        ani_show();
      };
      pro.onreadystatechange = function(){
        if(this.readyState === 4 && this.status === 200){
          const res = JSON.parse(this.responseText);
          ani_hide();
          if(res.oke === true){
            window.location.reload();
          }else if(res.not === true){
            alertBox({
              title: res.title,
              text: res.text,
              icon: res.icon,
              not: res.btn,
            });
            return false;
          }
        }
      }
      pro.send(data);
    }
  }
}

if(qs('#input-data') != null){
  const form = qs('#input-data'),
  nama = qs('#input-data #nama'),
  modal = qs('#input-data #modal'),
  err = qsa('#input-data .err');
  nama.oninput = () => {
    nama.value = ucfirst(nama.value);
  }
  modal.oninput = () => {
    modal.value = fornum(modal.value);
  }
  form.onsubmit = (e) => {
    e.preventDefault();
    modal.blur();
    for(let i = 0; i < err.length; i++){
      err[i].innerText = '';
    }
    if(nama.value == ''){
      nama.focus();
      err[0].innerText = 'Masukkan merek!';
      return false;
    }else if(nama.value.length > 30){
      nama.focus();
      err[0].innerText = 'Maksimal 30 karakter!';
      return false;
    }else if(modal.value == ''){
      modal.focus();
      err[1].innerText = 'Masukkan modal!';
      return false;
    }else if(modal.value.length > 7){
      modal.focus();
      err[1].innerText = 'Maksimal 7 angka!';
      return false;
    }else{
      const data = new FormData();
      data.append('nama', nama.value);
      data.append('modal', modal.value);
      data.append('input-data', true);
      const pro = new XMLHttpRequest();
      pro.open('post', 'pro.php', true);
      pro.onloadstart = function(){
        ani_show();
      };
      pro.onreadystatechange = function(){
        if(this.readyState === 4 && this.status === 200){
          const res = JSON.parse(this.responseText);
          ani_hide();
          if(res.oke === true){
            alertBox({
              title: res.title,
              text: res.text,
              icon: res.icon,
              oke: res.btn,
            });
            next = () => {
              window.location.reload();
            }
          }else if(res.not === true){
            alertBox({
              title: res.title,
              text: res.text,
              icon: res.icon,
              not: res.btn,
            });
            return false;
          }else if(res.not_nama === true){
            nama.focus();
            err[0].innerText = res.msg;
            return false;
          }
        }
      };
      pro.send(data);
    }
  }
}

if(qs('#cari-data') != null){
  const cari = qs('#cari-data'),
  resmo = qs('#resmo'),
  inputData = qs('#input-data');
  cari.onfocus = () => {
    inputData.classList.toggle('input');
  }
  cari.onblur = () => {
    inputData.classList.toggle('input');
  }
  cari.oninput = (e) => {
    e.preventDefault();
    const data = new FormData();
    data.append('merek', cari.value);
    data.append('cari-data', true);
    const pro = new XMLHttpRequest();
    pro.open('post', 'pro.php', true);
    pro.onreadystatechange = function(){
      if(this.readyState === 4 && this.status === 200){
        resmo.innerHTML = this.responseText;
        const btnEdit = qsa('#editData');
        for(let i = 0; i < btnEdit.length; i++){
          btnEdit[i].onclick = () => {
            const dataId = btnEdit[i].getAttribute('data-id'); 
            dataNama = btnEdit[i].getAttribute('data-nama'),
            dataModal = btnEdit[i].getAttribute('data-modal'),
            form = qs('#edit-data'),
            nama = qs('#edit-data #nama'),
            modal = qs('#edit-data #modal'),
            err = qsa('#edit-data .err');
            btnBatal = qs('#batalEdit');
            nama.value = dataNama;
            modal.value = dataModal;
            nama.oninput = () => {
              nama.value = ucfirst(nama.value);
            }
            modal.oninput = () => {
              modal.value = fornum(modal.value);
            }
            form.onsubmit = (e) => {
              e.preventDefault();
              for(let i = 0; i < err.length; i++){
                err[i].innerText = '';
              }
              if(nama.value == ''){
                nama.focus();
                err[0].innerText = 'Tidak boleh kosong!';
                return false;
              }else if(nama.value.length > 30){
                nama.focus();
                err[0].innerText = 'Maksimal 30 karakter!';
                return false;
              }else if(modal.value == ''){
                modal.focus();
                err[1].innerText = 'Tidak boleh kosong!';
                return false;
              }else if(modal.value.length > 7){
                modal.focus();
                err[1].innerText = 'Maksimal 7 angka!';
                return false;
              }else{
                const data = new FormData();
                data.append('id', dataId);
                data.append('nama', nama.value);
                data.append('modal', modal.value);
                data.append('edit-data', true);
                const pro = new XMLHttpRequest();
                pro.open('post', 'pro.php', true);
                pro.onloadstart = function(){
                  ani_show();
                };
                pro.onreadystatechange = function(){
                  if(this.readyState === 4 && this.status === 200){
                    const res = JSON.parse(this.responseText);
                    ani_hide();
                    if(res.oke === true){
                      modal_hide(qs('.modal'));
                      alertBox({
                        title: res.title,
                        text: res.text,
                        icon: res.icon,
                        oke: res.btn,
                      });
                      next = () => {
                        window.location.reload();
                      }
                    }else if(res.not === true){
                      alertBox({
                        title: res.title,
                        text: res.text,
                        icon: res.icon,
                        not: res.btn,
                      });
                      return false;
                    }else if(res.not_nama === true){
                      nama.focus();
                      err[0].innerText = res.msg;
                      return false;
                    }
                  }
                };
                pro.send(data);
              }
            }
            btnBatal.onclick = () => {
              form.reset();
              for(let i = 0; i < err.length; i++){
                err[i].innerText = '';
              }
            }
          }
        }
        const btnHapus = qsa('#hapusData');
        for(let i = 0; i < btnHapus.length; i++){
          btnHapus[i].onclick = () => {
            const dataId = btnHapus[i].getAttribute('data-id'),
            data_baris = btnHapus[i].getAttribute('data-baris'),
            data_nama = btnHapus[i].getAttribute('data-nama'),
            data_modal = btnHapus[i].getAttribute('data-modal'),
            rtext = 'Hapus data baris ke <b>'+data_baris+'</b>, <b>'+data_nama+'</b>, <b>'+data_modal+'</b>';
            alertBox({
              title: 'Konfirmasi',
              text: rtext,
              icon: 'warning',
              not: 'Batal',
              oke: 'Hapus',
            });
            next = () => {
              const data = new FormData();
              data.append('id', dataId);
              data.append('hapus-data', true);
              const pro = new XMLHttpRequest();
              pro.open('post', 'pro.php', true);
              pro.onloadstart = function(){
               ani_show();
             };
              pro.onreadystatechange = function(){
                if(this.readyState === 4 && this.status === 200){
                  const res = JSON.parse(this.responseText);
                  ani_hide();
                  if(res.oke === true){
                    alertBox({
                      title: res.title,
                      text: res.text,
                      icon: res.icon,
                      oke: res.btn,
                    });
                    next = () => {
                      window.location.reload();
                    }
                  }else{
                    alertBox({
                      title: res.title,
                      text: res.text,
                      icon: res.icon,
                      not: res.btn,
                    });
                    return false;
                  }
                }
              };
              pro.send(data);
            }
          }
        }
      }
    };
    pro.send(data);
  }
}

if(qs('#editData') != null){
  const btnEdit = qsa('#editData');
  for(let i = 0; i < btnEdit.length; i++){
    btnEdit[i].onclick = () => {
      const dataId = btnEdit[i].getAttribute('data-id'); 
      dataNama = btnEdit[i].getAttribute('data-nama'),
      dataModal = btnEdit[i].getAttribute('data-modal'),
      form = qs('#edit-data'),
      nama = qs('#edit-data #nama'),
      modal = qs('#edit-data #modal'),
      err = qsa('#edit-data .err');
      btnBatal = qs('#batalEdit');
      nama.value = dataNama;
      modal.value = dataModal;
      nama.oninput = () => {
        nama.value = ucfirst(nama.value);
      }
      modal.oninput = () => {
        modal.value = fornum(modal.value)
      }
      form.onsubmit = (e) => {
        e.preventDefault();
        for(let i = 0; i < err.length; i++){
          err[i].innerText = '';
        }
        if(nama.value == ''){
          nama.focus();
          err[0].innerText = 'Tidak boleh kosong!';
          return false;
        }else if(nama.value.length > 30){
          nama.focus();
          err[0].innerText = 'Maksimal 30 karakter!';
          return false;
        }else if(modal.value == ''){
          modal.focus();
          err[1].innerText = 'Tidak boleh kosong!';
          return false;
        }else if(modal.value.length > 7){
          modal.focus();
          err[1].innerText = 'Maksimal 7 angka!';
          return false;
        }else{
          const data = new FormData();
          data.append('id', dataId);
          data.append('nama', nama.value);
          data.append('modal', modal.value);
          data.append('edit-data', true);
          const pro = new XMLHttpRequest();
          pro.open('post', 'pro.php', true);
          pro.onloadstart = function(){
            ani_show();
          };
          pro.onreadystatechange = function(){
            if(this.readyState === 4 && this.status === 200){
              const res = JSON.parse(this.responseText);
              ani_hide();
              if(res.oke === true){
                modal_hide(qs('.modal'));
                alertBox({
                  title: res.title,
                  text: res.text,
                  icon: res.icon,
                  oke: res.btn,
                });
                next = () => {
                  window.location.reload();
                }
              }else if(res.not === true){
                alertBox({
                  title: res.title,
                  text: res.text,
                  icon: res.icon,
                  oke: res.btn,
                });
                return false;
              }else if(res.not_nama === true){
                nama.focus();
                err[0].innerText = res.msg;
                return false;
              }
            }
          };
          pro.send(data);
        }
      }
      btnBatal.onclick = () => {
        form.reset();
        for(let i = 0; i < err.length; i++){
          err[i].innerText = '';
        }
      }
    }
  }
}

if(qs('#hapusData') != null){
  const btnHapus = qsa('#hapusData');
  for(let i = 0; i < btnHapus.length; i++){
    btnHapus[i].onclick = () => {
      const dataId = btnHapus[i].getAttribute('data-id'),
      data_baris = btnHapus[i].getAttribute('data-baris'),
      data_nama = btnHapus[i].getAttribute('data-nama'),
      data_modal = btnHapus[i].getAttribute('data-modal'),
      rtext = 'Hapus data baris ke <b>'+data_baris+'</b>, <b>'+data_nama+'</b>, <b>'+data_modal+'</b>';
      alertBox({
        title: 'Konfirmasi',
        text: rtext,
        icon: 'warning',
        not: 'Batal',
        oke: 'Hapus',
      });
      next = () => {
        const data = new FormData();
        data.append('id', dataId);
        data.append('hapus-data', true);
        const pro = new XMLHttpRequest();
        pro.open('post', 'pro.php', true);
        pro.onloadstart = function(){
          ani_show();
        };
        pro.onreadystatechange = function(){
          if(this.readyState === 4 && this.status === 200){
            const res = JSON.parse(this.responseText);
            ani_hide();
            if(res.oke === true){
              alertBox({
                title: res.title,
                text: res.text,
                icon: res.icon,
                oke: res.btn,
              });
              next = () => {
                window.location.reload();
              }
            }else if(res.not === true){
              alertBox({
                title: res.title,
                text: res.text,
                icon: res.icon,
                not: res.btn,
              });
              return false;
            }
          }
        };
        pro.send(data);
      }
    }
  }
}

if(qs('#btn-adpe') != null){
  qs('#btn-adpe').onclick = () => {
    qs('.box-depe').classList.remove('active');
    const box = qs('.box-adpe'),
    form = qs('#form-adpe'),
    pengeluaran = qs('#form-adpe #pengeluaran'),
    keterangan = qs('#form-adpe #keterangan'),
    tanggal = qs('#form-adpe #tanggal'),
    bulan = qs('#form-adpe #bulan'),
    tahun = qs('#form-adpe #tahun'),
    err = qsa('#form-adpe .err'),
    tutup = qs('#form-adpe button[type=button]');
    box.classList.add('active');
    pengeluaran.focus();
    pengeluaran.oninput = () => {
      pengeluaran.value = fornum(pengeluaran.value);
    }
    form.onsubmit = (e) => {
      e.preventDefault();
      for(let i = 0; i < err.length; i++){
        err[i].innerText = '';
      }
      if(pengeluaran.value == ''){
        pengeluaran.focus();
        err[0].innerText = 'Masukkan jumlah pengeluaran!';
        return false;
      }else if(keterangan.value == ''){
        keterangan.focus();
        err[1].innerText = 'Masukkan keterangan pengeluaran!';
        return false;
      }else{
        const data = new FormData();
        data.append('pengeluaran', pengeluaran.value);
        data.append('keterangan', keterangan.value);
        data.append('tanggal', tanggal.value);
        data.append('bulan', bulan.value);
        data.append('tahun', tahun.value);
        data.append('set-pengeluaran', true);
        const pro = new XMLHttpRequest();
        pro.open('post', 'pro.php', true);
        pro.onloadstart = function(){
          ani_show();
        };
        pro.onreadystatechange = function(){
          if(this.readyState === 4 && this.status === 200){
            const res = JSON.parse(this.responseText);
            ani_hide();
            if(res.oke === true){
              box.classList.remove('active');
              alertBox({
                title: res.title,
                text: res.text,
                icon: res.icon,
                oke: res.btn,
              });
              next = () => {
                window.location.reload();
              }
            }else if(res.not === true){
              alertBox({
                title: res.title,
                text: res.text,
                icon: res.icon,
                not: res.btn,
              });
              return false;
            }
          }
        };
        pro.send(data);
      }
    }
    tutup.onclick = () => {
      box.classList.remove('active');
      form.reset();
      for(let i = 0; i < err.length; i++){
        err[i].innerText = '';
      }
    }
  }
}

if(qs('#btn-depe') != null){
  qs('#btn-depe').onclick = () => {
    qs('.box-adpe').classList.remove('active');
    const box = qs('.box-depe');
    box.classList.add('active');
    const btnHapus = qsa('.box-depe #btn-hapus');
    for(let i = 0; i < btnHapus.length; i++){
      btnHapus[i].onclick = () => {
        let rtext = '<p>Hapus pengeluaran <b>'+fornum(btnHapus[i].getAttribute('data-pengeluaran'))+'</b> ('+btnHapus[i].getAttribute('data-keterangan')+')</p>';
        alertBox({
          title: 'Konfirmasi',
          text: rtext,
          icon: 'warning',
          not: 'Batal',
          oke: 'Hapus',
        });
        next = () => {
          const dataId = btnHapus[i].getAttribute('data-id');
          const data = new FormData();
          data.append('id', dataId);
          data.append('hapus-pengeluaran', true);
          const pro = new XMLHttpRequest();
          pro.open('post', 'pro.php', true);
          pro.onloadstart = function(){
            ani_show();
          };
          pro.onreadystatechange = function(){
            if(this.readyState === 4 && this.status === 200){
              const res = JSON.parse(this.responseText);
              ani_hide();
              if(res.oke === true){
                alertBox({
                  title: res.title,
                  text: res.text,
                  icon: res.icon,
                  oke: res.btn,
                });
                next = () => {
                  window.location.reload();
                }
              }else if(res.not === true){
                alertBox({
                  title: res.title,
                  text: res.text,
                  icon: res.icon,
                  not: res.btn,
                });
                return false;
              }
            }
          };
          pro.send(data);
        }
      }
    }
    qs('.box-depe #tutup').onclick = () => {
      box.classList.remove('active');
    }
  }
}

if(qs('#get-data') != null){
  const form = qs('#get-data'),
  tanggal = qs('#get-data #tanggal'),
  bulan = qs('#get-data #bulan'),
  tahun = qs('#get-data #tahun');
  form.onsubmit = (e) => {
    e.preventDefault();
    if(tanggal.value != '' && bulan.value != '' && tahun.value != ''){
      window.location.href = '?pg=data-penjualan&tanggal='+tanggal.value+'&bulan='+bulan.value+'&tahun='+tahun.value;
      return false;
    }else if(bulan.value != '' && tahun.value != ''){
      window.location.href = '?pg=data-penjualan&bulan='+bulan.value+'&tahun='+tahun.value;
      return false;
    }else if(tanggal.value == '' && tahun.value != ''){
      window.location.href = '?pg=data-penjualan&tahun='+tahun.value;
      return false;
    }else{
      window.location.href = '?pg=data-penjualan';
      return false;
    }
  }
}

if(qs('#btn-hapus') != null){
  const btnHapus = qsa('#btn-hapus');
  for(let i = 0; i < btnHapus.length; i++){
    btnHapus[i].onclick = () => {
      const nama = btnHapus[i].getAttribute('data-nama'),
      rtext = 'Hapus <b>'+nama+'</b> ?';
      alertBox({
        title: 'Konfirmasi',
        text: rtext,
        icon: 'warning',
        not: 'Batal',
        oke: 'Hapus',
      });
      next = () => {
        const dataId = btnHapus[i].getAttribute('data-id');
        const data = new FormData();
        data.append('id', dataId);
        data.append('hapus-item-penjualan', true);
        const pro = new XMLHttpRequest();
        pro.open('post', 'pro.php', true);
        pro.onloadstart = function(){
          ani_show();
        };
        pro.onreadystatechange = function(){
          if(this.readyState === 4 && this.status === 200){
            const res = JSON.parse(this.responseText);
            ani_hide();
            if(res.oke === true){
              alertBox({
                title: res.title,
                text: res.text,
                icon: res.icon,
                oke: res.btn,
              });
              next = () => {
                window.location.reload();
              }
            }else if(res.not === true){
              alertBox({
                title: res.title,
                text: res.text,
                icon: res.icon,
                not: res.btn,
              });
              return false;
            }
          }
        };
        pro.send(data);
      }
    }
  }
}

if(qs('#btn-edit') != null){
  const btnEdit = qsa('#btn-edit');
  for(let i = 0; i < btnEdit.length; i++){
    btnEdit[i].onclick = () => {
      const dataId = btnEdit[i].getAttribute('data-id'),
      dataNama = btnEdit[i].getAttribute('data-nama'),
      dataHarga = btnEdit[i].getAttribute('data-harga'),
      dataJumlah = btnEdit[i].getAttribute('data-jumlah'),
      dataModal = btnEdit[i].getAttribute('data-modal'),
      form = qs('#edit-penjualan'),
      nama = qs('#edit-penjualan #nama'),
      harga = qs('#edit-penjualan #harga'),
      jumlah = qs('#edit-penjualan #jumlah'),
      err = qsa('#edit-penjualan .err'),
      batalEdit = qs('#edit-penjualan #batalEdit');
      nama.value = dataNama;
      harga.value = fornum(dataHarga);
      jumlah.value = dataJumlah;
      harga.oninput = () => {
        harga.value = fornum(harga.value);
      }
      jumlah.oninput = () => {
        jumlah.value = fornum(jumlah.value);
      }
      form.onsubmit = (e) => {
        e.preventDefault();
        for(let i = 0; i < err.length; i++){
          err[i].innerText = '';
        }
        if(dataModal == ''){
          alert('Error');
          return false;
        }else if(harga.value == ''){
          harga.focus();
          err[1].innerText = 'Masukkan harga jual!';
          return false;
        }else if(jumlah.value == ''){
          jumlah.focus();
          err[2].innerText = 'Masukkan jumlah!';
          return false;
        }else{
          const data = new FormData();
          data.append('id', dataId);
          data.append('harga', harga.value);
          data.append('jumlah', jumlah.value);
          data.append('modal', dataModal);
          data.append('edit-item-penjualan', true);
          const pro = new XMLHttpRequest();
          pro.open('post', 'pro.php', true);
          pro.onloadstart = function(){
            ani_show();
          };
          pro.onreadystatechange = function(){
            if(this.readyState === 4 && this.status === 200){
              const res = JSON.parse(this.responseText);
              ani_hide();
              if(res.oke === true){
                modal_hide(qsa('.modal')[1]);
                alertBox({
                  title: res.title,
                  text: res.text,
                  icon: res.icon,
                  oke: res.btn,
                });
                next = () => {
                  window.location.reload();
                }
              }else if(res.not === true){
                alertBox({
                  title: res.title,
                  text: res.text,
                  icon: res.icon,
                  not: res.btn,
                });
                return false;
              }
            }
          };
          pro.send(data);
        }
      }
      batalEdit.onclick = () => {
        form.reset();
        for(let i = 0; i < err.length; i++){
          err[i].innerText = '';
        }
      }
    }
  }
}

if(qs('#adcat') != null){
  qs('#adcat').onclick = () => {
    qs('#forcat').setAttribute('data-target', 'false');
    qs('#forcat h5').innerText = 'Tambah Catatan Baru';
    setTimeout(function(){
      qs('#forcat #judul').focus();
    },500);
    qs('#forcat button[type=submit]').innerText = 'Simpan';
  }
}

if(qs('#btnEditCatatan') != null){
  const btn = qsa('#btnEditCatatan');
  for(let i = 0; i < btn.length; i++){
    btn[i].onclick = () => {
      qs('#forcat').setAttribute('data-target', btn[i].getAttribute('data-target'));
      qs('#forcat h5').innerText = 'Edit Catatan';
      qs('#forcat #judul').value = btn[i].getAttribute('data-judul');
      qs('#forcat #catatan').value = btn[i].getAttribute('data-catatan').replaceAll('<br>', '');
      qs('#forcat button[type=submit]').innerText = 'Perbarui';
    }
  }
}

if(qs('#btnHapusCatatan') != null){
  const btn = qsa('#btnHapusCatatan');
  for(let i = 0; i < btn.length; i++){
    btn[i].onclick = () => {
      const target = btn[i].getAttribute('data-target'),
      judul = btn[i].getAttribute('data-judul');
      alertBox({
        title: 'Konfirmasi',
        text: `Hapus <b>${judul}</b> ?`,
        not: 'Batal',
        oke: 'Hapus',
      });
      next = () => {
        const data = new FormData();
        data.append('target', target);
        data.append('hapus-catatan', true);
        const pro = new XMLHttpRequest();
        pro.open('post', 'pro.php', true);
        pro.onloadstart = function(){
          ani_show();
        };
        pro.onreadystatechange = function(){
          if(this.readyState === 4 && this.status === 200){
            const res = JSON.parse(this.responseText);
            ani_hide();
            if(res.oke === true){
              alertBox({
                title: res.title,
                text: res.text,
                icon: res.icon,
                oke: res.btn,
              });
              next = () => {
                window.location.reload();
              }
            }else if(res.not === true){
              alertBox({
                title: res.title,
                text: res.text,
                icon: res.icon,
                not: res.btn,
              });
              return false;
            }
          }
        };
        pro.send(data);
      }
    }
  }
}

if(qs('#btnDetailCatatan') != null){
  const btn = qsa('#btnDetailCatatan');
  for(let i = 0; i < btn.length; i++){
    btn[i].onclick = () => {
      const dataJudul = btn[i].getAttribute('data-judul'),
      dataTanggal = btn[i].getAttribute('data-tanggal'),
      dataCatatan = btn[i].getAttribute('data-catatan'),
      judul = qs('#ticat'),
      tanggal = qs('#tacat'),
      catatan = qs('#tecat'),
      tutup = qs('#bucat');
      judul.innerText = dataJudul;
      tanggal.innerHTML = `<span class="text-muted">${dataTanggal}</span>`;
      catatan.innerHTML = dataCatatan;
      tutup.innerText = 'Tutup';
      tutup.onclick = () => {
        judul.innerText = '';
        tanggal.innerText = '';
        catatan.innerText = '';
        tutup.innerText = '';
      }
    }
  }
}

if(qs('#forcat') != null){
  const form = qs('#forcat'),
  judul = qs('#forcat #judul'),
  catatan = qs('#forcat #catatan'),
  err = qsa('#forcat .err'),
  batal = qs('#forcat #batal');
  judul.oninput = () => {
    judul.value = ucfirst(judul.value);
  }
  form.onsubmit = (e) => {
    e.preventDefault();
    const target = form.getAttribute('data-target');
    for(let i = 0; i < err.length; i++){
      err[i].innerText = '';
    }
    if(judul.value == ''){
      judul.focus();
      err[0].innerText = 'Masukkan judul!';
      return false;
    }else if(judul.value.length > 50){
      judul.focus();
      err[0].innerText = 'Maksimal 50 karakter!';
      return false;
    }else if(catatan.value == ''){
      catatan.focus();
      err[1].innerText = 'Masukkan catatan!';
      return false;
    }else{
      const data = new FormData();
      data.append('target', target);
      data.append('judul', judul.value);
      data.append('catatan', catatan.value);
      if(target == 'false'){
        data.append('tambah-catatan', true);
      }else{
        data.append('edit-catatan', true);
      }
      const pro = new XMLHttpRequest();
      pro.open('post', 'pro.php', true);
      pro.onloadstart = function(){
        ani_show();
      };
      pro.onreadystatechange = function(){
        if(this.readyState === 4 && this.status === 200){
          const res = JSON.parse(this.responseText);
          ani_hide();
          if(res.oke === true){
            modal_hide(qsa('.modal')[0]);
            alertBox({
              title: res.title,
              text: res.text,
              icon: res.icon,
              oke: res.btn,
            });
            next = () => {
              window.location.reload();
            }
          }else if(res.not === true){
            alertBox({
              title: res.title,
              text: res.text,
              icon: res.icon,
              not: res.btn,
            });
            return false;
          }else if(res.not_judul === true){
            judul.focus();
            err[0].innerText = res.msg;
            return false;
          }
        }
      };
      pro.send(data);
    }
  }
  
  batal.onclick = () => {
    form.reset();
    for(let i = 0; i < err.length; i++){
      err[i].innerText = '';
    }
  }
}

if(qs('#cacat') != null){
  const cacat = qs('#cacat'),
  redacat = qs('#redacat');
  cacat.oninput = () => {
    const data = new FormData();
    data.append('cacat', cacat.value);
    data.append('cari-catatan', true);
    const pro = new XMLHttpRequest();
    pro.open('post', 'pro.php', true);
    pro.onreadystatechange = function(){
      if(this.readyState === 4 && this.status === 200){
        redacat.innerHTML = this.responseText;
        if(qs('#btnEditCatatan') != null){
          const btn = qsa('#btnEditCatatan');
          for(let i = 0; i < btn.length; i++){
            btn[i].onclick = () => {
              qs('#forcat').setAttribute('data-target', btn[i].getAttribute('data-target'));
              qs('#forcat h5').innerText = 'Edit Catatan';
              qs('#forcat #judul').value = btn[i].getAttribute('data-judul');
              qs('#forcat #catatan').value = btn[i].getAttribute('data-catatan').replaceAll('<br>', '');
              qs('#forcat button[type=submit]').innerText = 'Perbarui';
            }
          }
        }
        if(qs('#btnHapusCatatan') != null){
          const btn = qsa('#btnHapusCatatan');
          for(let i = 0; i < btn.length; i++){
            btn[i].onclick = () => {
              const target = btn[i].getAttribute('data-target'),
              judul = btn[i].getAttribute('data-judul');
              alertBox({
                title: 'Konfirmasi',
                text: `Hapus <b>${judul}</b> ?`,
                not: 'Batal',
                oke: 'Hapus',
              });
              next = () => {
                const data = new FormData();
                data.append('target', target);
                data.append('hapus-catatan', true);
                const pro = new XMLHttpRequest();
                pro.open('post', 'pro.php', true);
                pro.onloadstart = function(){
                  ani_show();
                };
                pro.onreadystatechange = function(){
                  if(this.readyState === 4 && this.status === 200){
                    const res = JSON.parse(this.responseText);
                    ani_hide();
                    if(res.oke === true){
                      alertBox({
                        title: res.title,
                        text: res.text,
                        icon: res.icon,
                        oke: res.btn,
                      });
                      next = () => {
                        window.location.reload();
                      }
                    }else if(res.not === true){
                      alertBox({
                        title: res.title,
                        text: res.text,
                        icon: res.icon,
                        not: res.btn,
                      });
                      return false;
                    }
                  }
                };
                pro.send(data);
              }
            }
          }
        }
      }
    };
    pro.send(data);
  }
}

if(qs('#btnOmset') != null){
  qs('#btnOmset').onclick = (e) => {
    e.preventDefault();
    qs('#omsetForm').setAttribute('data-push', 'input-omset');
    qs('#omsetForm h5').innerText = 'Tambah Omset';
    setTimeout(function(){
      qs('#omsetForm #omset').focus();
    },500);
  }
}

if(qs('#omsetForm') != null){
  const form = qs('#omsetForm'),
  omset = qs('#omsetForm #omset'),
  tanggal = qs('#omsetForm #tanggal'),
  err = qsa('#omsetForm .err'),
  batal = qs('#omsetForm #batal');
  omset.oninput = () => {
    omset.value = fornum(omset.value);
  }
  form.onsubmit = (e) => {
    e.preventDefault();
    const input_push = form.getAttribute('data-push'),
    dataId = form.getAttribute('data-id');
    for(let i = 0; i < err.length; i++){
      err[i].innerText = '';
    }
    if(omset.value == ''){
      omset.focus();
      err[0].innerText = 'Masukkan omset!';
      return false;
    }else if(input_push != 'edit-omset' && tanggal.value == ''){
      tanggal.focus();
      err[1].innerText = 'Pilih tanggal!';
      return false;
    }else{
      const data = new FormData();
      if(input_push == 'edit-omset'){
        data.append('id', dataId);
      }
      data.append('omset', omset.value);
      data.append('tanggal', tanggal.value);
      data.append(input_push, true);
      const pro = new XMLHttpRequest();
      pro.open('post', 'pro.php', true);
      pro.onloadstart = function(){
        ani_show();
      };
      pro.onreadystatechange = function(){
        if(this.readyState === 4 && this.status === 200){
          const res = JSON.parse(this.responseText);
          ani_hide();
          if(res.oke === true){
            modal_hide(qsa('.modal')[0]);
            alertBox({
              title: res.title,
              text: res.text,
              icon: res.icon,
              oke: res.btn,
            });
            next = () => {
              window.location.reload();
            }
          }else if(res.not === true){
            alertBox({
              title: res.title,
              text: res.text,
              icon: res.icon,
              not: res.btn,
            });
            return false;
          }
        }
      };
      pro.send(data);
    }
  }
  batal.onclick = () => {
    form.reset();
    for(let i = 0; i < err.length; i++){
      err[i].innerText = '';
    }
  }
}

if(qs('#btnKeluar') != null){
  qs('#btnKeluar').onclick = (e) => {
    e.preventDefault();
    qs('#kemasForm').setAttribute('data-target', '');
    qs('#kemasForm').setAttribute('data-push', 'input-keluar');
    qs('#kemasForm h5').innerText = 'Input Keluar';
    setTimeout(function(){
      qs('#kemasForm #nama').focus();
    },500);
  }
}

if(qs('#btnMasuk') != null){
  const btn = qsa('#btnMasuk');
  for(let i = 0; i < btn.length; i++){
    btn[i].onclick = (e) => {
      e.preventDefault();
      qs('#kemasForm').setAttribute('data-target', btn[i].getAttribute('data-target'));
      qs('#kemasForm').setAttribute('data-push', 'input-masuk');
      qs('#kemasForm h5').innerText = 'Input Masuk';
      setTimeout(function(){
        qs('#kemasForm #nama').focus();
      },500);
    }
  }
}

if(qs('#kemasForm') != null){
  const form = qs('#kemasForm'),
  nama = qs('#kemasForm #nama'),
  jumlah = qs('#kemasForm #jumlah'),
  keterangan = qs('#kemasForm #keterangan'),
  tanggal = qs('#kemasForm #tanggal'),
  err = qsa('#kemasForm .err'),
  batal = qs('#kemasForm #batal');
  nama.oninput = () => {
    nama.value = ucfirst(nama.value);
  }
  jumlah.oninput = () => {
    jumlah.value = fornum(jumlah.value);
  }
  form.onsubmit = (e) => {
    e.preventDefault();
    for(let i = 0; i < err.length; i++){
      err[i].innerText = '';
    }
    if(nama.value == ''){
      nama.focus();
      err[0].innerText = 'Masukkan nama!';
      return false;
    }else if(nama.value.length > 50){
      nama.focus();
      err[0].innerText = 'Maksimal 50 karakter!';
      return false;
    }else if(jumlah.value == ''){
      jumlah.focus();
      err[1].innerText = 'Masukkan jumlah!';
      return false;
    }else if(keterangan.value == ''){
      keterangan.focus();
      err[2].innerText = 'Masukkan keterangan';
      return false;
    }else if(tanggal.value == ''){
      tanggal.focus();
      err[3].innerText = 'Pilih tanggal!';
      return false;
    }else{
      const input_push = form.getAttribute('data-push'),
      data_id = form.getAttribute('data-target');
      const data = new FormData();
      data.append('id', data_id);
      data.append('nama', nama.value);
      data.append('jumlah', jumlah.value);
      data.append('keterangan', keterangan.value);
      data.append('tanggal', tanggal.value);
      data.append(input_push, true);
      const pro = new XMLHttpRequest();
      pro.open('post', 'pro.php', true);
      pro.onloadstart = function(){
        ani_show();
      };
      pro.onreadystatechange = function(){
        if(this.readyState === 4 && this.status === 200){
          const res = JSON.parse(this.responseText);
          ani_hide();
          if(res.oke === true){
            modal_hide(qsa('.modal')[1]);
            alertBox({
              title: res.title,
              text: res.text,
              icon: res.icon,
              oke: res.btn,
            });
            next = () => {
              window.location.reload();
            }
          }else if(res.not === true){
            alertBox({
              title: res.title,
              text: res.text,
              icon: res.icon,
              not: res.btn,
            });
            return false;
          }
        }
      };
      pro.send(data);
    }
  }
  batal.onclick = () => {
    form.reset();
    for(let i = 0; i < err.length; i++){
      err[i].innerText = '';
    }
  }
}

if(qs('#btn_edoms') != null){
  const btn = qsa('#btn_edoms');
  for(let i = 0; i < btn.length; i++){
    btn[i].onclick = () => {
      const dataId = btn[i].getAttribute('data-id'),
      dataOmset = btn[i].getAttribute('data-omset'),
      dataTanggal = btn[i].getAttribute('data-tanggal'),
      form = qs('#omsetForm'),
      title = qs('#omsetForm h5'),
      omset = qs('#omsetForm #omset'),
      tanggal = qs('#omsetForm #tanggal');
      form.setAttribute('data-id', dataId);
      form.setAttribute('data-push', 'edit-omset');
      title.innerText = 'Edit Omset';
      omset.value = dataOmset;
      tanggal.value = dataTanggal;
    }
  }
}

if(qs('#btn_haoms') != null){
  const btn = qsa('#btn_haoms');
  for(let i = 0; i < btn.length; i++){
    btn[i].onclick = () => {
      alertBox({
        title: 'Konfirmasi',
        text: 'Ingin dihapus?',
        icon: 'warning',
        not: 'Batal',
        oke: 'Hapus',
      });
      next = () => {
        const data = new FormData();
        data.append('id', dataId = btn[i].getAttribute('data-id'));
        data.append('hapus-omset', true);
        const pro = new XMLHttpRequest();
        pro.open('post', 'pro.php', true);
        pro.onloadstart = function(){
          ani_show();
        };
        pro.onreadystatechange = function(){
          if(this.readyState === 4 && this.status === 200){
            const res = JSON.parse(this.responseText);
            ani_hide();
            if(res.oke === true){
              alertBox({
                title: res.title,
                text: res.text,
                icon: res.icon,
                oke: res.btn,
              });
              next = () => {
                window.location.reload();
              }
            }else if(res.not === true){
              alertBox({
                title: res.title,
                text: res.text,
                icon: res.icon,
                not: res.btn,
              });
              return false;
            }
          }
        };
        pro.send(data);
      }
    }
  }
}

if(qs('#btn_detail_kemas') != null){
  const btn = qsa('#btn_detail_kemas');
  for(let i = 0; i < btn.length; i++){
    btn[i].onclick = () => {
      const data_push = btn[i].getAttribute('data-push'),
      data_id = btn[i].getAttribute('data-id');
      const data = new FormData();
      data.append('id', data_id);
      data.append(data_push, true);
      const pro = new XMLHttpRequest();
      pro.open('post', 'pro.php', true);
      pro.onloadstart = function(){
        ani_show();
      };
      pro.onreadystatechange = function(){
        if(this.readyState === 4 && this.status === 200){
          const res = JSON.parse(this.responseText);
          ani_hide();
          if(res.oke === true){
            alertBox({
              title: res.title,
              text: res.text,
              icon: res.icon,
              not: res.btn,
            });
          }
        }
      };
      pro.send(data);
    }
  }
}

if(qs('#btn_edit_kemas') != null){
  const btn = qsa('#btn_edit_kemas');
  for(let i = 0; i < btn.length; i++){
    btn[i].onclick = () => {
      const data_push = btn[i].getAttribute('data-push'),
      data_id = btn[i].getAttribute('data-id'),
      form = qs('#kemasForm'),
      title = qs('#kemasForm h5'),
      nama = qs('#kemasForm #nama'),
      jumlah = qs('#kemasForm #jumlah'),
      keterangan = qs('#kemasForm #keterangan'),
      tanggal = qs('#kemasForm #tanggal');
      if(data_push == 'edit-keluar'){
        title.innerText = 'Edit Data Keluar';
      }else{
        title.innerText = 'Edit Data Masuk';
      }
      form.setAttribute('data-target', data_id);
      form.setAttribute('data-push', data_push);
      const data = new FormData();
      data.append('data-target', data_id);
      data.append('data-push', data_push);
      data.append('load-kemas', true);
      const pro = new XMLHttpRequest();
      pro.open('post', 'pro.php', true);
      pro.onreadystatechange = function(){
        if(this.readyState === 4 && this.status === 200){
          const res = JSON.parse(this.responseText);
          if(res.oke === true){
            nama.value = res.nama;
            jumlah.value = res.jumlah;
            keterangan.value = res.keterangan;
            tanggal.value = res.tanggal;
          }
        }
      };
      pro.send(data);
    }
  }
}

if(qs('#btn_hapus_kemas') != null){
  const btn = qsa('#btn_hapus_kemas');
  for(let i = 0; i < btn.length; i++){
    btn[i].onclick = () => {
      const data_push = btn[i].getAttribute('data-push'),
      data_id = btn[i].getAttribute('data-id');
      let daha;
      if(data_push == 'hapus-keluar'){
        daha = 'keluar';
      }else{
        daha = 'masuk';
      }
      alertBox({
        title: 'Konfirmasi',
        text: `Hapus data ${daha} ?`,
        icon: 'warning',
        oke: 'Hapus',
        not: 'Batal',
      });
      next = () => {
        const data = new FormData();
        data.append('id', data_id);
        data.append(data_push, true);
        const pro = new XMLHttpRequest();
        pro.open('post', 'pro.php', true);
        pro.onloadstart = function(){
          ani_show();
        };
        pro.onreadystatechange = function(){
          if(this.readyState === 4 && this.status === 200){
            const res = JSON.parse(this.responseText);
            ani_hide();
            if(res.oke === true){
              alertBox({
                title: res.title,
                text: res.text,
                icon: res.icon,
                oke: res.btn,
              });
              next = () => {
                window.location.reload();
              }
            }else if(res.not === true){
              alertBox({
                title: res.title,
                text: res.text,
                icon: res.icon,
                not: res.btn,
              });
              return false;
            }
          }
        };
        pro.send(data);
      }
    }
  }
}

if(qs('#btnTanggal') != null){
  const btn = qs('#btnTanggal');
  btn.onclick = (e) => {
    e.preventDefault();
    let dlb = btn.getAttribute('data-ls-bulan').split(','),
    dlt = btn.getAttribute('data-ls-tahun').split(','),
    data_ls_bulan,
    data_ls_tahun;
    for(let i = 0; i < dlb.length; i++){
      data_ls_bulan += `<option value="${dlb[i]}">${ucfirst(dlb[i])}</option>`;
    }
    for(let i = 0; i < dlt.length; i++){
      data_ls_tahun += `<option value="${dlt[i]}">${dlt[i]}</option>`;
    }
    alertBox({
      title: 'Sortir Omset',
      text: `
        <form id="sortir">
          <div class="row">
            <div class="col-5">
              <select id="bulan" class="form-control text-center">
                <option selected="" value="">Bulan</option>
                ${data_ls_bulan}
              </select>
            </div>
            <div class="col-4">
              <select id="tahun" class="form-control text-center">
                <option selected="" value="">Tahun</option>
                ${data_ls_tahun}
              </select>
            </div>
            <div class="col-3">
              <button type="submit" class="btn text-bg-info"><i class="fas fa-angle-right"></i></button>
            </div>
            <div class="err text-center"></div>
          </div>
        </form>
      `,
      not: 'Tutup',
    });
    if(qs('#sortir') != null){
      const form = qs('#sortir'),
      bulan = qs('#sortir #bulan'),
      tahun = qs('#sortir #tahun'),
      err = qs('#sortir .err');
      form.onsubmit = (e) => {
        e.preventDefault();
        err.innerText = '';
        if(bulan.value == '' || tahun.value == ''){
          err.innerText = 'Harap pilih bulan dan tahun!';
          return false;
        }else{
          window.location.href = `?pg=omha&bulan=${bulan.value}&tahun=${tahun.value}`;
        }
      }
    }
  }
}

if(qs('input') != null || qs('textarea')){
  const input = qsa('input'),
  textarea = qsa('textarea');
  for(let i = 0; i < input.length; i++){
    input[i].onfocus = () => {
      qs('.btnreload').classList.add('hide');
    }
    input[i].onblur = () => {
      qs('.btnreload').classList.remove('hide');
    }
  }
  for(let i = 0; i < textarea.length; i++){
    textarea[i].onfocus = () => {
      qs('.btnreload').classList.add('hide');
    }
    textarea[i].onblur = () => {
      qs('.btnreload').classList.remove('hide');
    }
  }
}

function ucfirst(x){
 const arr = x.split(' ');
  for(let i = 0; i < arr.length; i++){
    if(!(arr[i].match(/[a-zA-Z]/))){
      arr[i] = fornum(arr[i]);
    }else{
      arr[i] = arr[i].charAt(0).toUpperCase() + arr[i].slice(1);
    }
  }
  return arr.join(' ');
}

function fornum(num, pre){
  let nums = num.replace(/[^,\d]/g, '').toString(),
  spl = nums.split(','),
  rmd = spl[0].length % 3,
  rph = spl[0].substr(0, rmd),
  ths = spl[0].substr(rmd).match(/\d{3}/gi);
  if(ths){
    spt = rmd ? '.' : '';
    rph += spt + ths.join('.');
  }
  rph = spl[1] != undefined ? rph + ',' + spl[1] : rph;
  return pre == undefined ? rph : (rph ? 'Rp. ' + rph : '');
}

});