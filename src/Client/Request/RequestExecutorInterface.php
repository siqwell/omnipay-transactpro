<?php

namespace Omnipay\TransactPro\Client\Request;

use Omnipay\TransactPro\Client\Response\Response;

interface RequestExecutorInterface
{
    /**
     * @param string $url Gateway url
     * @param bool $verifySSL
     */
    public function __construct($url, $verifySSL);

    /**
     * @param string $action Action to execute
     * @param array $postData Data for sending
     * @return Response
     */
    public function executeRequest($action, array $postData);
} 