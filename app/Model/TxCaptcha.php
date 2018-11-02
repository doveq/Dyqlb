<?php
/**
 * 腾讯人机验证
*/
namespace App\Model;


class TxCaptcha  {

    /**
     * 验证人机验证数据
     *
     * @var string $ticket 验证码客户端验证回调的票据
     * @var string $randstr 验证码客户端验证回调的随机串
     *
     * @return boolean
    */
    public function ticketVerify($ticket, $randstr) {
        $ip = 'unknown';
        if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
            $ip = getenv("HTTP_CLIENT_IP");
        else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
            $ip = getenv("REMOTE_ADDR");
        else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
            $ip = $_SERVER['REMOTE_ADDR'];

        // 拼接腾讯验证url
        $url = config('config.txCaptchaUrl')
            . '?aid='. config('config.txCaptchaAppId')
            . '&AppSecretKey='. config('config.txCaptchaAppSecret')
            . "&Ticket={$ticket}&Randstr={$randstr}&UserIP={$ip}";

        $body = json_decode(file_get_contents($url), true);

        if ($body['response'] == 1)
            return true;
        else
            return false;
    }

}
