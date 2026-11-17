<?php

namespace Nails\EmailDrip\Admin\Permission\Campaign;

use Nails\Admin\Interfaces\Permission;

class Delete implements Permission
{
    public function label(): string
    {
        return 'Can delete drip campaigns';
    }

    public function group(): string
    {
        return 'Drip Campaigns';
    }
}
