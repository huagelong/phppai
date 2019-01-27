$(function(){
    var jcrop_api = null,boundx, boundy,imgurl,
        $preview = $('#preview'),
        $previewContainer = $(".preview-container");
    $('#uploadimg').ajaxfileupload({
        action: upyunurl,
        valid_extensions: ['png','gif', 'jpg', 'jpeg'],
        params: {
            code: 'face'
        },
        onComplete: function(response) {
            if(response.statusCode=='200'){
                imgurl = response.result[1];
                $("#myface").attr('src', imgurl);
                $preview.attr('src', imgurl);

                $('#myface').Jcrop({
                    setSelect: [20, 20, 150, 150],
                    aspectRatio: 1,
                    onChange: showPreview,
                    onSelect: showPreview,
                    onRelease: hidePreview,
                    bgColor:"#fff",
                    bgOpacity:.4,
                    minSize:[100,100],
                    boxWidth:300,
                    boxHeght:300,
                }, function() {
                    jcrop_api = this;
                });
                $previewContainer.removeClass('hide');
                $previewContainer.show();
            }
        },
        onStart: function() {

        },
        onCancel: function() {
        }
    });



    function showPreview(coords)
    {
        // console.log(coords);
        if (jcrop_api) {
            var bounds = jcrop_api.getBounds();
            boundx = bounds[0];
            boundy = bounds[1];
        }

        // 设置预览
        if (parseInt(coords.w) > 0)
        {
            var rx = 150 / coords.w;
            var ry = 150 / coords.h;
            $preview.css({
                width: Math.round(rx * boundx) + 'px',
                height: Math.round(ry * boundy) + 'px',
                marginLeft: '-' + Math.round(rx * coords.x) + 'px',
                marginTop: '-' + Math.round(ry * coords.y) + 'px'
            }).show();
        }
        // 赋值
        $("#x").val(coords.x);
        $("#y").val(coords.y);
        $("#w").val(coords.w);
        $("#h").val(coords.h);
        $("#yunurl").val(imgurl);
    }

    function hidePreview()
    {
        $preview.stop().fadeOut('fast');
    }

});