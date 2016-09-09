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
        $sTableAlias   =  $oCampaignModel->getTableAlias();

        // --------------------------------------------------------------------------

        //  Set method info
        $this->data['page']->title = 'Drip Campaigns';

        // --------------------------------------------------------------------------

        //  Get pagination and search/sort variables
        $page      = $this->input->get('page')      ? $this->input->get('page')      : 0;
        $perPage   = $this->input->get('perPage')   ? $this->input->get('perPage')   : 50;
        $sortOn    = $this->input->get('sortOn')    ? $this->input->get('sortOn')    : $sTableAlias . '.label';
        $sortOrder = $this->input->get('sortOrder') ? $this->input->get('sortOrder') : 'desc';
        $keywords  = $this->input->get('keywords')  ? $this->input->get('keywords')  : '';

        // --------------------------------------------------------------------------

        //  Define the sortable columns
        $sortColumns = array(
            $sTableAlias . '.created'  => 'Created Date',
            $sTableAlias . '.modified' => 'Modified Date',
            $sTableAlias . '.label'    => 'label'
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

        $oCampaignModel = Factory::model('Campaign', 'nailsapp/module-email-drip');

        // --------------------------------------------------------------------------

        //  Page Title
        $this->data['page']->title = 'Create Drip Campaign';

        // --------------------------------------------------------------------------

        if ($this->input->post()) {
            if ($this->formValidation()) {

                if ($oCampaignModel->create($this->getPostObject())) {

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

        $this->loadViewData();
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

        // --------------------------------------------------------------------------

        $this->data['campaign'] = $oCampaignModel->getById(
            $this->uri->segment(5),
            array(
                'includeEmails' => true
            )
        );

        if (!$this->data['campaign']) {
            show_404();
        }

        // --------------------------------------------------------------------------

        //  Page Title
        $this->data['page']->title = 'Edit Drip Campaign';

        // --------------------------------------------------------------------------

        if ($this->input->post()) {
            if ($this->formValidation()) {

                if ($oCampaignModel->update($this->data['campaign']->id, $this->getPostObject())) {

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

        $this->loadViewData($this->data['campaign']);
        Helper::loadView('edit');
    }

    // --------------------------------------------------------------------------

    protected function loadViewData($oItem = null)
    {
        //  Load services
        $oAsset        = Factory::service('Asset');
        $oSegmentModel = Factory::model('Segment', 'nailsapp/module-email-drip');

        //  Load Segments
        $this->data['segments'] = $oSegmentModel->getAllFlat();

        //  Load assets
        $aEmails = $oItem ? $oItem->email->data : array();

        $oAsset->load('admin.campaign.edit.min.js', 'nailsapp/module-email-drip');
        $oAsset->inline(
            'ko.applyBindings(new dripCampaignEdit(' . json_encode($aEmails) . '));',
            'JS'
        );
    }

    // --------------------------------------------------------------------------

    /**
     * Runs form validation
     * @return boolean
     */
    protected function formValidation()
    {
        $oFormValidation = Factory::service('FormValidation');

        $oFormValidation->set_rules('quote', '', '');

        $oFormValidation->set_message('required', lang('fv_required'));

        return $oFormValidation->run();
    }

    // --------------------------------------------------------------------------

    public function getPostObject()
    {
        dumpanddie($_POST);
        return array(
            'foo'       => $this->input->post('bar')
        );
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
        $oCampaign      = $oCampaignModel->getById($this->uri->segment(5));

        if (!$oCampaign) {
            show_404();
        }

        // --------------------------------------------------------------------------

        if ($oCampaignModel->delete($oCampaign->id)) {

            $sStatus  = 'success';
            $sMessage = 'Successfully deleted campaign.';

        } else {

            $sStatus  = 'error';
            $sMessage = 'Failed to delete campaign. ' . $oCampaignModel->lastError();
        }

        // --------------------------------------------------------------------------

        $oSession = Factory::service('Session', 'nailsapp/module-auth');
        $oSession->set_flashdata($sStatus, $sMessage);

        redirect('admin/emaildrip/campaign/index');
    }
}
