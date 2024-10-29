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
class CashinStatusTest extends TestCase
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
            ->willReturn('{"status":"NOTFOUND","description":"No operation/transaction found for this PartnerNum and PartnerId"}');

        /** @var \Mockery\MockInterface $mockedClient */
        $mockedClient = \Mockery::mock(\GuzzleHttp\Client::class);
        $mockedClient->shouldReceive('request')->once()->andReturn($mockedResponse);

        /**
         * @var ConfigInterface $mockedConfig
         * @var \GuzzleHttp\Client $mockedClient
         * */
        $api = new Client($mockedConfig, $mockedClient);

        $requestResult = $api->status('15908685691625');
        $this->assertInstanceOf(CashinResponse::class, $requestResult);
        $this->assertEquals(CashinStatusEnum::NOTFOUND->value, $requestResult->status);
    }
}
