/**
 * @[在线排版系统] Shanghai 51upstar Information Technology Co., Ltd.
 * @desc:用户注册
 * @author:liuqingyan[Leaya] liuqingyan0308@163.com
 * $Id:preorder.js 2019-03-31 18:01:00 $
 */

//打印份数
function onBlur_printNum(){
    var printNum = document.getElementById("printNum").value.trim();
    if(printNum=="" || printNum<=0){
        document.getElementById("printNum").value='1';
    }
    document.getElementById("span_printNum").innerHTML="";
    onBlur_priceTotal();
}

//纸张
function onchange_paperId() {
    var printNum = document.getElementById("printNum").value.trim();
    var paperId = document.getElementById("paperId").value.trim();
    var listPaper = document.getElementById("listPaper").value.trim();
    listPaper = eval('('+listPaper+')');
    if(paperId == 0){
        return;
    }
    for(var i=0; i<listPaper.length; i++){
        if(listPaper[i]['id'] == paperId){
            document.getElementById("paperDataType").value=listPaper[i]['data_type'];
            if(listPaper[i]['data_type'] == 1){
                document.getElementById("paperPrice").value=0.00
            }else{
                if(printNum > 500){
                    document.getElementById("paperPrice").value=listPaper[i]['price_three'];
                }else if(printNum > 100){
                    document.getElementById("paperPrice").value=listPaper[i]['price_two'];
                }else{
                    document.getElementById("paperPrice").value=listPaper[i]['price_one'];
                }
            }
        }
    }
    onBlur_priceTotal();
}

//计算费用
function onBlur_priceTotal(){
    var _priceTotal = 0.00
    var printNum = document.getElementById("printNum").value.trim();
    var paperId = document.getElementById("paperId").value.trim();
    var listPaper = document.getElementById("listPaper").value;
    //alert(listPaper);return;
    listPaper = eval('('+listPaper+')');
    var _price = 0.00;

    if(printNum=="" || printNum<=0){
        return _priceTotal;
    }
    for(var i=0; i<listPaper.length; i++){
        if(listPaper[i]['id'] == paperId){
            // 用户自定义的纸张，后台手动计算价格
            if(listPaper[i]['data_type'] == 1){
                _price = 0.00
            }else{
                if(printNum > 500){
                    _price = listPaper[i]['price_three'];
                }else if(printNum > 100){
                    _price = listPaper[i]['price_two'];
                }else{
                    _price = listPaper[i]['price_one'];
                }
            }
        }
    }
    // 计算总费用
    _priceTotal=FloatMul(printNum,_price);

    document.getElementById("priceTotal").innerText=_priceTotal;
}

// submit
function subfun(){
    //打印份数
    onBlur_printNum();
    //计算费用
    onBlur_priceTotal();
    return true;
}