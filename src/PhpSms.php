<?php
/**
 * Created by PhpStorm.
 * User: kuang
 * Date: 2017/9/26
 * Time: 15:38
 */

namespace Kuangjy\PhpSms;

use yii\base\Component;
use yii\base\InvalidConfigException;
use Toplan\PhpSms\Sms;

class PhpSms extends Component
{
    public $config = [];
    public $scheme = [];

    public function init()
    {
        parent::init();
        if (empty($this->config) || empty($this->scheme)) {
            throw new InvalidConfigException("You must configure your correct SMS agents' configurations and schemes.");
        }
        Sms::config($this->config);
        Sms::scheme($this->scheme);
    }

    /**
     * @param mixed|null $var1
     * @param string||null $var2
     * @return \Toplan\PhpSms\Sms
     */
    public function createSms($var1 = null, $var2 = null)
    {
        if ($var1 || $var2) {
            return Sms::make($var1, $var2);
        } else {
            return Sms::make();
        }
    }

    /**
     * @param string|null $code
     * @return \Toplan\PhpSms\Sms
     */
    public function createVoice($code = null)
    {
        return Sms::voice($code);
    }

    public static function __callStatic($name, $arguments)
    {
        forward_static_call_array(['\Toplan\PhpSms\Sms', $name], $arguments);
    }

}