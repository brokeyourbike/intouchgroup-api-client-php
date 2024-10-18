<?php

// Copyright (C) 2024 Ivan Stasiuk <ivan@stasi.uk>.
// Use of this source code is governed by a BSD-style
// license that can be found in the LICENSE file.

namespace BrokeYourBike\IntouchGroup\Interfaces;

use BrokeYourBike\IntouchGroup\Enums\ChannelEnum;

/**
 * @author Ivan Stasiuk <ivan@stasi.uk>
 */
interface CashoutInterface
{
    public function getServiceId(): string;
    public function getPartnerTransactionId(): string;
    public function getRecipientPhone(): string;
    public function getAmount(): float;
    public function getCallbackURL(): float;
}
