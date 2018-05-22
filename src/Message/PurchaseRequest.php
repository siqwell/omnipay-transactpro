<?php

namespace Omnipay\TransactPro\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\TransactPro\Client\Response\Response;

/**
 * Class PurchaseRequest
 * @package Omnipay\TransactPro\Message
 */
class PurchaseRequest extends AbstractRequest
{
    /**
     * @param mixed $data
     *
     * @return AbstractResponse
     */
    public function sendData($data): AbstractResponse
    {
        /** @var Response $init */
        $data = $this->gate->init($data);

        if (!$redirect = $data->getRedirectUrl()) {
            return new PurchaseResponse($this, [
                'success' => false,
                'error'   => $data->getErrorMessage() ?? $data->getResponseContent()
            ]);
        }

        return new PurchaseResponse($this, [
            'success'       => true,
            'transactionId' => $data->getTransactionId(),
            'redirect'      => $data->getRedirectUrl()
        ]);
    }
}
