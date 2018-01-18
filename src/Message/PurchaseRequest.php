<?php

namespace Omnipay\TransactPro\Message;

use Omnipay\TransactPro\Message\PurchaseResponse;

/**
 * Class PurchaseRequest
 * @package Omnipay\TransactPro\Message
 */
class PurchaseRequest extends AbstractRequest
{
    /**
     * @return mixed
     * @throws \Omnipay\Common\Exception\InvalidCreditCardException
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function getData()
    {
        $this->validate('amount', 'currency', 'guid', 'password', 'apiUrl');
        $this->getCard()->validate();

        $data = $this->getBaseData();

        // TODO: merge data with custom purchase data

        return $data;
    }

    /**
     * @param mixed $data
     *
     * @return \Omnipay\Common\Message\ResponseInterface|PurchaseResponse
     */
    public function sendData($data)
    {
        $transactionId = 0;
        $card = $this->getCard();

        // Init transaction
        $init = $this->gateClient->init($data);
        $response = $init->getParsedResponse();

        if (isset($response['OK'])) {
            $transactionId = $response['OK'];
        }

        if (isset($response['RedirectOnsite'])) {
            $redirect = $response['RedirectOnsite'];

            return $this->response = new PurchaseResponse($this, [
                'success' => true,
                'transactionId' => $transactionId,
                'redirect' => $redirect
            ]);
        }

        // Start charging
        $chargeInit = $this->gateClient->charge(array(
            'f_extended'          => '5',
            'init_transaction_id' => $transactionId,
            'cc'                  => $card->getNumber(),
            'cvv'                 => $card->getCvv(),
            'expire'              => $card->getExpiryDate('m/y')
        ));
        $changeResponse = $chargeInit->getParsedResponse();

        // If is successful
        if ($chargeInit->isSuccessful()) {
            return $this->response = new PurchaseResponse($this, [
                'success' => true,
                'transactionId' => $transactionId,
                'redirect' => isset($changeResponse['RedirectOnsite']) ? $changeResponse['RedirectOnsite'] : false
            ]);
        }

        return $this->response = new PurchaseResponse($this, [
            'success' => false,
            'transactionId' => $transactionId
        ]);
    }
}
