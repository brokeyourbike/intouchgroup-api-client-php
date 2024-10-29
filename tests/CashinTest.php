<?php

// Copyright (C) 2024 Ivan Stasiuk <ivan@stasi.uk>.
// Use of this source code is governed by a BSD-style
// license that can be found in the LICENSE file.

namespace BrokeYourBike\IntouchGroup\Tests;

use Psr\Http\Message\ResponseInterface;
use BrokeYourBike\IntouchGroup\Responses\CashinResponse;
use BrokeYourBike\IntouchGroup\Interfaces\ConfigInterface;
use BrokeYourBike\IntouchGroup\Interfaces\CashinInterface;
use BrokeYourBike\IntouchGroup\Enums\CashinStatusEnum;
use BrokeYourBike\IntouchGroup\Client;

/**
 * @author Ivan Stasiuk <ivan@stasi.uk>
 */
class CashinTest extends TestCase
{
    /** @test */
    public function it_can_prepare_request(): void
    {
        $transaction = $this->getMockBuilder(CashinInterface::class)->getMock();

        /** @var CashinInterface $transaction */
        $this->assertInstanceOf(CashinInterface::class, $transaction);

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

        $requestResult = $api->Cashin($transaction);
        $this->assertInstanceOf(CashinResponse::class, $requestResult);
        $this->assertEquals(CashinStatusEnum::PENDING->value, $requestResult->status);
    }
}
