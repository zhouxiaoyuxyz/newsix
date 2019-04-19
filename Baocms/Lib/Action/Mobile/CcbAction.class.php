<?php
class CcbAction extends CommonAction
{
    //建行提供的密钥，需要登陆建行商户后台下载
    private $pubstr = '30819d300d06092a864886f70d010101050003818b0030818702818100877422410d304a4f4faff91b8e29b9a9871441c969c08ecf7ae0f3cffd54e8f3a63eb2e2a0a4a3db9aea287cf3ee46a46b31f19d9e3fa612e8bb125f04696da7394be650c9b177145a411f6c5b7b0dc8544628c7545863e6b52930e2acf7a8d3a3c018609df1bf00d454c53be264d4ec3f54e241d2d0e213669bf28a0052db9b020111';

    //商户代码
    private $MERCHANTID = '105000073722562';

    //商户柜台代码
    private $POSID = '031716071';

    //银行分行代码
    private $BRANCHID = '370000000';

    //订单编号
    private $ORDERID = '';

    //订单金额
    private $PAYMENT = '';

    //币种
    private $CURCODE = '01';

    //交易码
    private $TXCODE = '520100';

    //备注1
    private $REMARK1 = '';

    //备注2
    private $REMARK2 = '';

    //接口类型
    private $TYPE = '';

    //网关类型
    private $GATEWAY = '';

    //客户端ip地址
    private $CLIENTIP = '';

    //公钥后30位
    private $PUB32TR2 = 'd2d0e213669bf28a0052db9b020111';

    //提交url
    private $bankURL = '';

    //注册信息
    private $REGINFO = '';

    //商品信息
    private $PROINFO = '';

    //商户域名
    private $REFERER = '';
    private $URL = '';
    //聚合二维码配置---start---------------------
    //二维码返回形式
    private $RETURNTYPE = 3;
    //超时时间
    private $TIMEOUT = '';
    //二维码URL
    private $QRURL = 'https://ibsbjstar.ccb.com.cn/CCBIS/ccbMain?CCB_IBSVersion=V6&';
    //textcode
    private $TEXTCODE2 = '530550';
    //聚合二维码配置---end------------------------
    private $tmp = '';
    private $temp_New = '';
    private $temp_New1 = '';
    /**
     * @param $pubkey string 商户的公钥
     * @param $merchantid string 商户号
     * @param $posid string 商户柜台号
     * @param $branchid string 分行代码
     * @param string $order_sn string 订单号
     * @param string $payment string 支付金额
     * @param string $proinfo string 商品信息
     * @param string $remark1 string 备注1 订单id
     * @param string $remark2 string 备注2 订单支付方式
     */
    public function __construct($pubkey, $merchantid, $posid, $branchid, $order_sn = '', $payment = '', $proinfo = '', $remark1 = '', $remark2 = '')
    {
        $this->pubstr = trim($pubkey);
        $this->MERCHANTID = trim($merchantid);
        $this->POSID = trim($posid);
        $this->BRANCHID = trim($branchid);
        $this->ORDERID = $order_sn;
        $this->PAYMENT = $payment;
        $this->CURCODE = '01';
        $this->TXCODE = '520100';
        $this->REMARK1 = $remark1;
        $this->REMARK2 = $remark2;
        $this->bankURL = 'https://ibsbjstar.ccb.com.cn/CCBIS/ccbMain';
        $this->TYPE = 1;
        $this->PUB32TR2 = substr($this->pubstr, -30);
        $this->GATEWAY = '';
        $this->CLIENTIP = '';
        //get_client_ip();
        $this->REGINFO = '';
        $this->PROINFO = $proinfo;
        $this->REFERER = '';
        //以下为聚合二维码方式需要的参数
        $this->RETURNTYPE = 3;
    }
    /*获取参数值*/
    public function getVar($name)
    {
        return $this->{$name};
    }
    /**
     * @return string 返回建行卡支付访问的url
     */
    public function getUrl()
    {
        $this->tmp = 'MERCHANTID=' . $this->MERCHANTID . '&POSID=' . $this->POSID . '&BRANCHID=' . $this->BRANCHID . '&ORDERID=' . $this->ORDERID . '&PAYMENT=' . $this->PAYMENT . '&CURCODE=' . $this->CURCODE . '&TXCODE=' . $this->TXCODE . '&REMARK1=' . $this->REMARK1 . '&REMARK2=' . $this->REMARK2;
        $this->temp_New = $this->tmp . "&TYPE=" . $this->TYPE . "&PUB=" . $this->PUB32TR2 . "&GATEWAY=" . $this->GATEWAY . "&CLIENTIP=" . $this->CLIENTIP . "&REGINFO=" . $this->REGINFO . "&PROINFO=" . $this->PROINFO . "&REFERER=" . $this->REFERER;
        $this->temp_New1 = $this->tmp . "&TYPE=" . $this->TYPE . "&GATEWAY=" . $this->GATEWAY . "&CLIENTIP=" . $this->CLIENTIP . "&REGINFO=" . $this->REGINFO . "&PROINFO=" . $this->PROINFO . "&REFERER=" . $this->REFERER;
        $strMD5 = md5($this->temp_New);
        $this->URL = $this->bankURL . "?" . $this->temp_New1 . "&MAC=" . $strMD5;
        return $this->URL;
    }

