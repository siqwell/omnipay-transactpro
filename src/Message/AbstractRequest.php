<?php

namespace Omnipay\TransactPro\Message;

use Guzzle\Http\ClientInterface;
use Omnipay\Common\Message\AbstractRequest as OmnipayAbstractRequest;
use Symfony\Component\HttpFoundation\Request as HttpRequest;
use Omnipay\TransactPro\ParametersTrait;
use TransactPRO\Gate\GateClient;

/**
 * Class AbstractRequest
 * @package Omnipay\TransactPro\Message
 */
abstract class AbstractRequest extends OmnipayAbstractRequest
{
    use ParametersTrait;

    /**
     * Omnipay Request Type
     * @var string
     */
    protected $requestType = 'createTransactionRequest';

    /**
     * @var null
     */
    protected $action = null;

    /**
     * @var GateClient
     */
    protected $gateClient;

    /**
     * AbstractRequest constructor.
     * @param ClientInterface $httpClient
     * @param HttpRequest $httpRequest
     */
    public function __construct(ClientInterface $httpClient, HttpRequest $httpRequest)
    {
        $this->gateClient = new GateClient(array(
            'apiUrl'    => $this->getSiteAddress(),
            'guid'      => $this->getGUID(),
            'pwd'       => $this->getPassword(),
            'verifySSL' => $this->getVerifySsl()
        ));
        parent::__construct($httpClient, $httpRequest);
    }

    /**
     * @return mixed
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function getData()
    {
        $this->validate('amount', 'currency', 'description');

        return $this->getBaseData();
    }

    /**
     * @return array
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function getBaseData()
    {
        return [
            'merchant_transaction_id' => md5(time()), // TODO: Think about it
            'amount' => round($this->getAmount() * 100),
            'currency' => $this->getCurrency(),
            'user_ip' => $this->getClientIp(),
            'description' => $this->getDescription(),
            'merchant_site_url' => $this->getSiteAddress(),
            'custom_return_url' => $this->getReturnUrl(),
            'custom_callback_url' => $this->getNotifyUrl()
        ];
    }
}