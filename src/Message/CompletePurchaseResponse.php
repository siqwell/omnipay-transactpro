<?php

namespace Omnipay\TransactPro\Message;

use Omnipay\Common\Message\AbstractResponse;

/**
 * Class CompletePurchaseResponse
 * @package Omnipay\TransactPro\Message
 */
class CompletePurchaseResponse extends AbstractResponse
{
    /**
     * Is successful
     * @return bool
     */
    public function isSuccessful()
    {
        if ($this->data && !isset($this->data['ERROR'])) {
            return true;
        }

        return false;
    }

    /**
     * @return mixed|null|string
     */
    public function getTransactionId()
    {
        if ($this->data && isset($this->data['ID'])) {
            return $this->data['ID'];
        }

        return null;
    }

    /**
     * @return null|string
     */
    public function getTransactionReference()
    {
        return $this->data;
    }
}
