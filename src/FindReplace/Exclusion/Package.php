<?php

namespace Nails\EmailDrip\FindReplace\Exclusion;

use Nails\FindReplace\Interfaces\Exclusion;

class Package implements Exclusion
{
    public function hidden(): array
    {
        return [];
    }

    public function readOnly(): array
    {
        return [
            NAILS_DB_PREFIX . 'email_drip_campaign.segment',
            NAILS_DB_PREFIX . 'email_drip_campaign_email.trigger_event',
        ];
    }
}
