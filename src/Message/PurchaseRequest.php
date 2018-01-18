<?php

namespace Omnipay\TransactPro\Message;

use Omnipay\TransactPro\Client\Response\Response;
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
     * @return array|\Omnipay\TransactPro\Message\PurchaseResponse
     */
    public function sendData($data)
    {
        $card = $this->getCard();

        try {
            $transaction = $this->initTransaction($data, $card);

            if ($transaction instanceof PurchaseResponse) {
                return $transaction;
            }

            return $this->fail($transaction);
        } catch (\Exception $e) {
            return $this->fail([
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * @param $data
     * @param $card
     *
     * @return Response|\Omnipay\TransactPro\Message\PurchaseResponse
     */
    protected function initTransaction($data, $card)
    {
        $transaction = null;

        /** @var Response $init */
        $init = $this->gateClient->init($data);

        if ($init->isSuccessful()) {
            $transaction = $init->getTransactionId();
        }

        if ($redirect = $init->getRedirectUrl()) {
            return $this->success([
                'transactionId' => $transaction,
                'redirect' => $redirect
            ]);
        }

        if ($init->isSuccessful()) {
            return $this->charge([
                'transactionId' => $transaction,
                'redirect' => false
            ], $card);
        }

        return $init;
    }

    /**
     * @param $transaction
     * @param $card
     *
     * @return Response|\Omnipay\TransactPro\Message\PurchaseResponse
     */
    protected function charge($transaction, $card)
    {
        /** @var Response $charge */
        $charge = $this->gateClient->charge([
            'f_extended'          => '5',
            'init_transaction_id' => $transaction,
            'cc'                  => $card->getNumber(),
            'cvv'                 => $card->getCvv(),
            'expire'              => $card->getExpiryDate('m/y')
        ]);

        if ($charge->isSuccessful()) {
            return $this->success([
                'transactionId' => $transaction,
                'redirect' => $charge->getRedirectUrl()
            ]);
        }

        return $charge;
    }

    /**
     * @param $data
     *
     * @return \Omnipay\TransactPro\Message\PurchaseResponse
     */
    protected function success($data = [])
    {
        return $this->response = new PurchaseResponse($this, array_merge([
            'success' => true
        ], $data));
    }

    /**
     * @param array $data
     *
     * @return \Omnipay\TransactPro\Message\PurchaseResponse
     */
    protected function fail($data = [])
    {
        if ($data instanceof Response) {
            /** @var Response $data */
            return $this->fail([
                'error' => $data->getErrorMessage() ?? $data->getResponseContent()
            ]);
        }

        if (!is_array($data)) {
            $data = [
                'error' => 'Something went wrong'
            ];
        }

        return $this->response = new PurchaseResponse($this, array_merge([
            'success' => false
        ], $data));
    }
}
