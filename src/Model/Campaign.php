<?php

/**
 * Email Drip Campaign model
 *
 * @package     Nails
 * @subpackage  module-email-drip
 * @category    Model
 * @author      Nails Dev Team
 * @link
 */

namespace Nails\EmailDrip\Model;

use Nails\Common\Model\Base;
use Nails\EmailDrip\Constants;

class Campaign extends Base
{
    const TABLE = NAILS_DB_PREFIX . 'email_drip_campaign';

    // --------------------------------------------------------------------------

    /**
     * Model constructor
     **/
    public function __construct()
    {
        parent::__construct();
        $this->addExpandableField([
            'trigger'   => 'emails',
            'type'      => self::EXPANDABLE_TYPE_MANY,
            'property'  => 'emails',
            'model'     => 'CampaignEmail',
            'provider'  => Constants::MODULE_SLUG,
            'id_column' => 'campaign_id',
        ]);
    }
}
