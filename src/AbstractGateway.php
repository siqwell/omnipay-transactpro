<?php

namespace Omnipay\TransactPro;

use Omnipay\Common\AbstractGateway as OmnipayAbstractGateway;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\Payboutique\Message\CompletePurchaseRequest;
use Omnipay\Payboutique\Message\PurchaseRequest;

/**
 * Class AbstractGateway
 * @package Omnipay\Payboutique
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