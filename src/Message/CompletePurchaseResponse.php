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
        $response = $this->getData()->getParsedResponse();

        if ($response && !isset($response['ERROR'])) {
            return true;
        }

        return false;
    }

    /**
     * @return mixed|null|string
     */
    public function getTransactionId()
    {
        $response = $this->getData()->getParsedResponse();

        if ($response && isset($response['ID'])) {
            return $response['ID'];
        }

        return null;
    }

    /**
     * @return null|string
     */
    public function getTransactionReference()
    {
        return $this->getData()->getParsedResponse();
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->isSuccessful() ? 'Success ' . $this->getTransactionId() : 'Error ' . $this->getTransactionId();
    }
}
