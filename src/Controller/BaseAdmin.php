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

class BaseAdmin extends Base
{
    public function __construct()
    {
        parent::__construct();
        $this->asset->load('nails.admin.module.emaildrip.css', 'NAILS');
    }
}
