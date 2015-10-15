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

use Nails\Factory;
use Nails\Common\Model\Base;

class Campaign extends Base
{
    /**
     * The table where campaign emails are stored
     * @var  string
     */
    const TABLE_EMAIL = NAILS_DB_PREFIX . 'email_drip_campaign_email';

    // --------------------------------------------------------------------------

    /**
     * Model constructor
     **/
    public function __construct()
    {
        parent::__construct();
        $this->table = NAILS_DB_PREFIX . 'email_drip_campaign';
        $this->tablePrefix = 'edc';
    }

    // --------------------------------------------------------------------------

    /**
     * Returns all content objects
     * @param null $page The page to return
     * @param null $perPage The number of objects per page
     * @param array $data Data to pass to _getcount_common
     * @param bool|false $includeDeleted Whether to include deleted results
     * @param string $_caller Internal flag of calling method
     * @return array
     */
    public function get_all(
        $page = null,
        $perPage = null,
        $data = array(),
        $includeDeleted = false,
        $_caller = 'GET_ALL'
    ) {

        $aCampaigns = parent::get_all($page, $perPage, $data, $includeDeleted, $_caller);

        if (!empty($aCampaigns)) {
            if (!empty($data['include_emails'])) {
                $this->getEmailsForCampaigns($aCampaigns);
            }
        }

        return $aCampaigns;
    }

    // --------------------------------------------------------------------------

    private function getEmailsForCampaigns(&$aCampaigns)
    {
        $aCampaignIds   = array();
        $aCampaignIdMap = array();
        $iNumCampaigns  = count($aCampaigns);

        //  Extract all the campaign ID and create a map so we can easily merge in emails later
        for ($i=0; $i < $iNumCampaigns; $i++) {

            $aCampaignIds[] = $aCampaigns[$i]->id;
            $aCampaignIdMap[$aCampaigns[$i]->id] = $i;
            $aCampaigns[$i]->emails = array();
        }

        //  Get all the items from the DB
        $this->db->select(
            'id,campaign_id,trigger_event,trigger_delay_interval,trigger_delay_unit,subject,body_html,body_text'
        );
        $this->db->where_in('campaign_id', $aCampaignIds);
        $this->db->order_by('order');
        $oResult = $this->db->get(self::TABLE_EMAIL);

        //  Add to individual campaigns
        while ($oRow = $oResult->_fetch_object()) {

            if (isset($aCampaignIdMap[$oRow->campaign_id])) {

                $iIndex = $aCampaignIdMap[$oRow->campaign_id];

                $oEmail = Factory::factory('Email', 'nailsapp/module-email-drip');
                $oEmail->setSubject($oRow->subject);
                $oEmail->setBody($oRow->body_html, 'HTML');
                $oEmail->setBody($oRow->body_text, 'TEXT');
                $oEmail->setTriggerEvent($oRow->trigger_event);
                $oEmail->setTriggerDelay((int) $oRow->trigger_delay_interval, $oRow->trigger_delay_unit);

                $aCampaigns[$iIndex]->emails[] = $oEmail;
            }
        }
    }

    // --------------------------------------------------------------------------

    /**
     * Returns an item of featured content by its ID
     * @param int $iId The Id of the content to return
     * @param array $aData Data to pass to _getcount_common
     * @return mixed
     */
    public function get_by_id($iId, $aData = array())
    {
        $aData['include_emails'] = true;
        return parent::get_by_id($iId, $aData);
    }
}
