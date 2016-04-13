<?php

return array(
    'models' => array(
        'Campaign' => function () {
            if (class_exists('\App\EmailDrip\Model\Campaign')) {
                return new \App\EmailDrip\Model\Campaign();
            } else {
                return new \Nails\EmailDrip\Model\Campaign();
            }
        },
        'CampaignEmail' => function () {
            if (class_exists('\App\EmailDrip\Model\CampaignEmail')) {
                return new \App\EmailDrip\Model\CampaignEmail();
            } else {
                return new \Nails\EmailDrip\Model\CampaignEmail();
            }
        },
        'CampaignEmailLog' => function () {
            if (class_exists('\App\EmailDrip\Model\CampaignEmailLog')) {
                return new \App\EmailDrip\Model\CampaignEmailLog();
            } else {
                return new \Nails\EmailDrip\Model\CampaignEmailLog();
            }
        },
        'Segment' => function () {
            if (class_exists('\App\EmailDrip\Model\Segment')) {
                return new \App\EmailDrip\Model\Segment();
            } else {
                return new \Nails\EmailDrip\Model\Segment();
            }
        }
    )
);
