<?php
/**
 * Created by PhpStorm.
 * User: kuang
 * Date: 2017/10/20
 * Time: 22:55
 */

namespace kuangjy\PhpSms\Tests;

use kuangjy\PhpSms\PhpSms;


class SendSmsTest extends TestCase
{
    public function testNewComponent()
    {
        $config = [
            'Aliyun' => [
                'accessKeyId' => 'your_access_key_id',
                'accessKeySecret' => 'your_access_key_secret',
                'signName' => 'your_sms_sign_name',
                'regionId' => 'cn-shenzhen',
            ],
        ];
        $scheme = [
            'Aliyun' => '100'
        ];
        $component = new PhpSms(['config' => $config, 'scheme' => $scheme]);
        $this->assertInstanceOf(PhpSms::class, $component);
        $component_config = PhpSms::config();
        $component_scheme = PhpSms::scheme();
        $this->assertArrayHasKey('Aliyun', $component_config);
        $this->assertArrayHasKey('Aliyun', $component_scheme);
        $this->assertEquals('100', $component_scheme['Aliyun']);

        return $component;
    }


    /**
     * @depends testNewComponent
     * @param PhpSms $component
     */
    public function testSendSms($component)
    {
        $sms = $component->createSms();
        $this->assertInstanceOf(\Toplan\PhpSms\Sms::class, $sms);

        $to = '13800138000';
        $templates = [
            'Aliyun' => 'your_temp_id'
        ];
        $tempData = [
            'code' => '123456'
        ];
        $content = '您的验证码是' . $tempData['code'];
        $result = $sms->to($to)
            ->template($templates)
            ->data($tempData)
            ->content($content)
            ->send();
        $this->assertTrue($result['success']);
        var_dump($result);
    }

}