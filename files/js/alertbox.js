function alertBox(data){
  let dataIcon, active = 'active', div = 'div', button = 'button';
  if(data.icon != undefined){
    if(data.icon == 'success'){
      dataIcon = 'fa-check';
    }else if(data.icon == 'warning'){
      dataIcon = 'fa-exclamation';
    }else if(data.icon = 'failed'){
      dataIcon = 'fa-xmark';
    }
  }
  const alert_box = document.createElement(div);
  alert_box.classList.add('alert-box');
  alert_box.classList.add(active);
  const box = document.createElement(div);
  box.classList.add('box');
  if(data.title != undefined || data.icon != undefined){
    const alert_header = document.createElement(div);
    alert_header.classList.add('alert-header');
    if(data.title != undefined){
      const alert_title = document.createElement('h5');
      alert_title.classList.add('alert-title');
      const text_title = document.createTextNode(data.title);
      alert_title.appendChild(text_title);
      alert_header.appendChild(alert_title);
    }
    if(data.icon != undefined){
      const alert_icon = document.createElement(div);
      alert_icon.classList.add('alert-icon', data.icon);
      const vicon = document.createElement('i');
      vicon.classList.add('fas', dataIcon);
      alert_icon.appendChild(vicon);
      alert_header.appendChild(alert_icon);
    }
    box.appendChild(alert_header);
  }
  if(data.text != undefined){
    const alert_body = document.createElement(div);
    alert_body.classList.add('alert-body');
    alert_body.innerHTML = data.text;
    box.appendChild(alert_body);
  }
  if(data.not != undefined || data.oke != undefined){
    const alert_footer = document.createElement(div);
    alert_footer.classList.add('alert-footer');
    if(data.not != undefined){
      const btn_not = document.createElement(button);
      btn_not.type = button;
      btn_not.classList.add('btn-not');
      const text_btn_not = document.createTextNode(data.not);
      btn_not.appendChild(text_btn_not);
      alert_footer.appendChild(btn_not);
      btn_not.onclick = () => {
        qs('body').removeChild(alert_box);
      }
    }
    if(data.oke != undefined){
      const btn_oke = document.createElement(button);
      btn_oke.type = button;
      btn_oke.classList.add('btn-oke');
      const text_btn_oke = document.createTextNode(data.oke);
      btn_oke.appendChild(text_btn_oke);
      alert_footer.appendChild(btn_oke);
      btn_oke.onclick = () => {
        qs('body').removeChild(alert_box);
        next();
      }
    }
    box.appendChild(alert_footer);
  }
  alert_box.appendChild(box);
  qs('body').appendChild(alert_box);
}