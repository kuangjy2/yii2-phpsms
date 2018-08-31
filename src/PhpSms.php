<?php

namespace kuangjy\PhpSms;

use Toplan\PhpSms\Sms;
use yii\base\Component;
use yii\base\InvalidConfigException;


/**
 * Class PhpSms
 * @package kuangjy\PhpSms
 *
 * @method static scheme($name = null, $scheme = null, $override = false)
 * @method static config($name = null, $config = null, $override = false)
 * @method static beforeSend($handler = null, $override = false)
 * @method static beforeAgentSend($handler = null, $override = false)
 * @method static afterAgentSend($handler = null, $override = false)
 * @method static afterSend($handler = null, $override = false)
 * @method static queue($enable = null, $handler = null)
 *
 */
class PhpSms extends Component
{
    /**
     * @var array
     */
    public $config = [];
    /**
     * @var array
     */
    public $scheme = [];
    /**
     * @var \Closure
     */
    public $beforeSend = null;
    /**
     * @var \Closure
     */
    public $beforeAgentSend = null;
    /**
     * @var \Closure
     */
    public $afterAgentSend = null;
    /**
     * @var \Closure
     */
    public $afterSend = null;

    /**
     * @throws InvalidConfigException
     * @throws \Toplan\PhpSms\PhpSmsException
     */
    public function init()
    {
        parent::init();
        if (empty($this->config) || empty($this->scheme)) {
            throw new InvalidConfigException("You must configure your correct SMS agents' configurations and schemes.");
        }
        Sms::config($this->config);
        Sms::scheme($this->scheme);
        if ($this->beforeSend != null) {
            Sms::beforeSend($this->beforeSend);
        }
        if ($this->beforeAgentSend != null) {
            Sms::beforeAgentSend($this->beforeAgentSend);
        }
        if ($this->afterAgentSend != null) {
            Sms::afterAgentSend($this->afterAgentSend);
        }
        if ($this->afterSend != null) {
            Sms::afterSend($this->afterSend);
        }
    }

    /**
     * @param mixed $var1
     * @param string $var2
     * @return \Toplan\PhpSms\Sms
     */
    public function createSms($var1 = null, $var2 = null)
    {
        if ($var1 != null || $var2 != null) {
            return Sms::make($var1, $var2);
        }
        return Sms::make();
    }

    /**
     * @param string $code
     * @return \Toplan\PhpSms\Sms
     */
    public function createVoice($code = null)
    {
        return Sms::voice($code);
    }

    public static function __callStatic($name, $arguments)
    {
        return forward_static_call_array(['Toplan\PhpSms\Sms', $name], $arguments);
    }

}
