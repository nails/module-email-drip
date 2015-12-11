<?php

/**
 * Manage drip campaigns
 *
 * @package     Nails
 * @subpackage  module-email-drip
 * @category    Controller
 * @author      Nails Dev Team
 * @link
 */

namespace Nails\Admin\EmailDrip;

use Nails\Factory;
use Nails\Admin\Helper;
use Nails\EmailDrip\Controller\BaseAdmin;

class Campaign extends BaseAdmin
{
    /**
     * Announces this controller's navGroups
     * @return stdClass
     */
    public static function announce()
    {
        if (userHasPermission('admin:emaildrip:campaign:manage')) {

            $oNavGroup = Factory::factory('Nav', 'nailsapp/module-admin');
            $oNavGroup->setLabel('Email');
            $oNavGroup->addAction('Manage Drip Campaigns');

            return $oNavGroup;
        }
    }

    // --------------------------------------------------------------------------

    /**
     * Returns an array of extra permissions for this controller
     * @return array
     */
    public static function permissions()
    {
        $permissions = parent::permissions();

        $permissions['manage'] = 'Can manage drip campaigns';
        $permissions['create'] = 'Can create drip campaigns';
        $permissions['edit']   = 'Can edit drip campaigns';
        $permissions['delete'] = 'Can delete drip campaigns';

        return $permissions;
    }

    // --------------------------------------------------------------------------

    /**
     * Browse drip campaigns
     * @return void
     */
    public function index()
    {
        if (!userHasPermission('admin:emaildrip:campaign:manage')) {

            unauthorised();
        }

        // --------------------------------------------------------------------------

        $oCampaignModel = Factory::model('Campaign', 'nailsapp/module-email-drip');
        $sTablePrefix   =  $oCampaignModel->getTablePrefix();

        // --------------------------------------------------------------------------

        //  Set method info
        $this->data['page']->title = 'Drip Campaigns';

        // --------------------------------------------------------------------------

        //  Get pagination and search/sort variables
        $page      = $this->input->get('page')      ? $this->input->get('page')      : 0;
        $perPage   = $this->input->get('perPage')   ? $this->input->get('perPage')   : 50;
        $sortOn    = $this->input->get('sortOn')    ? $this->input->get('sortOn')    : $sTablePrefix . '.created';
        $sortOrder = $this->input->get('sortOrder') ? $this->input->get('sortOrder') : 'desc';
        $keywords  = $this->input->get('keywords')  ? $this->input->get('keywords')  : '';

        // --------------------------------------------------------------------------

        //  Define the sortable columns
        $sortColumns = array(
            $sTablePrefix . '.created'  => 'Created Date',
            $sTablePrefix . '.modified' => 'Modified Date',
            $sTablePrefix . '.quote_by' => 'Quotee'
        );

        // --------------------------------------------------------------------------

        //  Define the $data variable for the queries
        $data = array(
            'sort' => array(
                array($sortOn, $sortOrder)
            ),
            'keywords' => $keywords
        );

        //  Get the items for the page
        $totalRows               = $oCampaignModel->countAll($data);
        $this->data['campaigns'] = $oCampaignModel->getAll($page, $perPage, $data);

        //  Set Search and Pagination objects for the view
        $this->data['search']     = Helper::searchObject(true, $sortColumns, $sortOn, $sortOrder, $perPage, $keywords);
        $this->data['pagination'] = Helper::paginationObject($page, $perPage, $totalRows);

        //  Add a header button
        if (userHasPermission('admin:emaildrip:campaign:create')) {

            Helper::addHeaderButton(
                'admin/emaildrip/campaign/create',
                'Create Drip Campaign'
            );
        }

        // --------------------------------------------------------------------------

        Helper::loadView('index');
    }

    // --------------------------------------------------------------------------

