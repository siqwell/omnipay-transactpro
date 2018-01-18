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
     * @param array $parameters
     *
     * @return OmnipayAbstractRequest
     */
    public function initialize(array $parameters = [])
    {
        $initialize =  parent::initialize($parameters);

        if (count($this->getParameters())) {
            $config = [
                'rs'        => $this->getRoutingString(),
                'guid'      => $this->getGUID(),
                'pwd'       => $this->getPassword(),
                'verifySSL' => $this->getVerifySsl()
            ];

            if ($apiUrl = $this->getApiAddress()) {
                $config['apiUrl'] = $apiUrl;
            }

            $this->gateClient = new GateClient($config);
        }

        return $initialize;
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
            'rs'                      => $this->getRoutingString(),
            'merchant_transaction_id' => $this->getOrderId(),
            'amount'                  => round($this->getAmount() * 100),
            'currency'                => $this->getCurrency(),
            'user_ip'                 => $this->getClientIp(),
            'description'             => $this->getDescription(),
            'merchant_site_url'       => $this->getSiteAddress(),
            'custom_return_url'       => $this->getReturnUrl(),
            'custom_callback_url'     => $this->getNotifyUrl(),

            'name_on_card'            => $this->getClient()->getName(),
            'phone'                   => $this->getClient()->getPhone(),
            'email'                   => $this->getClient()->getEmail(),
            'country'                 => $this->getClient()->getCountry(),
            'city'                    => $this->getClient()->getCity(),
            'street'                  => $this->getClient()->getStreet(),
            'zip'                     => $this->getClient()->getZip()
        ];
    }
}