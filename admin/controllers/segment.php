<?php

/**
 * Manage drip campaign segments
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

class Segment extends BaseAdmin
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
            $oNavGroup->addAction('Manage Drip Segments');

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

        $permissions['manage'] = 'Can manage drip segments';
        $permissions['create'] = 'Can create drip segments';
        $permissions['edit']   = 'Can edit drip segments';
        $permissions['delete'] = 'Can delete drip segments';

        return $permissions;
    }

    // --------------------------------------------------------------------------

    public function index()
    {
        Helper::loadView('index');
    }
}
