var map = null;//地图对象
//创建和初始化地图函数：
function initMap() {
    createMap(); //创建地图
    setMapEvent(); //设置地图事件
    addMapControl(); //向地图添加控件
    addMark(); //向地图中添加marker
}

//创建地图函数：
function createMap() {
    map = new BMap.Map("dituContent"); //在百度地图容器中创建一个地图
    var point = new BMap.Point(122.081974,41.061997); //定义一个中心点坐标
    map.centerAndZoom(point, 17);  //设定地图的中心点和坐标并将地图显示在地图容器中
}

//地图事件设置函数：
function setMapEvent() {
    map.enableDragging(); //启用地图拖拽事件，默认启用(可不写)
    
}

//地图控件添加函数：
function addMapControl() {
	map.addControl(new BMap. ZoomControl ());
	map.addControl(new BMap.ScaleControl());//添加比例尺控件  
}
//添加地图标注无
function addMark(){
	var marker1 = new BMap.Marker(new BMap.Point(122.081974,41.061997));  //创建标注
	map.addOverlay(marker1);                 // 将标注添加到地图中
	//创建信息窗口
	var infoWindow1 = new BMap.InfoWindow("辽宁省盘锦市大洼县田家镇中国食品城");
	marker1.addEventListener("click", function(){this.openInfoWindow(infoWindow1);});
}

initMap(); //创建和初始化地图