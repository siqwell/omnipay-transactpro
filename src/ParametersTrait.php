<?php

namespace Omnipay\TransactPro;

/**
 * Trait ParametersTrait
 * @package Omnipay\TransactPro
 */
trait ParametersTrait
{
    /**
     * Get User ID
     * @return mixed
     */
    public function getGUID()
    {
        return $this->getParameter('guid');
    }

    /**
     * Set User ID
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
     * Get Live Flag
     * @return mixed
     */
    public function getLive()
    {
        return $this->getParameter('live');
    }

    /**
     * Set Live Flag
     *
     * @param $value
     *
     * @return mixed
     */
    public function setLive($value)
    {
        return $this->setParameter('live', $value);
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
}