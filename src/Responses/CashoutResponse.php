<?php

// Copyright (C) 2024 Ivan Stasiuk <ivan@stasi.uk>.
// Use of this source code is governed by a BSD-style
// license that can be found in the LICENSE file.

namespace BrokeYourBike\IntouchGroup\Responses;

use BrokeYourBike\DataTransferObject\JsonResponse;

/**
 * @author Ivan Stasiuk <ivan@stasi.uk>
 */
class CashoutResponse extends JsonResponse
{
    public ?string $status;
    public ?string $service_id;
    public ?string $partner_transaction_id;
    public ?string $gu_transaction_id;
}