    /**
     * string 传入支付金额和订单id，返回建行卡支付访问的url
     * @param $payment 支付金额
     * @param $orderId 订单id
     * @return string
     */
    public function getUrl4Send($payment, $orderId)
    {
        $this->tmp = 'MERCHANTID=' . $this->MERCHANTID . '&POSID=' . $this->POSID . '&BRANCHID=' . $this->BRANCHID . '&ORDERID=' . $orderId . '&PAYMENT=' . $payment . '&CURCODE=' . $this->CURCODE . '&TXCODE=' . $this->TXCODE . '&REMARK1=' . $this->REMARK1 . '&REMARK2=' . $this->REMARK2;
        $this->temp_New = $this->tmp . "&TYPE=" . $this->TYPE . "&PUB=" . $this->PUB32TR2 . "&GATEWAY=" . $this->GATEWAY . "&CLIENTIP=" . $this->CLIENTIP . "&REGINFO=" . $this->REGINFO . "&PROINFO=" . $this->PROINFO . "&REFERER=" . $this->REFERER;
        $this->temp_New1 = $this->tmp . "&TYPE=" . $this->TYPE . "&GATEWAY=" . $this->GATEWAY . "&CLIENTIP=" . $this->CLIENTIP . "&REGINFO=" . $this->REGINFO . "&PROINFO=" . $this->PROINFO . "&REFERER=" . $this->REFERER;
        $strMD5 = md5($this->temp_New);
        $this->URL = $this->bankURL . "?" . $this->temp_New1 . "&MAC=" . $strMD5;
        return $this->URL;
    }

