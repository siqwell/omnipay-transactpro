<?php

namespace Omnipay\TransactPro\Message;

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
        if ($this->getData() && $this->getData()->isSuccessful()) {
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function isRedirect()
    {
        return false;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->isSuccessful() ? 'Success ' . $this->getTransactionId() : 'Error ' . $this->getTransactionId();
    }

    /**
     * @return string
     */
    public function confirm()
    {
        $this->exitWith('OK:' . $this->getTransactionId());
    }

    /**
     * @return string
     */
    public function error()
    {
        $this->exitWith('ERR:' . $this->getTransactionId());
    }

    /**
     * @codeCoverageIgnore
     *
     * @param string $result
     */
    public function exitWith($result)
    {
        if (!$this->isSuccessful()) {
            header('Content-Type: text/plain; charset=utf-8', true, 401);
            return;
        }

        header('Content-Type: text/plain; charset=utf-8', true, 200);
        echo $result;
        exit;
    }
}
