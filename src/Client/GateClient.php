<?php

namespace Omnipay\TransactPro\Client;

use Omnipay\TransactPro\Client\Builders\Builder;
use Omnipay\TransactPro\Client\Builders\CancelDmsDataBuilder;
use Omnipay\TransactPro\Client\Builders\ChargeDataBuilder;
use Omnipay\TransactPro\Client\Builders\ChargeHoldDataBuilder;
use Omnipay\TransactPro\Client\Builders\ChargeRecurrentDataBuilder;
use Omnipay\TransactPro\Client\Builders\DoRecurrentCreditDataBuilder;
use Omnipay\TransactPro\Client\Builders\DoRecurrentP2PDataBuilder;
use Omnipay\TransactPro\Client\Builders\InitDataBuilder;
use Omnipay\TransactPro\Client\Builders\InitDmsDataBuilder;
use Omnipay\TransactPro\Client\Builders\InitP2PDataBuilder;
use Omnipay\TransactPro\Client\Builders\InitCreditDataBuilder;
use Omnipay\TransactPro\Client\Builders\DoP2PDataBuilder;
use Omnipay\TransactPro\Client\Builders\DoCreditDataBuilder;
use Omnipay\TransactPro\Client\Builders\InitRecurrentCreditDataBuilder;
use Omnipay\TransactPro\Client\Builders\InitRecurrentDataBuilder;
use Omnipay\TransactPro\Client\Builders\InitRecurrentP2PDataBuilder;
use Omnipay\TransactPro\Client\Builders\MakeHoldDataBuilder;
use Omnipay\TransactPro\Client\Builders\RefundDataBuilder;
use Omnipay\TransactPro\Client\Builders\StatusRequestDataBuilder;
use Omnipay\TransactPro\Client\Builders\AccessDataBuilder;
use Omnipay\TransactPro\Client\Builders\StatusRequestDataBuilderMerchantID;
use Omnipay\TransactPro\Client\Request\RequestExecutor;
use Omnipay\TransactPro\Client\Request\RequestExecutorInterface;

/**
 * Basic client of TransactPRO Gateway API
 *
 * @package Omnipay\TransactPro\Client
 */
class GateClient
{
    /**
     * @var array
     */
    private $accessData;

    /**
     * @var RequestExecutor
     */
    private $requestExecutor;

    /**
     * GateClient constructor.
     *
     * @param array                         $accessData
     * @param RequestExecutorInterface|null $requestExecutor
     */
    public function __construct(array $accessData, RequestExecutorInterface $requestExecutor = null)
    {
        $accessDataBuilder     = new AccessDataBuilder($accessData);
        $this->accessData      = $accessDataBuilder->build();
        $this->requestExecutor = $requestExecutor ? : new RequestExecutor($this->accessData['apiUrl'], $this->accessData['verifySSL']);
    }

    /**
     * @return array
     */
    public function getAccessData()
    {
        return $this->accessData;
    }

    /**
     * @return RequestExecutorInterface
     */
    public function getRequestExecutor()
    {
        return $this->requestExecutor;
    }

    /**
     * @docReference 2.2 INITIALIZING A TRANSACTION
     *
     * @param array $data
     *
     * @return Response\Response
     */
    public function init(array $data)
    {
        $buildData = $this->buildData(new InitDataBuilder($data));

        return $this->requestExecutor->executeRequest('init', $buildData);
    }

    /**
     * @docReference 2.4 COMPLETING A TRANSACTION
     *
     * @param array $data
     *
     * @return Response\Response
     */
    public function charge(array $data)
    {
        $buildData = $this->buildData(new ChargeDataBuilder($data));

        return $this->requestExecutor->executeRequest('charge', $buildData);
    }

    /**
     * @docReference 3.2 DUAL MESSAGE TRANSACTION
     *
     * @param array $data
     *
     * @return Response\Response
     */
    public function initDms(array $data)
    {
        $buildData = $this->buildData(new InitDmsDataBuilder($data));

        return $this->requestExecutor->executeRequest('init_dms', $buildData);
    }

