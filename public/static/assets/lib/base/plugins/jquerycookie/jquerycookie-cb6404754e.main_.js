$.Cookie=function(e,o,n){if(void 0===o){var t=null;if(document.cookie&&""!=document.cookie)for(var i=document.cookie.split(";"),r=0;r<i.length;r++){var c=jQuery.trim(i[r]);if(c.substring(0,e.length+1)==e+"="){t=decodeURIComponent(c.substring(e.length+1));break}}return t}n=n||{},null===o&&(o="",n.expires=-1);var s,p="";n.expires&&("number"==typeof n.expires||n.expires.toUTCString)&&("number"==typeof n.expires?(s=new Date).setTime(s.getTime()+24*n.expires*60*60*1e3):s=n.expires,p="; expires="+s.toUTCString());var a=n.path?"; path="+n.path:"",u=n.domain?"; domain="+n.domain:"",d=n.secure?"; secure":"";document.cookie=[e,"=",encodeURIComponent(o),p,a,u,d].join("")},function(e){if("function"==typeof define&&define.amd)define(e);else if("object"==typeof exports)module.exports=e();else{var o=window.Cookies,n=window.Cookies=e();n.noConflict=function(){return window.Cookies=o,n}}}(function(){function l(){for(var e=0,o={};e<arguments.length;e++){var n=arguments[e];for(var t in n)o[t]=n[t]}return o}return function e(d){function f(e,o,n){var t;if(1<arguments.length){if("number"==typeof(n=l({path:"/"},f.defaults,n)).expires){var i=new Date;i.setMilliseconds(i.getMilliseconds()+864e5*n.expires),n.expires=i}try{t=JSON.stringify(o),/^[\{\[]/.test(t)&&(o=t)}catch(e){}return o=(o=encodeURIComponent(String(o))).replace(/%(23|24|26|2B|3A|3C|3E|3D|2F|3F|40|5B|5D|5E|60|7B|7D|7C)/g,decodeURIComponent),e=(e=(e=encodeURIComponent(String(e))).replace(/%(23|24|26|2B|5E|60|7C)/g,decodeURIComponent)).replace(/[\(\)]/g,escape),document.cookie=[e,"=",o,n.expires&&"; expires="+n.expires.toUTCString(),n.path&&"; path="+n.path,n.domain&&"; domain="+n.domain,n.secure?"; secure":""].join("")}e||(t={});for(var r=document.cookie?document.cookie.split("; "):[],c=/(%[0-9A-Z]{2})+/g,s=0;s<r.length;s++){var p=r[s].split("="),a=p[0].replace(c,decodeURIComponent),u=p.slice(1).join("=");'"'===u.charAt(0)&&(u=u.slice(1,-1));try{if(u=d&&d(u,a)||u.replace(c,decodeURIComponent),this.json)try{u=JSON.parse(u)}catch(e){}if(e===a){t=u;break}e||(t[a]=u)}catch(e){}}return t}return f.get=f.set=f,f.getJSON=function(){return f.apply({json:!0},[].slice.call(arguments))},f.defaults={},f.remove=function(e,o){f(e,"",l(o,{expires:-1}))},f.withConverter=e,f}()});