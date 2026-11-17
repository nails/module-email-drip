<?php

namespace Nails\EmailDrip\Admin\Permission\Campaign;

use Nails\Admin\Interfaces\Permission;

class Browse implements Permission
{
    public function label(): string
    {
        return 'Can manage drip campaigns';
    }

    public function group(): string
    {
        return 'Drip Campaigns';
    }
}
