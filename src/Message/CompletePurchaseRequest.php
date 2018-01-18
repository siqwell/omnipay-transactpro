<?php

namespace Omnipay\TransactPro\Message;

/**
 * Class CompletePurchaseRequest
 * @package Omnipay\TransactPro\Message
 */
class CompletePurchaseRequest extends AbstractRequest
{
    /**
     * @return array|mixed
     */
    public function getData()
    {
        return [
            'request_type'        => 'transaction_status',
            'init_transaction_id' => $this->getTransactionId(),
            'f_extended'          => '5'
        ];
    }

    /**
     * @param $data
     * @return CompletePurchaseResponse
     */
    public function sendData($data)
    {
        $response = $this->gateClient->statusRequest($data);

        return $this->response = new CompletePurchaseResponse($this, $response);
    }
}
