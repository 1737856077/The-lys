let last = ''
function rotate(dir) {
    var cell = globalGraph.getSelectionCell();
    if (cell != null) {
        var geo = globalGraph.getCellGeometry(cell);
        if (geo != null) {
            globalGraph.getModel().beginUpdate();
            try {
                // 旋转的几何形状的大小和位置
                geogeo = geo.clone();
                geo.x += geo.width / 2 - geo.height / 2;
                geo.y += geo.height / 2 - geo.width / 2;

                console.log(geo.width, geo.height);
                var tmp = geo.width;
                geo.width = geo.height;
                geo.height = tmp;
                globalGraph.getModel().setGeometry(cell, geo);
                // 读取当前90度的方向和样式
                var state = globalGraph.view.getState(cell);
                if (state != null) {
                    if (!dir) {
                        dir = state.style[mxConstants.STYLE_DIRECTION] || 'east'/*default*/;
                    }
                    if (dir == 'east') {
                        dir = 'south';
                    }
                    else if (dir == 'south') {
                        dir = 'west';
                    }
                    else if (dir == 'west') {
                        dir = 'north';
                    }
                    else if (dir == 'north') {
                        dir = 'east';
                    }
                    globalGraph.setCellStyles(mxConstants.STYLE_DIRECTION, dir, [cell]);
                }
            }
            finally {
                globalGraph.getModel().endUpdate();
            }
        }
    }
}
//左侧点击事件
$('.left-bar-thumbnail>div').on("click", function (e, idx) {
    let currentObj = $(this)
    currentObj.siblings().removeClass("left-bar-thumbnail_active");
    currentObj.toggleClass('left-bar-thumbnail_active');
    let index = $(this).index() + 1
    let items = $(`.left-bar-detail-list .item-type-${index}`)
    items.siblings().removeClass('show');
    items.addClass('show');
})
$('.left-bar-detail-item').on("click", function (e) {
    let currentObj = $(this)
    currentObj.siblings().removeClass("active");
    currentObj.toggleClass('active');
})
$('.left-bar_open_close').on('click', function (e) {
    $(".left-container").toggleClass('close');
    $(".container-wrap").toggleClass('active');
})

function getPIC(type) {
    html2canvas(document.getElementById('container'), {
        onrendered: function (canvas) {
            document.body.appendChild(canvas);
        }
    });

}

// 获取指定的图片类型
$("#getXML").on("click", function (e) {
    showQRCode('png')
});
$("#getPNG").on("click", function (e) {
    showQRCode('png')
    console.log('getPNG@@@@@')
});

// canvas转成图片
function showQRCode(type) {
    scrollTo(0, 0);
    if (typeof html2canvas !== 'undefined') {
        //以下是对svg的处理
        var nodesToRecover = [];
        var nodesToRemove = [];
        var svgElem = $("#container").find('svg');
        svgElem.each(function (index, node) {
            var parentNode = node.parentNode;
            var svg = node.outerHTML.trim();

            var canvas = document.createElement('canvas');
            canvg(canvas, svg);
            if (node.style.position) {
                canvas.style.position += node.style.position;
                canvas.style.left += node.style.left;
                canvas.style.top += node.style.top;
            }

            nodesToRecover.push({
                parent: parentNode,
                child: node
            });
            parentNode.removeChild(node);

            nodesToRemove.push({
                parent: parentNode,
                child: canvas
            });
            parentNode.appendChild(canvas);
        });
        html2canvas(document.querySelector("#container"), {
            onrendered: function (canvas) {
                var base64Str = canvas.toDataURL(`image/png`);
                document.getElementById('graphDataPng').value=base64Str;
                //let img  = document.createElement('img')
                //img.src = base64Str
                //document.body.appendChild(img)
                //console.log(base64Str)
                // 提交表单
                document.getElementById('form1').submit();
            }
        });
    }
}

function change(val) {
    let input_value_id = val.id + '-value'
    $(`#${input_value_id}`).val(val.value * globalRatio)
    // 监听宽高变化 角度变化改变样式
    let cell = globalGraph.getSelectionCell();
    let x = cell.geometry.x;
    let y = cell.geometry.y;
    let width = cell.geometry.width
    let height = cell.geometry.height;
    let changeVal = val.value * globalRatio
    if (val.id === 'width') {
        width = changeVal
        globalGraph.resizeCell(cell, new mxRectangle(x, y, width, height), false);
    }
    if (val.id === 'height') {
        height = changeVal
        globalGraph.resizeCell(cell, new mxRectangle(x, y, width, height), false);
    }
    if (val.id === 'top1') {
        y = changeVal
        globalGraph.resizeCell(cell, new mxRectangle(x, y, width, height), false);
    }
    if (val.id === 'left') {
        x = changeVal
        globalGraph.resizeCell(cell, new mxRectangle(x, y, width, height), false);
    }
    if (val.id === 'angle') {
        let cells = globalGraph.getSelectionCells()
        let trueAngle = val.value * 3.6
        console.log(val.value * 3.6, '@@@@')
        globalGraph.setCellStyles(mxConstants.STYLE_ROTATION, trueAngle, cells);
    }
}

