$(function(){var i="dark";function o(e){layer.msg(e,{time:2500,icon:1,offset:"100px"})}var e={view:{addHoverDom:function(e,d){if(!d.pId){var t=$("#"+d.tId+"_span");if(!(d.editNameFlag||0<$("#addBtn_"+d.tId).length)){var n="<span class='button add' id='addBtn_"+d.tId+"' title='add node' onfocus='this.blur();'></span>";t.after(n);var i=$("#addBtn_"+d.tId);i&&i.bind("click",function(){var t=$.fn.zTree.getZTreeObj("pointTree"),e=d?d.id:0,n=0;return void 0!==d.children&&0<d.children.length&&(n=parseInt(d.children[d.children.length-1].fsort)+1),$.post(doaddUrl,{pid:e,fsort:n},function(e){"200"==e.statusCode?(d=d?t.addNodes(d,{id:e.result.id,pId:d.id,name:e.result.title}):t.addNodes(null,{id:e.result.id,pId:0,name:e.result.title}))&&t.editName(d[0]):o("网络请求失败!")},"json"),!1})}}},removeHoverDom:function(e,t){$("#addBtn_"+t.tId).unbind().remove()},selectedMulti:!1},edit:{enable:!0,editNameSelectAll:!0,showRemoveBtn:function(e,t){return!t.children},showRenameBtn:!0},data:{simpleData:{enable:!0}},callback:{beforeDrag:function(e,t){return!1},beforeEditName:function(e,t){i="dark"===i?"":"dark";var n=$.fn.zTree.getZTreeObj("pointTree");return n.selectNode(t),setTimeout(function(){n.editName(t)}),!1},beforeRemove:function(e,t){return i="dark"===i?"":"dark",$.fn.zTree.getZTreeObj("pointTree").selectNode(t),confirm("确认要删除 '"+t.name+"' ?")},beforeRename:function(e,t,n,d){return i="dark"===i?"":"dark",0!=n.length||(setTimeout(function(){$.fn.zTree.getZTreeObj("pointTree").cancelEditName(),o("知识点不能为空!")},0),!1)},onRemove:function(e,t,n){var d=n.id;$.post(dodelUrl,{id:d},function(e){o(e.message.msg)},"json")},onRename:function(e,t,n,d){var i=n.id,r=n.name;$.post(doeditUrl,{id:i,name:r},function(e){o(e.message.msg)},"json")}}};$.fn.zTree.init($("#pointTree"),e,zNodes),$("#selectAll").bind("click",function(){$.fn.zTree.getZTreeObj("pointTree").setting.edit.editNameSelectAll=$("#selectAll").attr("checked")}),$("#addParent").bind("click",{isParent:!0},function(e){var n=$.fn.zTree.getZTreeObj("pointTree");$.post(doaddUrl,{pid:0,fsort:0},function(e){if("200"==e.statusCode){var t=n.addNodes(null,{id:e.result.id,pId:0,name:e.result.title});t&&n.editName(t)}else o("网络请求失败!")},"json")})});