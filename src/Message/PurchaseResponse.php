<?php

namespace Omnipay\TransactPro\Message;

use Omnipay\Common\Message\RedirectResponseInterface;

/**
 * Class PurchaseResponse
 * @package Omnipay\TransactPro\Message
 */
class PurchaseResponse extends AbstractResponse implements RedirectResponseInterface
{
    /**
     * Is successful
     * @return bool
     */
    public function isSuccessful()
    {
        return $this->getResultCode() === 1;
    }

    /**
     * Return status code
     * @return int
     */
    public function getResultCode()
    {
        $data = $this->getData();

        if (!$data['success']) {
            return 0;
        }

        return 1;
    }

    /**
     * Is redirect
     * @return string|bool
     */
    public function isRedirect()
    {
        $data = $this->getData();

        if (isset($data['redirect'])) {
            return true;
        }

        return false;
    }

    /**
     *
     */
    public function getRedirectUrl()
    {
        $data = $this->getData();

        if (isset($data['redirect'])) {
            return $data['redirect'];
        }

        return false;
    }

    /**
     * Redirect method
     * @return string
     */
    public function getRedirectMethod()
    {
        return 'GET';
    }

    /**
     * Redirect data
     * @return mixed
     */
    public function getRedirectData()
    {
        return [];
    }

    /**
     * Transaction id.
     *
     * @return string|null
     */
    public function getMessage()
    {
        $data = $this->getData();

        return $data['success'] ? 'Success' : $data['error'];
    }

    /**
     * @param bool $serialize
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
        $data = $this->getData();
        
        return isset($data['transactionId']) ? $data['transactionId'] : null;
    }
}