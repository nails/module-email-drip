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
        $this->table       = NAILS_DB_PREFIX . 'email_drip_campaign';
        $this->tablePrefix = 'edc';
    }

    // --------------------------------------------------------------------------

    /**
     * Returns all content objects
     * @param null       $page            The page to return
     * @param null       $iPerPage        The number of objects per page
     * @param array      $aData           Data to pass to _getcount_common
     * @param bool|false $bIncludeDeleted Whether to include deleted results
     * @return array
     */
    public function getAll($iPage = null, $iPerPage = null, $aData = array(), $bIncludeDeleted = false)
    {
        $aItems = parent::getAll($iPage, $iPerPage, $aData, $bIncludeDeleted);

        if (!empty($aItems)) {
            if (!empty($aData['includeAll']) || !empty($aData['includeEmails'])) {
                $this->getManyAssociatedItems(
                    $aItems,
                    'email',
                    'campaign_id',
                    'CampaignEmail',
                    'nailsapp/module-email-drip'
                );
            }
        }

        return $aItems;
    }
}