    /**
     * @docReference 3.2 DUAL MESSAGE TRANSACTION
     *
     * @param array $data
     *
     * @return Response\Response
     */
    public function makeHold(array $data)
    {
        $buildData = $this->buildData(new MakeHoldDataBuilder($data));

        return $this->requestExecutor->executeRequest('make_hold', $buildData);
    }

    /**
     * @docReference 3.2 DUAL MESSAGE TRANSACTION
     *
     * @param array $data
     *
     * @return Response\Response
     */
    public function chargeHold(array $data)
    {
        $buildData = $this->buildData(new ChargeHoldDataBuilder($data));

        return $this->requestExecutor->executeRequest('charge_hold', $buildData);
    }

    /**
     * @docReference 3.2.1 HOW TO CANCEL DMS HOLD WITHOUT REFUNDS
     *
     * @param array $data
     *
     * @return Response\Response
     */
    public function cancelDms(array $data)
    {
        $buildData = $this->buildData(new CancelDmsDataBuilder($data));

        return $this->requestExecutor->executeRequest('cancel_dms', $buildData);
    }

    /**
     * @docReference 2.6 REFUNDS
     *
     * @param array $data
     *
     * @return Response\Response
     */
    public function refund(array $data)
    {
        $buildData = $this->buildData(new RefundDataBuilder($data));

        return $this->requestExecutor->executeRequest('refund', $buildData);
    }

    /**
     * @docReference 2.5.1 REQUESTING TRANSACTION STATUS
     *
     * @param array $data
     *
     * @return Response\Response
     */
    public function statusRequest(array $data)
    {
        $buildData = $this->buildData(new StatusRequestDataBuilder($data));

        return $this->requestExecutor->executeRequest('status_request', $buildData);
    }

    /**
     * @docReference 2.5.1 REQUESTING TRANSACTION STATUS
     *
     * @param array $data
     *
     * @return Response\Response
     */
    public function statusRequestMerchantID(array $data)
    {

        $buildData = $this->buildData(new StatusRequestDataBuilderMerchantID($data));

        return $this->requestExecutor->executeRequest('status_request', $buildData);

    }

    /**
     * @docReference 2.1.9 P2P TRANSACTIONS
     *
     * @param array $data
     *
     * @return Response\Response
     */
    public function initP2P(array $data)
    {
        $buildData = $this->buildData(new InitP2PDataBuilder($data));

        return $this->requestExecutor->executeRequest('init_p2p', $buildData);
    }

    /**
     * @docReference 2.1.9 P2P TRANSACTIONS
     *
     * @param array $data
     *
     * @return Response\Response
     */
    public function doP2P(array $data)
    {
        $buildData = $this->buildData(new DoP2PDataBuilder($data));

        return $this->requestExecutor->executeRequest('do_p2p', $buildData);
    }

    /**
     * @docReference 2.1.7 CREDIT TRANSACTIONS
     *
     * @param array $data
     *
     * @return Response\Response
     */
    public function initCredit(array $data)
    {
        $buildData = $this->buildData(new InitCreditDataBuilder($data));

        return $this->requestExecutor->executeRequest('init_credit', $buildData);
    }

    /**
     * @docReference 2.1.7 CREDIT TRANSACTIONS
     *
     * @param array $data
     *
     * @return Response\Response
     */
    public function doCredit(array $data)
    {
        $buildData = $this->buildData(new DoCreditDataBuilder($data));

        return $this->requestExecutor->executeRequest('do_credit', $buildData);
    }

    /**
     * @docReference 6.3 SUBSEQUENT RECURRENT TRANSACTIONS
     *
     * @param array $data
     *
     * @return Response\Response
     */
    public function initRecurrent(array $data)
    {
        $buildData = $this->buildData(new InitRecurrentDataBuilder($data));

        return $this->requestExecutor->executeRequest('init_recurrent', $buildData);
    }

