<?php

/**
 * Migration:   1
 * Started:     13/04/2016
 * Finalised:
 *
 * @package     Nails
 * @subpackage  module-email-drip
 * @category    Database Migration
 * @author      Nails Dev Team
 * @link
 */

namespace Nails\Database\Migration\Nailsapp\ModuleEmailDrip;

use Nails\Common\Console\Migrate\Base;

class Migration1 extends Base
{
    /**
     * Execute the migration
     * @return Void
     */
    public function execute()
    {
        $this->query("ALTER TABLE `{{NAILS_DB_PREFIX}}email_drip_campaign` DROP FOREIGN KEY `{{NAILS_DB_PREFIX}}email_drip_campaign_ibfk_3`;");
        $this->query("ALTER TABLE `{{NAILS_DB_PREFIX}}email_drip_campaign` CHANGE `segment_id` `segment` VARCHAR(50)  NOT NULL  DEFAULT '';");
        $this->query("DROP TABLE `{{NAILS_DB_PREFIX}}email_drip_campaign_segment_rule`;");
        $this->query("DROP TABLE `{{NAILS_DB_PREFIX}}email_drip_campaign_segment`;");
        $this->query("ALTER TABLE `{{NAILS_DB_PREFIX}}email_drip_campaign_email` ADD `created` DATETIME  NOT NULL  AFTER `body_text`;");
        $this->query("ALTER TABLE `{{NAILS_DB_PREFIX}}email_drip_campaign_email` ADD `created_by` INT(11)  UNSIGNED  NULL  DEFAULT NULL  AFTER `created`;");
        $this->query("ALTER TABLE `{{NAILS_DB_PREFIX}}email_drip_campaign_email` ADD `modified` DATETIME  NULL  AFTER `created_by`;");
        $this->query("ALTER TABLE `{{NAILS_DB_PREFIX}}email_drip_campaign_email` ADD `modified_by` INT(11)  UNSIGNED  NULL  DEFAULT NULL  AFTER `modified`;");
        $this->query("ALTER TABLE `{{NAILS_DB_PREFIX}}email_drip_campaign_email` ADD FOREIGN KEY (`created_by`) REFERENCES `nails_user` (`id`) ON DELETE SET NULL;");
        $this->query("ALTER TABLE `{{NAILS_DB_PREFIX}}email_drip_campaign_email` ADD FOREIGN KEY (`modified_by`) REFERENCES `nails_user` (`id`) ON DELETE SET NULL;");
        $this->query("ALTER TABLE `{{NAILS_DB_PREFIX}}email_drip_campaign_email_log` ADD `created_by` INT(11)  UNSIGNED  NULL  DEFAULT NULL  AFTER `created`;");
        $this->query("ALTER TABLE `{{NAILS_DB_PREFIX}}email_drip_campaign_email_log` ADD `modified` DATETIME  NOT NULL  AFTER `created_by`;");
        $this->query("ALTER TABLE `{{NAILS_DB_PREFIX}}email_drip_campaign_email_log` ADD `modified_by` INT(11)  UNSIGNED  NULL  DEFAULT NULL  AFTER `modified`;");
        $this->query("ALTER TABLE `{{NAILS_DB_PREFIX}}email_drip_campaign_email_log` ADD FOREIGN KEY (`created_by`) REFERENCES `nails_user` (`id`) ON DELETE SET NULL;");
        $this->query("ALTER TABLE `{{NAILS_DB_PREFIX}}email_drip_campaign_email_log` ADD FOREIGN KEY (`modified_by`) REFERENCES `nails_user` (`id`) ON DELETE SET NULL;");

    }
}
