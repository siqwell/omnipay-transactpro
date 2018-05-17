<?php

namespace Omnipay\TransactPro\Message;

use Omnipay\Common\Message\AbstractRequest as BaseAbstractRequest;
use Omnipay\TransactPro\ParametersTrait;
use Omnipay\TransactPro\Client\GateClient;

/**
 * Class AbstractRequest
 * @package Omnipay\TransactPro\Message
 */
abstract class AbstractRequest extends BaseAbstractRequest
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
     * @return BaseAbstractRequest
     */
    public function initialize(array $parameters = [])
    {
        $initialize =  parent::initialize($parameters);

        if (count($this->getParameters())) {
            $config = [
                'rs'        => $this->getRoutingString(),
                'guid'      => $this->getGuid(),
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
     * @return array|mixed
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
            'amount'                  => round($this->getAmount() * 100),
            'currency'                => $this->getCurrency(),
            'user_ip'                 => $this->getClientIp(),
            'description'             => $this->getDescription(),
            'merchant_site_url'       => $this->getSiteAddress(),
            'merchant_transaction_id' => $this->getOrderId(),
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