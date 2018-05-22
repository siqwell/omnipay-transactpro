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
        return false;
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
}