//tealium universal tag - utag.14 ut4.0.202103310811, Copyright 2021 Tealium.com Inc. All Rights Reserved.
var _uxa=_uxa||[];try{(function(id,loader){var u={};utag.o[loader].sender[id]=u;if(utag.ut===undefined){utag.ut={};}
if(utag.ut.loader===undefined){u.loader=function(o){var b,c,l,a=document;if(o.type==="iframe"){b=a.createElement("iframe");o.attrs=o.attrs||{"height":"1","width":"1","style":"display:none"};for(l in utag.loader.GV(o.attrs)){b.setAttribute(l,o.attrs[l]);}b.setAttribute("src",o.src);}else if(o.type=="img"){utag.DB("Attach img: "+o.src);b=new Image();b.src=o.src;return;}else{b=a.createElement("script");b.language="javascript";b.type="text/javascript";b.async=1;b.charset="utf-8";for(l in utag.loader.GV(o.attrs)){b[l]=o.attrs[l];}b.src=o.src;}if(o.id){b.id=o.id};if(typeof o.cb=="function"){if(b.addEventListener){b.addEventListener("load",function(){o.cb()},false);}else{b.onreadystatechange=function(){if(this.readyState=='complete'||this.readyState=='loaded'){this.onreadystatechange=null;o.cb()}};}}l=o.loc||"head";c=a.getElementsByTagName(l)[0];if(c){utag.DB("Attach to "+l+": "+o.src);if(l=="script"){c.parentNode.insertBefore(b,c);}else{c.appendChild(b)}}}}else{u.loader=utag.ut.loader;}
if(utag.ut.typeOf===undefined){u.typeOf=function(e){return({}).toString.call(e).match(/\s([a-zA-Z]+)/)[1].toLowerCase();};}else{u.typeOf=utag.ut.typeOf;}
u.ev={"view":1,"link":1};u.scriptrequested=false;u.map={};u.extend=[];u.send=function(a,b){if(u.ev[a]||u.ev.all!==undefined){utag.DB("send:14");utag.DB(b);var c,d,e,f,udh_collection=[];u.data={"base_url":"//t.contentsquare.net/uxa/##utag_id_project##.js","id_project":"0da783df891e1","custom":{},"path":"","product_id":[],"product_name":[],"product_sku":[],"product_category":[],"product_quantity":[],"product_unit_price":[],"send_udh_audiences":"false","send_udh_data":{}};utag.DB("send:14:EXTENSIONS");utag.DB(b);c=[];for(d in utag.loader.GV(u.map)){if(b[d]!==undefined&&b[d]!==""){e=u.map[d].split(",");for(f=0;f<e.length;f++){if(e[f].indexOf("custom.")===0){u.data.custom[[e[f].substr(7)]]=b[d];}else if(e[f].indexOf("send_udh_data.")===0||e[f].indexOf("send_data.")===0){u.data.send_udh_data[d]=e[f].split(".")[1];}else if(e[f]==="send_audiences"){u.data.send_udh_audiences=b[d];}else{u.data[e[f]]=b[d];}}}}
utag.DB("send:14:MAPPINGS");utag.DB(u.data);u.data.order_id=u.data.order_id||b._corder||"";u.data.order_total=u.data.order_total||b._ctotal||"";u.data.order_shipping=u.data.order_shipping||b._cship||"";u.data.order_tax=u.data.order_tax||b._ctax||"";if(u.data.product_id.length===0&&b._cprod!==undefined){u.data.product_id=b._cprod.slice(0);}
if(u.data.product_name.length===0&&b._cprodname!==undefined){u.data.product_name=b._cprodname.slice(0);}
if(u.data.product_sku.length===0&&b._csku!==undefined){u.data.product_sku=b._csku.slice(0);}
if(u.data.product_category.length===0&&b._ccat!==undefined){u.data.product_category=b._ccat.slice(0);}
if(u.data.product_quantity.length===0&&b._cquan!==undefined){u.data.product_quantity=b._cquan.slice(0);}
if(u.data.product_unit_price.length===0&&b._cprice!==undefined){u.data.product_unit_price=b._cprice.slice(0);}
u.data.base_url=u.data.base_url.replace("##utag_id_project##",u.data.id_project);u.data.path=u.data.path||location.pathname+location.hash.replace("#","?__");var custom,customVar;for(custom in u.data.custom){if(u.data.custom.hasOwnProperty(custom)&&custom!==""){customVar=custom.split(".");_uxa.push(["setCustomVariable",customVar[0],customVar[1],u.data.custom[custom],3]);}}
if(u.data.send_udh_audiences==="true"||u.data.send_udh_audiences===true){Object.keys(b).forEach(function(key){if(key.indexOf("va.audiences.")===0){_uxa.push(["trackDynamicVariable",{"key":"Tealium Audience "+key.substr(key.lastIndexOf("_")+1),"value":b[key]}]);}});}
Object.keys(u.data.send_udh_data).forEach(function(key){_uxa.push(["trackDynamicVariable",{"key":"Tealium Badge "+key.substr(key.lastIndexOf(".")+1),"value":u.data.send_udh_data[key]}]);});if(a==="view"){_uxa.push(["trackPageview",u.data.path]);}else{_uxa.push(["setPath",u.data.path]);}
if(u.data.order_id&&u.data.order_total){_uxa.push(["ecommerce:addTransaction",{"id":u.data.order_id,"revenue":u.data.order_total,"shipping":u.data.order_shipping,"tax":u.data.order_tax}]);for(f=0;f<u.data.product_id.length;f++){if(u.data.product_name[f]&&u.data.product_sku[f]&&!isNaN(parseFloat(u.data.product_unit_price[f]))&&!isNaN(parseFloat(u.data.product_quantity[f]))){_uxa.push(["ecommerce:addItem",{"id":u.data.order_id,"name":u.data.product_name[f],"sku":u.data.product_sku[f],"category":u.data.product_category[f],"price":u.data.product_unit_price[f],"quantity":u.data.product_quantity[f]}]);}else{utag.DB(u.id+" (ContentSquare): Item not tracked in transaction: Required attribute(s) not populated");}}
_uxa.push(["ecommerce:send"]);}else{utag.DB(u.id+" (ContentSquare): Transaction not tracked: Required attribute(s) not populated");}
if(!u.scriptrequested){u.scriptrequested=true;u.loader({"type":"script","src":u.data.base_url,"cb":null,"loc":"script","id":"utag_14"});}
utag.DB("send:14:COMPLETE");}};utag.o[loader].loader.LOAD(id);}("14","sisalpay.sisalpay"));}catch(error){utag.DB(error);}
