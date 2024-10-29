<?php

// Copyright (C) 2024 Ivan Stasiuk <ivan@stasi.uk>.
// Use of this source code is governed by a BSD-style
// license that can be found in the LICENSE file.

namespace BrokeYourBike\IntouchGroup;

use GuzzleHttp\ClientInterface;
use BrokeYourBike\ResolveUri\ResolveUriTrait;
use BrokeYourBike\IntouchGroup\Responses\CashinResponse;
use BrokeYourBike\IntouchGroup\Interfaces\ConfigInterface;
use BrokeYourBike\IntouchGroup\Interfaces\CashinInterface;
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

    public function cashin(CashinInterface $transaction): CashinResponse
    {
        $options = [
            \GuzzleHttp\RequestOptions::HEADERS => [
                'Accept' => 'application/json',
            ],
            \GuzzleHttp\RequestOptions::AUTH => [
                $this->config->getAuthUsername(),
                $this->config->getAuthPassword(),
            ],
            \GuzzleHttp\RequestOptions::JSON => [
                'login_api' => $this->config->getApiUsername(),
                'password_api' => $this->config->getApiPassword(),
                'service_id' => $transaction->getServiceId()->value,
                'partner_id' => $this->config->getPartnerId(),
                'partner_transaction_id' => $transaction->getPartnerTransactionId(),
                'amount' => $transaction->getAmount(),
                'recipient_phone_number' => $transaction->getRecipientPhone(),
                'callback_url' => $transaction->getCallbackURL(),
            ],
        ];

        $response = $this->httpClient->request(
            HttpMethodEnum::POST->value,
            (string) $this->resolveUriFor(rtrim($this->config->getUrl(), '/'), "/apidist/sec/{$this->config->getAgentId()}/cashin"),
            $options
        );

        return new CashinResponse($response);
    }

    public function status(string $partnerTransactionId): CashinResponse
    {
        $options = [
            \GuzzleHttp\RequestOptions::HEADERS => [
                'Accept' => 'application/json',
            ],
            \GuzzleHttp\RequestOptions::AUTH => [
                $this->config->getAuthUsername(),
                $this->config->getAuthPassword(),
            ],
            \GuzzleHttp\RequestOptions::JSON => [
                'login_api' => $this->config->getApiUsername(),
                'password_api' => $this->config->getApiPassword(),
                'partner_id' => $this->config->getPartnerId(),
                'partner_transaction_id' => $partnerTransactionId,
            ],
        ];

        $response = $this->httpClient->request(
            HttpMethodEnum::POST->value,
            (string) $this->resolveUriFor(rtrim($this->config->getUrl(), '/'), "/apidist/sec/{$this->config->getAgentId()}/check_status"),
            $options
        );

        return new CashinResponse($response);
    }
}
