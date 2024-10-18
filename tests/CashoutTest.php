<?php

// Copyright (C) 2024 Ivan Stasiuk <ivan@stasi.uk>.
// Use of this source code is governed by a BSD-style
// license that can be found in the LICENSE file.

namespace BrokeYourBike\IntouchGroup\Tests;

use Psr\Http\Message\ResponseInterface;
use BrokeYourBike\IntouchGroup\Responses\CashoutResponse;
use BrokeYourBike\IntouchGroup\Interfaces\ConfigInterface;
use BrokeYourBike\IntouchGroup\Interfaces\CashoutInterface;
use BrokeYourBike\IntouchGroup\Enums\CashoutStatusEnum;
use BrokeYourBike\IntouchGroup\Client;

/**
 * @author Ivan Stasiuk <ivan@stasi.uk>
 */
class CashoutTest extends TestCase
{
    /** @test */
    public function it_can_prepare_request(): void
    {
        $transaction = $this->getMockBuilder(CashoutInterface::class)->getMock();

        /** @var CashoutInterface $transaction */
        $this->assertInstanceOf(CashoutInterface::class, $transaction);

        $mockedConfig = $this->getMockBuilder(ConfigInterface::class)->getMock();
        $mockedConfig->method('getUrl')->willReturn('https://api.example/');

        $mockedResponse = $this->getMockBuilder(ResponseInterface::class)->getMock();
        $mockedResponse->method('getStatusCode')->willReturn(200);
        $mockedResponse->method('getBody')
            ->willReturn('  {
                "service_id": "CODE SU SERVICE",
                "gu_transaction_id": "1499360089225",
                "status": "PENDING",
                "transaction_date": "2017/07/06 16:54:49 PM",
                "recipient_phone_number": "XXXXXXXXX",
                "amount": 100,
                "partner_transaction_id": "15908685691625"
            }');

        /** @var \Mockery\MockInterface $mockedClient */
        $mockedClient = \Mockery::mock(\GuzzleHttp\Client::class);
        $mockedClient->shouldReceive('request')->once()->andReturn($mockedResponse);

        /**
         * @var ConfigInterface $mockedConfig
         * @var \GuzzleHttp\Client $mockedClient
         * */
        $api = new Client($mockedConfig, $mockedClient);

        $requestResult = $api->cashout($transaction);
        $this->assertInstanceOf(CashoutResponse::class, $requestResult);
        $this->assertEquals(CashoutStatusEnum::PENDING->value, $requestResult->status);
    }
}
