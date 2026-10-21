<?php

namespace Tests\FindReplace\Exclusion;

use Nails\EmailDrip\FindReplace\Exclusion\Package;
use PHPUnit\Framework\TestCase;

class PackageTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        if (!defined('NAILS_DB_PREFIX')) {
            define('NAILS_DB_PREFIX', 'nails_');
        }
    }

    public function testHidden(): void
    {
        self::assertSame(
            [],
            (new Package())->hidden()
        );
    }

    public function testReadOnly(): void
    {
        self::assertSame(
            [
                NAILS_DB_PREFIX . 'email_drip_campaign.segment',
                NAILS_DB_PREFIX . 'email_drip_campaign_email.trigger_event',
            ],
            (new Package())->readOnly()
        );
    }
}
