<?php

/**
 * Manages Campaign email logs
 *
 * @package     Nails
 * @subpackage  module-email-drip
 * @category    Model
 * @author      Nails Dev Team
 * @link
 */

namespace Nails\EmailDrip\Model;

use Nails\Common\Model\Base;

class CampaignEmailLog extends Base
{
    const TABLE = NAILS_DB_PREFIX . 'email_drip_campaign_email_log';
}
