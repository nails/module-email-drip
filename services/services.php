<?php

return array(
    'models' => array(
        'Campaign' => function () {
            return new \Nails\EmailDrip\Model\Campaign();
        }
    ),
    'factories' => array(
        'Email' => function () {
            return new \Nails\EmailDrip\Model\Email();
        },
        'Rule' => function () {
            return new \Nails\EmailDrip\Model\Rule();
        },
        'ShortCode' => function () {
            return new \Nails\EmailDrip\Model\ShortCode();
        }
    )
);
