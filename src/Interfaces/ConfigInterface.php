<?php

// Copyright (C) 2024 Ivan Stasiuk <ivan@stasi.uk>.
// Use of this source code is governed by a BSD-style
// license that can be found in the LICENSE file.

namespace BrokeYourBike\IntouchGroup\Interfaces;

/**
 * @author Ivan Stasiuk <ivan@stasi.uk>
 */
interface ConfigInterface
{
    public function getUrl(): string;
    public function getAuthUsername(): string;
    public function getAuthPassword(): string;
    public function getApiUsername(): string;
    public function getApiPassword(): string;
    public function getAgentId(): string;
    public function getPartnerId(): string;
}
