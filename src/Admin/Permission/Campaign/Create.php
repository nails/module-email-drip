<?php

namespace Nails\EmailDrip\Admin\Permission\Campaign;

use Nails\Admin\Interfaces\Permission;

class Create implements Permission
{
    public function label(): string
    {
        return 'Can create drip campaigns';
    }

    public function group(): string
    {
        return 'Drip Campaigns';
    }
}
