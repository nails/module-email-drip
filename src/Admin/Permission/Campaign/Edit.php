<?php

namespace Nails\EmailDrip\Admin\Permission\Campaign;

use Nails\Admin\Interfaces\Permission;

class Edit implements Permission
{
    public function label(): string
    {
        return 'Can edit drip campaigns';
    }

    public function group(): string
    {
        return 'Drip Campaigns';
    }
}
