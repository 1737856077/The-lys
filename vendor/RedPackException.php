<?php

/**
 * 
 * 微信红包异常处理
 * @author widyhu
 *
 */
class RedPackException extends Exception {

    public function errorMessage() {
        return $this->getMessage();
    }

}
