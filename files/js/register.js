function dqs(x){return document.querySelector(x)}
function dce(x){return document.createElement(x)}
function dctn(x){return document.createTextNode(x)}
const body = dqs('body'),
base_uri = body.getAttribute('data-target-uri'),
div = 'div', img = 'img', h1 = 'h1', button = 'button';
let deferredPrompt;
window.addEventListener('beforeinstallprompt', (e) => {
  e.preventDefault();
  const linkIcon = dqs('link[rel=icon]'),
  frameInstall = dce(div);
  frameInstall.setAttribute('id', 'frameInstallApp');
  const boxInstall = dce(div);
  boxInstall.classList.add('box');
  const headerInstall = dce(div);
  headerInstall.classList.add('header');
  const boxHeader = dce(div);
  boxHeader.classList.add('boxit');
  const iconApp = dce(img);
  iconApp.classList.add('icon');
  iconApp.src = linkIcon.getAttribute('href');
  boxHeader.appendChild(iconApp);
  const titleLink = dce(div),
  title = dce(h1);
  title.classList.add('title');
  titleText = dctn('AppToko');
  title.appendChild(titleText);
  titleLink.appendChild(title);
  const link = dce(div);
  link.classList.add('uri');
  linkText  = dctn(body.getAttribute('data-target-host'));
  link.appendChild(linkText);
  titleLink.appendChild(link);
  boxHeader.appendChild(titleLink);
  headerInstall.appendChild(boxHeader);
  const divButton = dce(div),
  buttonInstall = dce(button);
  buttonInstall.setAttribute('type', button);
  buttonInstall.setAttribute('id', 'buttonInstallApp');
  buttonText = dctn('Instal');
  buttonInstall.appendChild(buttonText);
  divButton.appendChild(buttonInstall);
  headerInstall.appendChild(divButton);
  boxInstall.appendChild(headerInstall);
  frameInstall.appendChild(boxInstall);
  body.appendChild(frameInstall);
  deferredPrompt = e;
  setTimeout(function() {
    boxInstall.classList.add('active');
  },250);
  buttonInstall.onclick = (e) => {
    boxInstall.classList.remove('active');
    deferredPrompt.prompt();
    deferredPrompt.userChoice.then((choiceResult) => {
    if(choiceResult.outcome === 'accepted'){}else{}
    deferredPrompt = null;
    });
  }
});