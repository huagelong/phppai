$(function(){
    var log, className = "dark";
    function beforeDrag(treeId, treeNodes) {
        return false;
    }
    function beforeEditName(treeId, treeNode) {
        className = (className === "dark" ? "":"dark");
        var zTree = $.fn.zTree.getZTreeObj("pointTree");
        zTree.selectNode(treeNode);
        setTimeout(function() {
            zTree.editName(treeNode);
        })
        return false;
    }
    function beforeRemove(treeId, treeNode) {
        className = (className === "dark" ? "":"dark");
        var zTree = $.fn.zTree.getZTreeObj("pointTree");
        zTree.selectNode(treeNode);
        return confirm("确认要删除 '" + treeNode.name + "' ?");
    }

    function onRemove(e, treeId, treeNode) {
        var id = treeNode.id;
        $.post(dodelUrl,{id:id},function(data){
            showAlert(data.message.msg);
        },"json");
    }

    function beforeRename(treeId, treeNode, newName, isCancel) {
        className = (className === "dark" ? "":"dark");
        if (newName.length == 0) {
            setTimeout(function() {
                var zTree = $.fn.zTree.getZTreeObj("pointTree");
                zTree.cancelEditName();
                showAlert('知识点不能为空!');
            }, 0);
            return false;
        }
        return true;
    }

    function onRename(e, treeId, treeNode, isCancel) {
        var id = treeNode.id;
        var name = treeNode.name;

        $.post(doeditUrl,{id:id, name:name},function(data){
            showAlert(data.message.msg);
        },"json");
    }

    function showRemoveBtn(treeId, treeNode) {
        return !(treeNode.children);
    }


    function showAlert(msg){
        var icontype = 1;
        layer.msg(msg, {
            time: 2500, //2s后自动关闭
            icon: icontype,
            offset: '100px', //右下角弹出
        });
    }

    function addHoverDom(treeId, treeNode) {
        if(treeNode.pId) return;
        var sObj = $("#" + treeNode.tId + "_span");
        if (treeNode.editNameFlag || $("#addBtn_"+treeNode.tId).length>0) return;
        var addStr = "<span class='button add' id='addBtn_" + treeNode.tId
            + "' title='add node' onfocus='this.blur();'></span>";
        sObj.after(addStr);
        var btn = $("#addBtn_"+treeNode.tId);
        if (btn) btn.bind("click", function(){
            var zTree = $.fn.zTree.getZTreeObj("pointTree");
            var pid = treeNode?treeNode.id:0;
            var fsort = 0;
            if( (typeof treeNode.children !="undefined" )&& treeNode.children.length>0){
                fsort =  parseInt(treeNode.children[treeNode.children.length-1].fsort)+1;
            }
            $.post(doaddUrl,{pid:pid, fsort:fsort},function(data){
                // console.log(data);
                if(data.statusCode=="200"){
                    if (treeNode) {
                        treeNode = zTree.addNodes(treeNode, {id:data.result.id, pId:treeNode.id, name:data.result.title});
                    } else {
                        treeNode = zTree.addNodes(null, {id:data.result.id, pId:0, name:data.result.title});
                    }
                    if (treeNode) {
                        zTree.editName(treeNode[0]);
                    }
                }else{
                    showAlert('网络请求失败!');
                }

            }, 'json');
            return false;
        });
    };
    function removeHoverDom(treeId, treeNode) {
        $("#addBtn_"+treeNode.tId).unbind().remove();
    };

    function selectAll() {
        var zTree = $.fn.zTree.getZTreeObj("pointTree");
        zTree.setting.edit.editNameSelectAll =  $("#selectAll").attr("checked");
    }

    var setting = {
        view: {
            addHoverDom: addHoverDom,
            removeHoverDom: removeHoverDom,
            selectedMulti: false
        },
        edit: {
            enable: true,
            editNameSelectAll: true,
            showRemoveBtn: showRemoveBtn,
            showRenameBtn: true
        },
        data: {
            simpleData: {
                enable: true
            }
        },
        callback: {
            beforeDrag: beforeDrag,
            beforeEditName: beforeEditName,
            beforeRemove: beforeRemove,
            beforeRename: beforeRename,
            onRemove: onRemove,
            onRename: onRename
        }
    };

    $.fn.zTree.init($("#pointTree"), setting, zNodes);
    $("#selectAll").bind("click", selectAll);

    function add(e) {
        var zTree = $.fn.zTree.getZTreeObj("pointTree");
        var pid = 0;
        var fsort = 0;
        $.post(doaddUrl,{pid:pid, fsort:fsort},function(data){
            if(data.statusCode=="200"){
                var treeNode = zTree.addNodes(null, {id:data.result.id, pId:0, name:data.result.title});
                if (treeNode) {
                    zTree.editName(treeNode);
                }
            }else{
                showAlert('网络请求失败!');
            }

        }, 'json')


    };

    $("#addParent").bind("click", {isParent:true}, add);
});