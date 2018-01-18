<?php

namespace Omnipay\TransactPro;

use Omnipay\Common\AbstractGateway as OmnipayAbstractGateway;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\TransactPro\Message\CompletePurchaseRequest;
use Omnipay\TransactPro\Message\PurchaseRequest;

/**
 * Class AbstractGateway
 * @package Omnipay\TransactPro
 */
abstract class AbstractGateway extends OmnipayAbstractGateway
{
    use ParametersTrait;

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