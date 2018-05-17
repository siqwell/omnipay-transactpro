<?php

namespace Omnipay\TransactPro\Support;

/**
 * Class Client
 * @package Omnipay\TransactPro\Support
 */
class Client
{
    /**
     * @var array
     */
    protected $client = [];

    /**
     * Client constructor.
     *
     * @param array $client
     */
    public function __construct(array $client = [])
    {
        $this->setClient($client);
    }

    /**
     * @param array $client
     */
    public function setClient(array $client)
    {
        $this->client = $client;
    }

    /**
     * @return mixed|null
     */
    public function getName()
    {
        return $this->get('name');
    }

    /**
     * @return mixed|null
     */
    public function getPhone()
    {
        return $this->get('phone');
    }

    /**
     * @return mixed|null
     */
    public function getEmail()
    {
        return $this->get('email');
    }

    /**
     * @return mixed|null
     */
    public function getCountry()
    {
        return $this->get('country');
    }

    /**
     * @return mixed|null
     */
    public function getCity()
    {
        return $this->get('city');
    }

    /**
     * @return mixed|null
     */
    public function getStreet()
    {
        return $this->get('street');
    }

    /**
     * @return mixed|null
     */
    public function getZip()
    {
        return $this->get('zip');
    }

    /**
     * @param $key
     *
     * @return mixed|null
     */
    public function get($key)
    {
        return isset($this->client[$key]) ? $this->client[$key] : null;
    }
}