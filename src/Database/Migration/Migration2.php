<?php

/**
 * Migration: 2
 * Started:   16/11/2026
 */

namespace Nails\EmailDrip\Database\Migration;

use Nails\Admin\Traits\Database\Migration\PermissionMap;
use Nails\Common\Interfaces;
use Nails\Common\Traits;
use Nails\EmailDrip\Admin\Permission;

/**
 * Class Migration2
 *
 * Repeatable because `feature/pre-new-admin` has no equivalent migration, so an app
 * arriving from that branch resumes above this number and would never run it.
 *
 * @package Nails\EmailDrip\Database\Migration
 */
class Migration2 implements Interfaces\Database\Migration\Repeatable
{
    use Traits\Database\Migration;
    use PermissionMap;

    // --------------------------------------------------------------------------

    const MAP = [
        'admin:emaildrip:campaign:manage' => Permission\Campaign\Browse::class,
        'admin:emaildrip:campaign:create' => Permission\Campaign\Create::class,
        'admin:emaildrip:campaign:edit'   => Permission\Campaign\Edit::class,
        'admin:emaildrip:campaign:delete' => Permission\Campaign\Delete::class,
    ];
}
