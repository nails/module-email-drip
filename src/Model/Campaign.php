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

class Campaign extends Base
{
    /**
     * Model constructor
     **/
    public function __construct()
    {
        parent::__construct();
        $this->table = NAILS_DB_PREFIX . 'email_drip_campaign';
        $this->addExpandableField([
            'trigger'   => 'emails',
            'type'      => self::EXPANDABLE_TYPE_MANY,
            'property'  => 'emails',
            'model'     => 'CampaignEmail',
            'provider'  => 'nailsapp/module-email-drip',
            'id_column' => 'campaign_id',
        ]);
    }
}
