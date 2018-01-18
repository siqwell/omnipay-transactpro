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
        $this->validate('amount', 'currency', 'guid', 'password', 'description');

        if ($card = $this->getCard()) {
            $card->validate();
        }

        return $this->getBaseData();
    }

    /**
     * @param mixed $data
     *
     * @return \Omnipay\Common\Message\ResponseInterface|PurchaseResponse
     */
    public function sendData($data)
    {
        $card = $this->getCard();

        $response = null;
        $changeResponse = null;
        $error = null;
        $transactionId = 0;

        try {
            // Init transaction
            $init     = $this->gateClient->init($data);
            $response = $init->getParsedResponse();

            if (isset($response['OK'])) {
                $transactionId = $response['OK'];
            }

            // Redirect on gateway if needed
            if (isset($response['RedirectOnsite'])) {
                $redirect = $response['RedirectOnsite'];

                return $this->response = new PurchaseResponse($this, [
                    'success' => true,
                    'transactionId' => $transactionId,
                    'redirect' => $redirect
                ]);
            }

            if ($card) {
                // Start charging
                $chargeInit     = $this->gateClient->charge([
                    'f_extended' => '5',
                    'init_transaction_id' => $transactionId,
                    'cc' => $card->getNumber(),
                    'cvv' => $card->getCvv(),
                    'expire' => $card->getExpiryDate('m/y')
                ]);
                $changeResponse = $chargeInit->getParsedResponse();

                // If is successful
                if ($chargeInit->isSuccessful()) {
                    return $this->response = new PurchaseResponse($this, [
                        'success' => true,
                        'transactionId' => $transactionId,
                        'redirect' => isset($changeResponse['RedirectOnsite']) ? $changeResponse['RedirectOnsite'] : false
                    ]);
                }
            }
        } catch (\Exception $e) {
            $error = $e->getMessage();
        }

        // Build error
        if (!$error) {
            if ($changeResponse && isset($changeResponse['ERROR'])) {
                $error = $changeResponse['ERROR'];
            } elseif (isset($response['ERROR'])) {
                $error = $response['ERROR'];
            }
        }

        return $this->response = new PurchaseResponse($this, [
            'success' => false,
            'transactionId' => $transactionId,
            'error' => $error
        ]);
    }
}
