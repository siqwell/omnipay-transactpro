<?php

namespace Omnipay\TransactPro;

use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\TransactPro\Message\CompletePurchaseRequest;
use Omnipay\TransactPro\Message\PurchaseRequest;

/**
 * Class Gateway
 * @package Omnipay\TransactPro
 */
class Gateway extends AbstractGateway
{
    use ParametersTrait;

    /**
     * @return string
     */
    public function getName()
    {
        return 'TransactPro';
    }

    /**
     * @return array
     */
    public function getDefaultParameters()
    {
        return [
            'apiUrl'        => '',
            'guid'          => '',
            'password'      => '',
            'currency'      => 'USD',
            'routingString' => '',
            'verifySSL'     => false
        ];
    }

    /**
     * @param array $options
     *
     * @return RequestInterface
     */
    public function purchase(array $options = []): RequestInterface
    {
        return $this->createRequest(PurchaseRequest::class, $options);
    }

    /**
     * @param array $options
     *
     * @return RequestInterface
     */
    public function completePurchase(array $options = []): RequestInterface
    {
        return $this->createRequest(CompletePurchaseRequest::class, $options);
    }
}