    /**
     * @docReference 6.3 SUBSEQUENT RECURRENT TRANSACTIONS
     *
     * @param array $data
     *
     * @return Response\Response
     */
    public function chargeRecurrent(array $data)
    {
        $buildData = $this->buildData(new ChargeRecurrentDataBuilder($data));

        return $this->requestExecutor->executeRequest('charge_recurrent', $buildData);
    }

    /**
     * @docReference 6.3 SUBSEQUENT RECURRENT TRANSACTIONS
     *
     * @param array $data
     *
     * @return Response\Response
     */
    public function initRecurrentCredit(array $data)
    {
        $buildData = $this->buildData(new InitRecurrentCreditDataBuilder($data));

        return $this->requestExecutor->executeRequest('init_recurrent_credit', $buildData);
    }

    /**
     * @docReference 6.3 SUBSEQUENT RECURRENT TRANSACTIONS
     *
     * @param array $data
     *
     * @return Response\Response
     */
    public function doRecurrentCredit(array $data)
    {
        $buildData = $this->buildData(new DoRecurrentCreditDataBuilder($data));

        return $this->requestExecutor->executeRequest('do_recurrent_credit', $buildData);
    }

    /**
     * @docReference 6.3 SUBSEQUENT RECURRENT TRANSACTIONS
     *
     * @param array $data
     *
     * @return Response\Response
     */
    public function initRecurrentP2P(array $data)
    {
        $buildData = $this->buildData(new InitRecurrentP2PDataBuilder($data));

        return $this->requestExecutor->executeRequest('init_recurrent_p2p', $buildData);
    }

    /**
     * @docReference 6.3 SUBSEQUENT RECURRENT TRANSACTIONS
     *
     * @param array $data
     *
     * @return Response\Response
     */
    public function doRecurrentP2P(array $data)
    {
        $buildData = $this->buildData(new DoRecurrentP2PDataBuilder($data));

        return $this->requestExecutor->executeRequest('do_recurrent_p2p', $buildData);
    }

    /**
     * @docReference 6.3 SUBSEQUENT RECURRENT TRANSACTIONS
     *
     * @param array $data
     *
     * @return Response\Response
     */
    public function initStoreCardSms(array $data)
    {
        $buildData = $this->buildData(new InitDataBuilder($data));
        $response  = $this->requestExecutor->executeRequest('init_store_card_sms', $buildData);

        return $response;
    }

    /**
     * @docReference 6.3 SUBSEQUENT RECURRENT TRANSACTIONS
     *
     * @param array $data
     *
     * @return Response\Response
     */
    public function initStoreCardCredit(array $data)
    {
        $buildData = $this->buildData(new InitCreditDataBuilder($data));
        $response  = $this->requestExecutor->executeRequest('init_store_card_credit', $buildData);

        return $response;
    }

    /**
     * @docReference 6.3 SUBSEQUENT RECURRENT TRANSACTIONS
     *
     * @param array $data
     *
     * @return Response\Response
     */
    public function initStoreCardP2P(array $data)
    {
        $buildData = $this->buildData(new InitP2PDataBuilder($data));
        $response  = $this->requestExecutor->executeRequest('init_store_card_p2p', $buildData);

        return $response;
    }

    /**
     * @docReference 6.3 SUBSEQUENT RECURRENT TRANSACTIONS
     *
     * @param array $data
     *
     * @return Response\Response
     */
    public function storeCard(array $data)
    {
        $buildData = $this->buildData(new ChargeDataBuilder($data));
        $response  = $this->requestExecutor->executeRequest('store_card', $buildData);

        return $response;
    }

    /**
     * Build base data for requests
     *
     * @param Builder $builder
     *
     * @return array
     */
    private function buildData(Builder $builder)
    {
        $buildData = $builder->build();

        $buildData['guid'] = $this->accessData['guid'];
        $buildData['account_guid'] = $this->accessData['guid'];
        $buildData['pwd'] = $this->accessData['pwd'];

        return $buildData;
    }
}
