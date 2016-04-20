<?php

/**
 * Migration:   0
 * Started:     15/10/2015
 * Finalised:   15/10/2015
 *
 * @package     Nails
 * @subpackage  module-email-drip
 * @category    Database Migration
 * @author      Nails Dev Team
 * @link
 */

namespace Nails\Database\Migration\Nailsapp\ModuleEmailDrip;

use Nails\Common\Console\Migrate\Base;

class Migration0 extends Base
{
    /**
     * Execute the migration
     * @return Void
     */
    public function execute()
    {
        $this->query("
            CREATE TABLE `nails_email_drip_campaign` (
                `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                `segment_id` int(11) unsigned NOT NULL,
                `label` varchar(150) NOT NULL DEFAULT '',
                `description` text NOT NULL,
                `is_active` tinyint(1) unsigned NOT NULL DEFAULT '1',
                `last_run` datetime DEFAULT NULL,
                `created` datetime NOT NULL,
                `created_by` int(11) unsigned DEFAULT NULL,
                `modified` datetime NOT NULL,
                `modified_by` int(11) unsigned DEFAULT NULL,
                PRIMARY KEY (`id`),
                KEY `created_by` (`created_by`),
                KEY `modified_by` (`modified_by`),
                KEY `segment_id` (`segment_id`),
                CONSTRAINT `nails_email_drip_campaign_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `nails_user` (`id`) ON DELETE SET NULL,
                CONSTRAINT `nails_email_drip_campaign_ibfk_2` FOREIGN KEY (`modified_by`) REFERENCES `nails_user` (`id`) ON DELETE SET NULL,
                CONSTRAINT `nails_email_drip_campaign_ibfk_3` FOREIGN KEY (`segment_id`) REFERENCES `nails_email_drip_campaign_segment` (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
        $this->query("
            CREATE TABLE `nails_email_drip_campaign_email` (
                `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                `campaign_id` int(11) unsigned NOT NULL,
                `order` int(11) unsigned NOT NULL DEFAULT '0',
                `trigger_event` varchar(50) NOT NULL,
                `trigger_delay_interval` int(11) unsigned NOT NULL,
                `trigger_delay_unit` enum('DAY','WEEK','MONTH','YEAR') NOT NULL DEFAULT 'DAY',
                `subject` varchar(150) NOT NULL DEFAULT '',
                `body_html` text NOT NULL,
                `body_text` text NOT NULL,
                PRIMARY KEY (`id`),
                KEY `campaign_id` (`campaign_id`),
                CONSTRAINT `nails_email_drip_campaign_email_ibfk_1` FOREIGN KEY (`campaign_id`) REFERENCES `nails_email_drip_campaign` (`id`) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
        $this->query("
            CREATE TABLE `nails_email_drip_campaign_email_log` (
                `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                `campaign_email_id` int(11) unsigned NOT NULL,
                `user_id` int(11) unsigned NOT NULL,
                `created` datetime NOT NULL,
                PRIMARY KEY (`id`),
                KEY `campaign_email_id` (`campaign_email_id`), KEY `user_id` (`user_id`),
                CONSTRAINT `nails_email_drip_campaign_email_log_ibfk_1` FOREIGN KEY (`campaign_email_id`) REFERENCES `nails_email_drip_campaign_email` (`id`) ON DELETE CASCADE,
                CONSTRAINT `nails_email_drip_campaign_email_log_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `nails_user` (`id`) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
        $this->query("
            CREATE TABLE `nails_email_drip_campaign_segment` (
                `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                `label` varchar(150) NOT NULL DEFAULT '',
                `created` datetime NOT NULL,
                `created_by` int(11) unsigned DEFAULT NULL,
                `modified` datetime NOT NULL,
                `modified_by` int(11) unsigned DEFAULT NULL,
                PRIMARY KEY (`id`),
                KEY `created_by` (`created_by`),
                KEY `modified_by` (`modified_by`),
                CONSTRAINT `nails_email_drip_campaign_segment_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `nails_user` (`id`) ON DELETE SET NULL,
                CONSTRAINT `nails_email_drip_campaign_segment_ibfk_2` FOREIGN KEY (`modified_by`) REFERENCES `nails_user` (`id`) ON DELETE SET NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
        $this->query("
            CREATE TABLE `nails_email_drip_campaign_segment_rule` (
                `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                `segment_id` int(11) unsigned NOT NULL,
                `created` datetime NOT NULL,
                `created_by` int(11) unsigned DEFAULT NULL,
                `modified` datetime NOT NULL, `modified_by` int(11) unsigned DEFAULT NULL,
                PRIMARY KEY (`id`),
                KEY `created_by` (`created_by`),
                KEY `modified_by` (`modified_by`),
                KEY `segment_id` (`segment_id`),
                CONSTRAINT `nails_email_drip_campaign_segment_rule_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `nails_user` (`id`) ON DELETE SET NULL,
                CONSTRAINT `nails_email_drip_campaign_segment_rule_ibfk_2` FOREIGN KEY (`modified_by`) REFERENCES `nails_user` (`id`) ON DELETE SET NULL,
                CONSTRAINT `nails_email_drip_campaign_segment_rule_ibfk_3` FOREIGN KEY (`segment_id`) REFERENCES `nails_email_drip_campaign_segment` (`id`) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
    }
}
