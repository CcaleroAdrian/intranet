function MM_swapImgRestore(){var e,r,t=document.MM_sr;for(e=0;t&&e<t.length&&(r=t[e])&&r.oSrc;e++)r.src=r.oSrc}function MM_preloadImages(){var e=document;if(e.images){e.MM_p||(e.MM_p=new Array);var r,t=e.MM_p.length,n=MM_preloadImages.arguments;for(r=0;r<n.length;r++)0!=n[r].indexOf("#")&&(e.MM_p[t]=new Image,e.MM_p[t++].src=n[r])}}function MM_findObj(e,r){var t,n,a;for(r||(r=document),(t=e.indexOf("?"))>0&&parent.frames.length&&(r=parent.frames[e.substring(t+1)].document,e=e.substring(0,t)),!(a=r[e])&&r.all&&(a=r.all[e]),n=0;!a&&n<r.forms.length;n++)a=r.forms[n][e];for(n=0;!a&&r.layers&&n<r.layers.length;n++)a=MM_findObj(e,r.layers[n].document);return!a&&r.getElementById&&(a=r.getElementById(e)),a}function MM_swapImage(){var e,r,t=0,n=MM_swapImage.arguments;for(document.MM_sr=new Array,e=0;e<n.length-2;e+=3)null!=(r=MM_findObj(n[e]))&&(document.MM_sr[t++]=r,r.oSrc||(r.oSrc=r.src),r.src=n[e+2])}function getFechaHoy(){var e=new Date,r=e.getYear();1e3>r&&(r+=1900);var t=e.getDay(),n=e.getMonth(),a=e.getDate();10>a&&(a="0"+a);var o=new Array("Domingo","Lunes","Martes","Mi&eacute;rcoles","Jueves","Viernes","S&aacute;bado"),l=new Array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"),u=" "+o[t]+" "+a+" de "+l[n]+" de "+r+" ";return u}function validarPasswd(){var e=document.getElementById("clave1").value;document.getElementById("clave2").value;return alert(e),!1}function pwdMD5(e){var r=calcMD5(e);document.getElementById("pwditw").value=r,alert(document.getElementById("pwditw").value)}function validarFecha(e){patron=/^\d{4}\/\d{2}\/\d{2}$/,alert(patron.test(e.value))}