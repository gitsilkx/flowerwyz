(function(c){"function"===typeof define&&define.amd?define(["jquery"],c):"object"===typeof exports?c(require("jquery")):c(jQuery)})(function(c){var e,i,l=1,f,g=this,j,k=g.postMessage&&!/opera/.test(navigator.userAgent.toLowerCase());c.postMessage=function(b,a,d){if(a)if(b="string"===typeof b?b:c.param(b),d=d||parent,k)d.postMessage(b,a.replace(/([^:]+:\/\/[^\/]+).*/,"$1"));else if(a)d.location=a.replace(/#.*$/,"")+"#"+ +new Date+l++ +"&"+b};c.receiveMessage=j=function(b,a,d){if(k)if(b&&(f&&j(),f=
function(h){if("string"===typeof a&&h.origin!==a||c.isFunction(a)&&!1===a(h.origin))return!1;b(h)}),g.addEventListener)g[b?"addEventListener":"removeEventListener"]("message",f,!1);else g[b?"attachEvent":"detachEvent"]("onmessage",f);else e&&clearInterval(e),e=null,b&&(e=setInterval(function(){var a=document.location.hash,c=/^#?\d+&/;a!==i&&c.test(a)&&(i=a,b({data:a.replace(c,"")}))},"number"===typeof a?a:"number"===typeof d?d:100))}});
