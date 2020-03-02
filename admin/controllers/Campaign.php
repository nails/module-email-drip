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

use Nails\Admin\Helper;
use Nails\EmailDrip\Controller\BaseAdmin;
use Nails\Factory;

class Campaign extends BaseAdmin
{
    /**
     * Announces this controller's navGroups
     *
     * @return stdClass
     */
    public static function announce()
    {
        if (userHasPermission('admin:emaildrip:campaign:manage')) {

            $oNavGroup = Factory::factory('Nav', 'nails/module-admin');
            $oNavGroup->setLabel('Email');
            $oNavGroup->addAction('Manage Drip Campaigns');

            return $oNavGroup;
        }
    }

    // --------------------------------------------------------------------------

    /**
     * Returns an array of extra permissions for this controller
     *
     * @return array
     */
    public static function permissions(): array
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
     *
     * @return void
     */
    public function index()
    {
        if (!userHasPermission('admin:emaildrip:campaign:manage')) {
            unauthorised();
        }

        // --------------------------------------------------------------------------

        $oInput         = Factory::service('Input');
        $oCampaignModel = Factory::model('Campaign', 'nails/module-email-drip');
        $sTableAlias    = $oCampaignModel->getTableAlias();

        // --------------------------------------------------------------------------

        //  Set method info
        $this->data['page']->title = 'Drip Campaigns';

        // --------------------------------------------------------------------------

        //  Get pagination and search/sort variables
        $page      = $oInput->get('page') ? $oInput->get('page') : 0;
        $perPage   = $oInput->get('perPage') ? $oInput->get('perPage') : 50;
        $sortOn    = $oInput->get('sortOn') ? $oInput->get('sortOn') : $sTableAlias . '.label';
        $sortOrder = $oInput->get('sortOrder') ? $oInput->get('sortOrder') : 'desc';
        $keywords  = $oInput->get('keywords') ? $oInput->get('keywords') : '';

        // --------------------------------------------------------------------------

        //  Define the sortable columns
        $sortColumns = [
            $sTableAlias . '.created'  => 'Created Date',
            $sTableAlias . '.modified' => 'Modified Date',
            $sTableAlias . '.label'    => 'label',
        ];

        // --------------------------------------------------------------------------

        //  Define the $data variable for the queries
        $data = [
            'sort'     => [
                [$sortOn, $sortOrder],
            ],
            'keywords' => $keywords,
        ];

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
     *
     * @return void
     */
    public function create()
    {
        if (!userHasPermission('admin:emaildrip:campaign:create')) {
            unauthorised();
        }

        // --------------------------------------------------------------------------

        $oCampaignModel = Factory::model('Campaign', 'nails/module-email-drip');

        // --------------------------------------------------------------------------

        //  Page Title
        $this->data['page']->title = 'Create Drip Campaign';

        // --------------------------------------------------------------------------

        $oInput = Factory::service('Input');
        if ($oInput->post()) {
            if ($this->formValidation()) {

                if ($oCampaignModel->create($this->getPostObject())) {

                    $oSession = Factory::service('Session');
                    $oSession->setFlashData('success', 'Successfully created drip campaign.');
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
     *
     * @return void
     */
    public function edit()
    {
        if (!userHasPermission('admin:emaildrip:campaign:edit')) {
            unauthorised();
        }

        // --------------------------------------------------------------------------

        $oCampaignModel = Factory::model('Campaign', 'nails/module-email-drip');

        // --------------------------------------------------------------------------

        $oUri                   = Factory::service('Uri');
        $this->data['campaign'] = $oCampaignModel->getById($oUri->segment(5), ['expand' => ['emails']]);

        if (!$this->data['campaign']) {
            show404();
        }

        // --------------------------------------------------------------------------

        //  Page Title
        $this->data['page']->title = 'Edit Drip Campaign';

        // --------------------------------------------------------------------------

        $oInput = Factory::service('Input');
        if ($oInput->post()) {
            if ($this->formValidation()) {

                if ($oCampaignModel->update($this->data['campaign']->id, $this->getPostObject())) {

                    $oSession = Factory::service('Session');
                    $oSession->setFlashData('success', 'Successfully updated drip campaign.');
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
        $oAsset          = Factory::service('Asset');
        $oSegmentService = Factory::service('Segment', 'nails/module-email-drip');

        //  Load Segments
        $this->data['segments'] = $oSegmentService->getAllFlat();

        //  Load assets
        $aEmails = $oItem ? $oItem->email->data : [];

        //  @todo (Pablo - 2019-09-13) - Update/Remove/Use minified once JS is refactored to be a module
        $oAsset->load('admin.campaign.edit.js', 'nails/module-email-drip');
        $oAsset->inline(
            'ko.applyBindings(new dripCampaignEdit(' . json_encode($aEmails) . '));',
            'JS'
        );
    }

    // --------------------------------------------------------------------------

    /**
     * Runs form validation
     *
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
        return [];
    }

    // --------------------------------------------------------------------------

    /**
     * Delete a drip campaign
     *
     * @return void
     */
    public function delete()
    {
        if (!userHasPermission('admin:emaildrip:campaign:delete')) {
            unauthorised();
        }

        // --------------------------------------------------------------------------

        $oUri           = Factory::service('Uri');
        $oCampaignModel = Factory::model('Campaign', 'nails/module-email-drip');
        $oCampaign      = $oCampaignModel->getById($oUri->segment(5));

        if (!$oCampaign) {
            show404();
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

        $oSession = Factory::service('Session');
        $oSession->setFlashData($sStatus, $sMessage);

        redirect('admin/emaildrip/campaign/index');
    }
}
