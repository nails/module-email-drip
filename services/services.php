<?php

use Nails\EmailDrip\Service;
use Nails\EmailDrip\Model;

return [
    'services' => [
        'Segment' => function (): Service\Segment {
            if (class_exists('\App\EmailDrip\Service\Segment')) {
                return new \App\EmailDrip\Service\Segment();
            } else {
                return new Service\Segment();
            }
        },
    ],
    'models'   => [
        'Campaign'         => function (): Model\Campaign {
            if (class_exists('\App\EmailDrip\Model\Campaign')) {
                return new \App\EmailDrip\Model\Campaign();
            } else {
                return new Model\Campaign();
            }
        },
        'CampaignEmail'    => function (): Model\CampaignEmail {
            if (class_exists('\App\EmailDrip\Model\CampaignEmail')) {
                return new \App\EmailDrip\Model\CampaignEmail();
            } else {
                return new Model\CampaignEmail();
            }
        },
        'CampaignEmailLog' => function (): Model\CampaignEmailLog {
            if (class_exists('\App\EmailDrip\Model\CampaignEmailLog')) {
                return new \App\EmailDrip\Model\CampaignEmailLog();
            } else {
                return new Model\CampaignEmailLog();
            }
        },
    ],
];
