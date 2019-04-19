function recharge(){
	layer.open({
		title: [ //或直接title:'标题'
        '请确认行程','color:#666666;  text-align: center;' //标题样式
		],
		content:'<div class="trip"><select name="" id="" class="trip_l fl"><option value="">请选择</option><option value="">请选择1</option><option value="">请选择2</option><option value="">请选择3</option><option value=""></option></select><select name="" id="" class="trip_r fr"><option value="">请选择</option><option value="">请选择1</option><option value="">请选择2</option><option value="">请选择3</option><option value=""></option></select></div><div class="abroad"><input type="text" placeholder="回国时间"  class="abroad_t"/><i></i><input type="text" placeholder="出国时间"  class="abroad_t"/></div><div class="relation"><button type="button" class="relation_t">确 认</button><button type="button" class="relation_f">联系买家</button></div>',
		//time:'2'
	})

}