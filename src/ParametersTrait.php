<?php

namespace Omnipay\TransactPro;

use Omnipay\TransactPro\Support\Client;

/**
 * Trait ParametersTrait
 * @package Omnipay\TransactPro
 */
trait ParametersTrait
{
    /**
     * Get GUID
     * @return mixed
     */
    public function getGUID()
    {
        return $this->getParameter('guid');
    }

    /**
     * Set GUID
     *
     * @param $value
     *
     * @return mixed
     */
    public function setGUID($value)
    {
        return $this->setParameter('guid', $value);
    }

    /**
     * Get Site Address
     * @return mixed
     */
    public function getApiAddress()
    {
        return $this->getParameter('apiAddress');
    }

    /**
     * Set Site Address
     *
     * @param $value
     *
     * @return mixed
     */
    public function setApiAddress($value)
    {
        return $this->setParameter('apiAddress', $value);
    }

    /**
     * Get verifySSL Flag
     * @return mixed
     */
    public function getVerifySsl()
    {
        return $this->getParameter('verifySSL');
    }

    /**
     * Set verifySSL Flag
     *
     * @param $value
     *
     * @return mixed
     */
    public function setVerifySsl($value)
    {
        return $this->setParameter('verifySSL', $value);
    }

    /**
     * Get Password
     * @return mixed
     */
    public function getPassword()
    {
        return $this->getParameter('password');
    }

    /**
     * Set Password
     *
     * @param $value
     *
     * @return mixed
     */
    public function setPassword($value)
    {
        return $this->setParameter('password', $value);
    }

    /**
     * Set Routing string
     *
     * @param $value
     *
     * @return mixed
     */
    public function setRoutingString($value)
    {
        return $this->setParameter('routingString', $value);
    }

    /**
     * Get Routing string
     *
     * @return mixed
     */
    public function getRoutingString()
    {
        return $this->getParameter('routingString');
    }

    /**
     * @param $value
     * @return mixed
     */
    public function setOrderId($value)
    {
        return $this->setParameter('orderID', $value);
    }

    /**
     * Get Time
     * @return string
     */
    public function getOrderId()
    {
        return $this->getParameter('orderID');
    }

    /**
     * Get Site Address
     * @return mixed
     */
    public function getSiteAddress()
    {
        return $this->getParameter('siteAddress');
    }

    /**
     * Set Site Address
     *
     * @param $value
     *
     * @return mixed
     */
    public function setSiteAddress($value)
    {
        return $this->setParameter('siteAddress', $value);
    }

    /**
     * Get Client
     * @return mixed
     */
    public function getClient()
    {
        return new Client($this->getParameter('client'));
    }

    /**
     * Set Client
     *
     * @param $value
     *
     * @return mixed
     */
    public function setClient($value)
    {
        return $this->setParameter('client', $value);
    }

    /**
     * Rewrite IP if needed
     *
     * @param $value
     *
     * @return mixed
     */
    public function setClientIp($value)
    {
        return $this->setParameter('clientIp', $value);
    }
}