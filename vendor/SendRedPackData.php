<?php

/**
 * 构造微信红包数据
 */
class SendRedPackData {

    protected $values = array();

    /**
     * 设置随机字符串，不长于32位。推荐随机数生成算法
     * @param string $value 
     * */
    public function SetNonce_str($value) {
        $this->values['nonce_str'] = $value;
    }

    /**
     * 设置红包订单号,长度为28位
     * @param string $value
     */
    public function SetMchBillNo($value) {
        $this->values['mch_billno'] = $value;
    }

    /**
     * 设置微信商户号
     * @param string $value
     */
    public function SetMchId($value) {
        $this->values['mch_id'] = $value;
    }

    /**
     * 设置发送红包的appid
     * @param string $value
     */
    public function SetWxAppId($value) {
        $this->values['wxappid'] = $value;
    }

    /**
     * 设置商户名称
     * @param string $value
     */
    public function SetSendName($value) {
        $this->values['send_name'] = $value;
    }

    /**
     * 设置用户openid
     * @param string $value
     */
    public function SetOpenId($value) {
        $this->values['re_openid'] = $value;
    }

    /**
 * 设置红包金额
 * @param string $value
 */
    public function SetTotalAmount($value) {
        $this->values['total_amount'] = $value;
    }

    /**
     * 设置红包金额
     * @param string $value
     */
    public function SetAmt_type($value) {
        $this->values['amt_type'] = $value;
    }
    /**
     * 设置红包发放总人数
     * @param string $value
     */
    public function SetTotalNum($value) {
        $this->values['total_num'] = $value;
    }

    /**
     * 红包祝福语
     * @param string $value
     */
    public function SetWishing($value) {
        $this->values['wishing'] = $value;
    }

    /**
     * 设置终端ip
     * @param string $value
     */
    public function SetSpbillCreateIp($value) {
        $this->values['client_ip'] = $value;
    }

    /**
     * 活动名称
     * @param string $value
     */
    public function SetActName($value) {
        $this->values['act_name'] = $value;
    }

    /**
     * 备注
     * @param string $value
     */
    public function SetRemark($value) {
        $this->values['remark'] = $value;
    }

    /**
     * 设置签名，详见签名生成算法
     * @param string $value 
     * */
    public function SetSign($key) {
        $sign = $this->MakeSign($key);
        $this->values['sign'] = $sign;
        return $sign;
    }

    /**
     * 生成签名
     * @return 签名，本函数不覆盖sign成员变量，如要设置签名需要调用SetSign方法赋值
     */
    public function MakeSign($key) {
        //签名步骤一：按字典序排序参数
        ksort($this->values);
        $string = $this->ToUrlParams();
        //签名步骤二：在string后加入KEY
        $string = $string . "&key=" . $key;
        //签名步骤三：MD5加密
        $string = md5($string);
        //签名步骤四：所有字符转为大写
        $result = strtoupper($string);
        return $result;
    }

    /**
     * 格式化参数格式化成url参数
     */
    public function ToUrlParams() {
        $buff = "";
        foreach ($this->values as $k => $v) {
            if ($k != "sign" && $v != "" && !is_array($v)) {
                $buff .= $k . "=" . $v . "&";
            }
        }

        $buff = trim($buff, "&");
        return $buff;
    }

    /**
     * 输出xml字符
     * @throws WxPayException
     * */
    public function ToXml() {
        if (!is_array($this->values) || count($this->values) <= 0) {
            throw new RedPackException("数组数据异常！");
        }

        $xml = "<xml>";
        foreach ($this->values as $key => $val) {
            if (is_numeric($val)) {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
            } else {
                $xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
            }
        }
        $xml .= "</xml>";
        return $xml;
    }

}
