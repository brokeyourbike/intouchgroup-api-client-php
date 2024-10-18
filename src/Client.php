<?php

// Copyright (C) 2024 Ivan Stasiuk <ivan@stasi.uk>.
// Use of this source code is governed by a BSD-style
// license that can be found in the LICENSE file.

namespace BrokeYourBike\IntouchGroup;

use GuzzleHttp\ClientInterface;
use BrokeYourBike\ResolveUri\ResolveUriTrait;
use BrokeYourBike\IntouchGroup\Responses\CashoutResponse;
use BrokeYourBike\IntouchGroup\Interfaces\ConfigInterface;
use BrokeYourBike\IntouchGroup\Interfaces\CashoutInterface;
use BrokeYourBike\HttpEnums\HttpMethodEnum;
use BrokeYourBike\HttpClient\HttpClientTrait;
use BrokeYourBike\HttpClient\HttpClientInterface;
use BrokeYourBike\HasSourceModel\HasSourceModelTrait;

/**
 * @author Ivan Stasiuk <ivan@stasi.uk>
 */
class Client implements HttpClientInterface
{
    use HttpClientTrait;
    use ResolveUriTrait;
    use HasSourceModelTrait;

    private ConfigInterface $config;

    public function __construct(ConfigInterface $config, ClientInterface $httpClient)
    {
        $this->config = $config;
        $this->httpClient = $httpClient;
    }

    public function getConfig(): ConfigInterface
    {
        return $this->config;
    }

    public function cashout(CashoutInterface $transaction): CashoutResponse
    {
        $options = [
            \GuzzleHttp\RequestOptions::HEADERS => [
                'Accept' => 'application/json',
            ],
            \GuzzleHttp\RequestOptions::AUTH => [
                $this->config->getUsername(),
                $this->config->getPassword(),
            ],
            \GuzzleHttp\RequestOptions::JSON => [
                'login_api' => $this->config->getUsername(),
                'password_api' => $this->config->getPassword(),
                'service_id' => $transaction->getServiceId(),
                'partner_id' => $this->config->getPartnerId(),
                'partner_transaction_id' => $transaction->getPartnerTransactionId(),
                'amount' => $transaction->getAmount(),
                'recipient_phone_number' => $transaction->getRecipientPhone(),
                'callback_url' => $transaction->getCallbackURL(),
            ],
        ];

        $response = $this->httpClient->request(
            HttpMethodEnum::POST->value,
            (string) $this->resolveUriFor(rtrim($this->config->getUrl(), '/'), '/apidist/sec/agency_code/cashout_request'),
            $options
        );

        return new CashoutResponse($response);
    }
}
