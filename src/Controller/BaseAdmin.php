<?php

/**
 * This class provides some common Email Drip Campaign controller functionality in admin
 *
 * @package     Nails
 * @subpackage  module-email-drip
 * @category    Controller
 * @author      Nails Dev Team
 * @link
 */

namespace Nails\EmailDrip\Controller;

use Nails\Admin\Controller\Base;
use Nails\Common\Service\Asset;
use Nails\EmailDrip\Constants;
use Nails\Factory;

abstract class BaseAdmin extends Base
{
    public function __construct()
    {
        parent::__construct();
        /** @var Asset $oAsset */
        $oAsset = Factory::service('Asset');
        $oAsset->load('admin.min.css', Constants::MODULE_SLUG);
    }
}
