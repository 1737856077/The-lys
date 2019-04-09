//全局图像对象
var globalGraph = {}
// 全局图像比例
var globalRatio = 10;

function main() {
    if (!mxClient.isBrowserSupported()) {
        mxUtils.error('Browser is not supported!', 200, false);
    } else {
        mxConnectionHandler.prototype.connectImage = new mxImage(mxClientMyDir + 'examples/images/connector.gif', 16, 16);
        // 一维码
        var qrcode1 = document.getElementById('code1')
        // 二维码
        var qrcode2 = document.getElementById('code2')
        var basicImage_rectangle = document.getElementById('basicImage-rectangle')
        var basicImage_circle = document.getElementById('basicImage-circle')
        var basicImage_triangle = document.getElementById('basicImage-triangle')
        var text = document.getElementById('text')
        var line = document.getElementById('line')

        var toolbar_qrcode1 = new mxToolbar(qrcode1);
        var toolbar_qrcode2 = new mxToolbar(qrcode2);
        var toolbar_rectangle = new mxToolbar(basicImage_rectangle);
        var toolbar_circle = new mxToolbar(basicImage_circle);
        var toolbar_triangle = new mxToolbar(basicImage_triangle);
        var toolbarText = new mxToolbar(text);
        var toolbarLine = new mxToolbar(line);
        // 基本图形：圆，长方形
        toolbar_qrcode1.enabled = false
        toolbar_qrcode2.enabled = false
        toolbar_rectangle.enabled = false
        toolbar_circle.enabled = false
        toolbar_triangle.enabled = false
        toolbarText.enabled = false
        toolbarLine.enabled = false
        //线条
        var container = document.getElementById('container')
        if (mxClient.IS_QUIRKS) {
            document.body.style.overflow = 'hidden';
            new mxDivResizer(basicImage);
            new mxDivResizer(text);
            new mxDivResizer(container);
        }
        var model = new mxGraphModel();
        var graph = new mxGraph(container, model);
        globalGraph = graph;
        graph.setConnectable(true);
        graph.setMultigraph(false);
        var addVertex = function (icon, w, h, style, toolbar, shape) {
            var vertex = new mxCell(null, new mxGeometry(0, 0, w, h), style);
            vertex.setVertex(true);
            var img = addToolbarItem(graph, toolbar, vertex, icon);
            img.enabled = true;
            graph.getSelectionModel().addListener(mxEvent.CHANGE, function () {
                var tmp = graph.isSelectionEmpty();
            });
            let div = document.createElement('div');
            div.innerHTML = shape
            toolbar.container.append(div)
        };
        addVertex(mxClientMyDir + 'examples/editors/images/rectangle.gif', 100, 40, '', toolbar_rectangle, '长方形');
        addVertex(mxClientMyDir + 'examples/editors/images/rectangle.gif', 40, 40, '', toolbar_qrcode1, '一维码');
        addVertex(mxClientMyDir + 'examples/editors/images/rectangle.gif', 40, 40, '', toolbar_qrcode2, '二维码');
        addVertex(mxClientMyDir + 'examples/editors/images/rounded.gif', 40, 40, 'shape=ellipse', toolbar_circle, '圆形');
        addVertex(mxClientMyDir + 'examples/editors/images/triangle.gif', 40, 40, 'shape=triangle', toolbar_triangle, '三角形');
        //水平线，文字
        addVertex(mxClientMyDir + 'examples/editors/images/text.gif', 30, 40, 'shape=text', toolbarText, '文字');
        addVertex(mxClientMyDir + 'examples/editors/images/hline.gif', 30, 40, 'shape=line', toolbarLine, '线条');
        // 初始化数据
        init(graph)
    }
}

// 调用接口初始化数据
function init(graph) {
    // 1 圆形 2 长方形
    let shape = {
        round: 1,
        rectangle: 2
    }
    let response = {
        data: {
            graph: `
                        <mxGraphModel>
                          <root>
                            <mxCell id="0"/>
                            <mxCell id="1" parent="0"/>
                            <mxCell id="2" style="shape=rounded;rotation=189.324;" parent="1" vertex="1">
                              <mxGeometry x="127.5" y="191.25" width="100" height="40" as="geometry"/>
                            </mxCell>
                            <mxCell id="3" style="" parent="1" vertex="1">
                              <mxGeometry x="121.25" y="320" width="100" height="40" as="geometry"/>
                            </mxCell>
                            <mxCell id="4" style="shape=triangle" parent="1" vertex="1">
                              <mxGeometry x="107.5" y="87.5" width="40" height="40" as="geometry"/>
                            </mxCell>
                          </root>
                        </mxGraphModel>
                    `,
            shape: 1,
            top: 1,
            left: 1,
            width: 500,
            height: 500
        }
    };
    // 初始化绘制图形区域
    let data = response.data;
    $('#container').width(data.width).height(data.height)//.css({top:data.top,left:data.left})
    if (data.shape == shape.round) {
        console.log('round');
        $('#container').css({borderRadius: '50%'});
    }
    if (data.shape == shape.rectangle) {
        console.log('rectangle')
    }
    initXML(response.data.graph, graph)
}

function addToolbarItem(graph, toolbar, prototype, image) {
    var funct = function (graph, evt, cell, x, y) {
        graph.stopEditing(false);

        var vertex = graph.getModel().cloneCell(prototype);
        vertex.geometry.x = x;
        vertex.geometry.y = y;

        graph.addCell(vertex);
        graph.setSelectionCell(vertex);
    }
    var img = toolbar.addMode(null, image, function (evt, cell) {
        var pt = this.graph.getPointForEvent(evt);
        funct(graph, evt, cell, pt.x, pt.y);
    });
    mxEvent.addListener(img, 'mousedown', function (evt) {
        // do nothing
    });
    mxEvent.addListener(img, 'mousedown', function (evt) {
        if (img.enabled == false) {
            mxEvent.consume(evt);
        }
    });
    mxUtils.makeDraggable(img, graph, funct);
    return img;
}


//  view xml
function getXML(graph) {
    // var button = mxUtils.button('View XML', function () {
    var encoder = new mxCodec();
    var node = encoder.encode(graph.getModel());
    // mxUtils.popup(mxUtils.getPrettyXml(node), true);
    // });
    return mxUtils.getPrettyXml(node)
    // document.getElementById('top').appendChild(button);
}


// xml 回显

function initXML(xml, graph) {
    var doc = mxUtils.parseXml(xml);
    var codec = new mxCodec(doc);
    codec.decode(doc.documentElement, graph.getModel());
}