// input range 事件
//宽度s
$('#width').RangeSlider({min: 0, max: 100, step: 0.01, callback: change});
//高度
$('#height').RangeSlider({min: 0, max: 100, step: 0.01, callback: change});
//顶部距离
$('#top1').RangeSlider({min: 0, max: 100, step: 0.01, callback: change});
//左侧距离
$('#left').RangeSlider({min: 0, max: 100, step: 0.01, callback: change});
//角度
$('#angle').RangeSlider({min: 0, max: 100, step: 0.01, callback: change});
//模宽度
$('#area-width').RangeSlider({min: 0, max: 100, step: 0.01, callback: change});
//文本距离
$('#text-dist1').RangeSlider({min: 0, max: 100, step: 0.01, callback: change});
$('#text-dist2').RangeSlider({min: 0, max: 100, step: 0.01, callback: change});

// 保存数据格式
function save() {
    // XML
    let data = {graph: getXML(globalGraph)}
    data=JSON.stringify(data);
    // console.log(data)
    document.getElementById('templateXML').value=data;
    // 调用接口保存
    // PNG
    showQRCode('png');
    // PDF
    showPdf();

    // 提交表单
    //document.getElementById('form1').submit();
}

// 点击元素初始化右侧属性数据 width，height，top，left，angle
window.initProp = (cell, type) => {
    last = ''
    let data = {};
    type == 1 ? data = cell[0].geometry : data = cell;
    //进度条值, 进度条蓝色进度样式
    $(`#width`).val(data.width / globalRatio).css('background-size', data.width / globalRatio + '% 100%');
    $(`#height`).val(data.height / globalRatio).css('background-size', data.height / globalRatio + '% 100%');
    $(`#top1`).val(data.y / globalRatio).css('background-size', data.y / globalRatio + '% 100%');
    $(`#left`).val(data.x / globalRatio).css('background-size', data.x / globalRatio + '% 100%');
    // 角度初始化
    // 值
    $(`#width-value`).val(data.width.toFixed(1));
    $(`#height-value`).val(data.height.toFixed(1));
    $(`#top-value`).val(data.y.toFixed(1));
    $(`#left-value`).val(data.x.toFixed(1));
    if (type == 1) {
        let angle = globalGraph.getCellStyle(cell[0]).rotation || 0;
        $(`#angle`).val(angle / 3.6).css('background-size', (angle / 3.6) + '% 100%');
        $(`#angle-value`).val(angle.toFixed(1));
    }
}
// pdf
function showPdf() {

    var nodesToRecover = [];
    var nodesToRemove = [];
    var svgElem = $("#container").find('svg');
    svgElem.each(function (index, node) {
        var parentNode = node.parentNode;
        var svg = node.outerHTML.trim();

        var canvas = document.createElement('canvas');
        canvg(canvas, svg);
        if (node.style.position) {
            canvas.style.position += node.style.position;
            canvas.style.left += node.style.left;
            canvas.style.top += node.style.top;
        }

        nodesToRecover.push({
            parent: parentNode,
            child: node
        });
        parentNode.removeChild(node);

        nodesToRemove.push({
            parent: parentNode,
            child: canvas
        });
        parentNode.appendChild(canvas);
    });
    html2canvas(document.querySelector("#container"), {
        onrendered: function (canvas) {
            var pageData = canvas.toDataURL('image/jpeg', 1.0);
            //方向默认竖直，尺寸ponits，格式a4【595.28,841.89]
            var pdf = new jsPDF('', 'pt', 'a4');
            //需要dataUrl格式
            pdf.addImage(pageData, 'JPEG', 0, 0, 500, 500 );
            var _templatePdf = document.getElementById('templatePdf').value;
            _templatePdf = _templatePdf=='' ? 'contentPDF_' + moment().format('YYYYMMDDhmmss') : _templatePdf;
            _templatePdf = templatePDFDir + _templatePdf + '.pdf';
            pdf.save(_templatePdf);
        }
    });
}

//右侧点击旋转事件
$('.angle-icon').on("click", function (e, idx) {
    let index = $(this).index() - 1
    let dirs = ['east', 'south', 'west', 'north'];
    let dir = dirs[index - 1]
    if (last == dir) {
        return
    }
    last = dir
    rotate(dir);
})