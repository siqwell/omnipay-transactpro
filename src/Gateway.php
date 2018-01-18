<?php

namespace Omnipay\TransactPro;

/**
 * Class Gateway
 * @package Omnipay\TransactPro
 */
class Gateway extends AbstractGateway
{
    const GATEWAY_NAME = 'TransactPro';

    /**
     * @return string
     */
    public function getName()
    {
        return self::GATEWAY_NAME;
    }

    /**
     * @return array
     */
    public function getDefaultParameters()
    {
        return [
            'apiUrl' => '',
            'guid' => '',
            'password' => '',
            'currency' => 'USD',
            'routingString' => '',
            'verifySSL' => false
        ];
    }
}