    /**
     * Create a new drip campaign
     * @return void
     */
    public function create()
    {
        if (!userHasPermission('admin:emaildrip:campaign:create')) {

            unauthorised();
        }

        // --------------------------------------------------------------------------

        //  Page Title
        $this->data['page']->title = 'Create Drip Campaign';

        // --------------------------------------------------------------------------

        if ($this->input->post()) {

            $oFormValidation = Factory::service('FormValidation');
            $oFormValidation->set_rules('quote', '', 'xss_clean|required');
            $oFormValidation->set_rules('quote_by', '', 'xss_clean|required');
            $oFormValidation->set_rules('quote_dated', '', 'xss_clean|required');

            $oFormValidation->set_message('required', lang('fv_required'));

            if ($oFormValidation->run()) {

                $data                = array();
                $data['quote']       = $this->input->post('quote');
                $data['quote_by']    = $this->input->post('quote_by');
                $data['quote_dated'] = $this->input->post('quote_dated');

                $oCampaignModel = Factory::model('Campaign', 'nailsapp/module-email-drip');

                if ($oCampaignModel->create($data)) {

                    $this->session->set_flashdata('success', 'Successfully created drip campaign.');
                    redirect('admin/emaildrip/campaign/index');

                } else {

                    $this->data['error'] = 'Failed to create drip campaign. ' . $oCampaignModel->lastError();
                }

            } else {

                $this->data['error'] = lang('fv_there_were_errors');
            }
        }

        // --------------------------------------------------------------------------

        library('KNOCKOUT');
        $this->asset->load('nails.admin.emaildrip.campaign.min.js', 'NAILS');
        $this->asset->inline(
            'ko.applyBindings(new dripCampaignEdit([]));',
            'JS'
        );

        Helper::loadView('edit');
    }

    // --------------------------------------------------------------------------

    /**
     * Edit a drip campaign
     * @return void
     */
    public function edit()
    {
        if (!userHasPermission('admin:emaildrip:campaign:edit')) {

            unauthorised();
        }

        // --------------------------------------------------------------------------

        $oCampaignModel = Factory::model('Campaign', 'nailsapp/module-email-drip');

        $this->data['campaign'] = $oCampaignModel->getById($this->uri->segment(5));

        if (!$this->data['campaign']) {

            show_404();
        }

        // --------------------------------------------------------------------------

        //  Page Title
        $this->data['page']->title = 'Edit Drip Campaign';

        // --------------------------------------------------------------------------

        if ($this->input->post()) {

            $oFormValidation = Factory::service('FormValidation');
            $oFormValidation->set_rules('quote', '', 'xss_clean|required');
            $oFormValidation->set_rules('quote_by', '', 'xss_clean|required');
            $oFormValidation->set_rules('quote_dated', '', 'xss_clean|required');

            $oFormValidation->set_message('required', lang('fv_required'));

            if ($oFormValidation->run()) {

                $data                = array();
                $data['quote']       = $this->input->post('quote');
                $data['quote_by']    = $this->input->post('quote_by');
                $data['quote_dated'] = $this->input->post('quote_dated');

                if ($oCampaignModel->update($this->data['campaign']->id, $data)) {

                    $this->session->set_flashdata('success', 'Successfully updated drip campaign.');
                    redirect('admin/emaildrip/campaign/index');

                } else {

                    $this->data['error'] = 'Failed to update campaign. ' . $oCampaignModel->lastError();
                }

            } else {

                $this->data['error'] = lang('fv_there_were_errors');
            }
        }

        // --------------------------------------------------------------------------

        library('KNOCKOUT');
        $this->asset->load('nails.admin.emaildrip.campaign.min.js', 'NAILS');
        $this->asset->inline(
            'ko.applyBindings(new dripCampaignEdit(' . json_encode($this->data['campaign']->emails) . '));',
            'JS'
        );

        Helper::loadView('edit');
    }

    // --------------------------------------------------------------------------

    /**
     * Delete a drip campaign
     * @return void
     */
    public function delete()
    {
        if (!userHasPermission('admin:emaildrip:campaign:delete')) {

            unauthorised();
        }

        // --------------------------------------------------------------------------

        $oCampaignModel = Factory::model('Campaign', 'nailsapp/module-email-drip');

        $oCampaign = $oCampaignModel->getById($this->uri->segment(5));

        if (!$oCampaign) {

            show_404();
        }

        // --------------------------------------------------------------------------

        if ($oCampaignModel->delete($oCampaign->id)) {

            $this->session->set_flashdata('success', 'Successfully deleted campaign.');

        } else {

            $this->session->set_flashdata('error', 'Failed to delete campaign. ' . $oCampaignModel->lastError());
        }

        // --------------------------------------------------------------------------

        redirect('admin/emaildrip/campaign/index');
    }
}
