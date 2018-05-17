<?php

namespace Omnipay\TransactPro\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;

/**
 * Class PurchaseResponse
 * @package Omnipay\TransactPro\Message
 */
class PurchaseResponse extends AbstractResponse implements RedirectResponseInterface
{
    /**
     * Is the response successful?
     *
     * @return bool
     */
    public function isSuccessful()
    {
        return ($this->data['success'] && $this->data['redirect']) ? true : false;
    }

    /**
     * @return bool
     */
    public function isRedirect()
    {
        return true;
    }

    /**
     * @return bool|string
     * @throws InvalidRequestException
     */
    public function getRedirectUrl()
    {
        if (!$this->data['success'] || !$this->data['redirect']) {
            throw new InvalidRequestException($this->data['error']);
        }

        return $this->data['redirect'];
    }

    /**
     * Transaction id.
     *
     * @return string|null
     */
    public function getMessage()
    {
        return $this->data['success'] ? 'Success' : $this->data['error'];
    }

    /**
     * @param bool $serialize
     *
     * @return string
     */
    public function getTransactionReference($serialize = true)
    {
        return json_encode($this->getData());
    }

    /**
     * @return null|string
     */
    public function getTransactionId()
    {
        return isset($this->data['transactionId']) ? $this->data['transactionId'] : null;
    }
}