    /*
     * 得到二维码上传的地址
     */
    public function getQrCodeUrl()
    {
        $this->URL = '';
        $this->temp_New = '';
        $this->temp_New1 = '';
        $this->tmp = 'MERCHANTID=' . $this->MERCHANTID . '&POSID=' . $this->POSID . '&BRANCHID=' . $this->BRANCHID . '&ORDERID=' . $this->MERCHANTID . $this->ORDERID . '&PAYMENT=' . $this->PAYMENT . '&CURCODE=' . $this->CURCODE . '&TXCODE=' . $this->TEXTCODE2 . '&REMARK1=' . $this->REMARK1 . '&REMARK2=' . $this->REMARK2;
        $this->temp_New .= $this->tmp . "&RETURNTYPE=" . $this->RETURNTYPE . "&TIMEOUT=" . $this->TIMEOUT . "&PUB=" . $this->PUB32TR2;
        $this->temp_New1 .= $this->tmp . "&RETURNTYPE=" . $this->RETURNTYPE . "&TIMEOUT=" . $this->TIMEOUT;
        $strMD5 = md5($this->temp_New);
        $this->URL = $this->QRURL . $this->temp_New1 . "&MAC=" . $strMD5;
        return $this->URL;
    }
    /*记录支付日志信息*/
    public function writeLog($order, $type)
    {
        $path = ROOT_PATH . '/Log/' . date("Y-m-d") . '/';
        if (!is_dir($path)) {
            mkdir($path, 0755);
        }
        $fp = fopen($path . $order['order_sn'] . '.txt', 'a');
        if (flock($fp, LOCK_EX)) {
            fwrite($fp, "支付发起时间：\r");
            fwrite($fp, date('Y-m-d H:i:s'));
            fwrite($fp, PHP_EOL);
            fwrite($fp, '支付方式:' . $type . PHP_EOL);
            fwrite($fp, "传递url参数信息：" . PHP_EOL);
            fwrite($fp, $type == 'wechat' ? $this->getQrCodeUrl() : $this->getUrl());
            fwrite($fp, PHP_EOL . "记录支付前数据信息:" . PHP_EOL);
            fwrite($fp, "订单号：" . $order['order_sn'] . PHP_EOL . "订单金额：" . $order['order_amount']);
            fwrite($fp, PHP_EOL);
            flock($fp, LOCK_UN);
        }
        fclose($fp);
    }
    /**
     * 更新日志，记录错误信息
     * @param $order_sn string 订单号
     * @param $mess string 存储的信息
     */
    public function writeLogAdd($order_sn, $mess)
    {
        $path = ROOT_PATH . '/Log/' . date("Y-m-d") . '/';
        if (!is_dir($path)) {
            mkdir($path, 0755);
        }
        $fp = fopen($path . $order_sn . '.txt', 'a');
        if (flock($fp, LOCK_EX)) {
            fwrite($fp, PHP_EOL);
            fwrite($fp, $mess . ' Time:' . date('Y-m-d H:i:s'));
            fwrite($fp, PHP_EOL);
            flock($fp, LOCK_UN);
        }
        fclose($fp);
    }
    /** 将公钥转换为pem格式
     * @param $public_key string 公钥内容
     * @return string pem格式证书
     */
    private function der2pem($public_key)
    {
        $pem = chunk_split(base64_encode(hex2bin($public_key)), 64, "\n");
        $pem = "-----BEGIN PUBLIC KEY-----\n" . $pem . "-----END PUBLIC KEY-----\n";
        return $pem;
    }
    /**
     * @return bool
     */
    public function verify()
    {
        $str =  date("Y-m-d H:i:s") . "\n";
        $params = substr($_SERVER['QUERY_STRING'], 19);
        error_log($str. $params . "\n",   3,   "/www/wwwroot/six/ccb.log");

        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if ($socket < 0) {
            error_log("socket创建失败:" . socket_strerror($socket) . "\n" ,   3,   "/www/wwwroot/six/ccb.log");
        } else {
            error_log("socket创建成功" . "\n" ,   3,   "/www/wwwroot/six/ccb.log");
        }
        $result = socket_connect($socket, "127.0.0.1", "55533");
        if ($result < 0) {
            error_log("socket连接失败:" . socket_strerror($result) . "\n" ,   3,   "/www/wwwroot/six/ccb.log");
        } else {
            echo "OK.\n";
        }
        //发送验证
        $in = $params . "\n";
        $out = '';
        error_log("开始验证 .........." . "\n" ,   3,   "/www/wwwroot/six/ccb.log");
        socket_write($socket, $in, strlen($in));
        while ($out = socket_read($socket, 2048)) {
            error_log("验证结果：" . strlen($out) . $out . "\n" ,   3,   "/www/wwwroot/six/ccb.log");
          
            if(strlen($out) > 1){
                error_log("开始修改订单状态\n" ,   3,   "/www/wwwroot/six/ccb.log");

                if('Y' == substr($out,0,1)){
                    error_log("socket验证成功\n" ,   3,   "/www/wwwroot/six/ccb.log");
                    $arr = explode("&", $params);
                    $orderIdArr = explode("=", $arr[2]);
                    $paymentArr = explode("=", $arr[3]);
                    error_log("orderId:" . $orderIdArr[1] . " payment:" . $paymentArr[1] . "\n" ,   3,   "/www/wwwroot/six/ccb.log");
                    // 设置paylog为已支付
                    error_log("改变订单状态" . $orderIdArr[1] . "\n" ,   3,   "/www/wwwroot/six/ccb.log");
                    D('Payment')->logsPaid($orderIdArr[1]);
                }
            }
        }
      
      	
        socket_close($socket);


        error_log("-----------------------\n" ,   3,   "/www/wwwroot/six/ccb.log");
        return $out;
    }
    /**
     * @param $url
     * @param string $type
     * @param string $paras
     * @param string $refer
     * @return mixed
     */
    public function curlatt($url, $type = 'post', $paras = '', $refer = '')
    {
        #设置执行时间不限时
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_REFERER, $refer);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        // 对认证证书来源的检查
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        // 从证书中检查SSL加密算法是否存在
        curl_setopt($ch, CURLOPT_SSLVERSION, 0);
        //设置SSL协议版本号
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if ('post' == $type) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $paras);
        }
        $content = curl_exec($ch);
        curl_close($ch);
        return $content;
    }
}