<?php

return array(
    'models' => array(
        'Campaign' => function () {
            if (class_exists('\App\EmailDrip\Model\Campaign')) {
                return new \App\EmailDrip\Model\Campaign();
            } else {
                return new \Nails\EmailDrip\Model\Campaign();
            }
        }
    ),
    'factories' => array(
        'Email' => function () {
            if (class_exists('\App\EmailDrip\Model\Email')) {
                return new \App\EmailDrip\Model\Email();
            } else {
                return new \Nails\EmailDrip\Model\Email();
            }
        },
        'Rule' => function () {
            if (class_exists('\App\EmailDrip\Model\Rule')) {
                return new \App\EmailDrip\Model\Rule();
            } else {
                return new \Nails\EmailDrip\Model\Rule();
            }
        },
        'ShortCode' => function () {
            if (class_exists('\App\EmailDrip\Model\ShortCode')) {
                return new \App\EmailDrip\Model\ShortCode();
            } else {
                return new \Nails\EmailDrip\Model\ShortCode();
            }
        }
    )
);
