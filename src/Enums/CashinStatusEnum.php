<?php

// Copyright (C) 2024 Ivan Stasiuk <ivan@stasi.uk>.
// Use of this source code is governed by a BSD-style
// license that can be found in the LICENSE file.

namespace BrokeYourBike\IntouchGroup\Enums;

/**
 * @author Ivan Stasiuk <ivan@stasi.uk>
 */
enum CashinStatusEnum: string
{
    // This status designates a successful and closed transaction at Touch level.
    case SUCCESSFUL = 'SUCCESSFUL';

    // This is a transaction for which InTouch has not yet obtained confirmation from the service partner. 
    // Its status can last up to 24 hours. A reconciliation procedure on D+1 with the same service partner allows the transaction status to be automatically cleared.
    case PENDING = 'PENDING';

    // This status designates a failed and closed transaction at the Touch level.
    case FAILED = 'FAILED';

    // Once a transaction is closed after a failure or success, its status changes to "Finished".
    case FINISHED = 'FINISHED';

    // No operation/transaction found.
    case NOTFOUND = 'NOTFOUND';
}
