<?php

/**
 * Email Drip Segment model
 *
 * @package     Nails
 * @subpackage  module-email-drip
 * @category    Model
 * @author      Nails Dev Team
 * @link
 */

namespace Nails\EmailDrip\Model;

use Nails\Factory;

class Segment
{
    protected $aSegments;

    // --------------------------------------------------------------------------


    public function __construct()
    {
        $this->aSegments = array();

        //  Look for defined segments
        $aComponents = _NAILS_GET_COMPONENTS();
        foreach ($aComponents as $oComponent) {
            if (!empty($oComponent->namespace)) {
                $this->autoLoadSegments($oComponent->namespace);
            }
        }

        //  Any segments from the app?
        $this->autoLoadSegments('App\\');

        Factory::helper('array');
        array_sort_multi($this->aSegments, 'label');
    }

    // --------------------------------------------------------------------------

    /**
     * Looks for an NAMESPACE/EmailDrip/Segments class in each component and analyses it for public methods
     * @param  string $sNamespace The namespace to check
     * @return void
     */
    protected function autoLoadSegments($sNamespace)
    {
        $sClassName = '\\' . $sNamespace . 'EmailDripSegments';

        if (class_exists($sClassName)) {

            $oReflect       = new \ReflectionClass($sClassName);
            $aPublicMethods = $oReflect->getMethods(\ReflectionMethod::IS_PUBLIC);
            $aStaticMethods = $oReflect->getMethods(\ReflectionMethod::IS_STATIC);
            $aMethods       = array_diff($aPublicMethods, $aStaticMethods);

            foreach ($aMethods as $oMethod) {

                $sDoc   = $oMethod->getDocComment();
                $aDoc   = explode("\n", $sDoc);
                $aLabel = array();

                foreach ($aDoc as $sLine) {

                    $sLine = trim($sLine);

                    //  Ignore empty or open/close lines
                    if (empty($sLine) || $sLine == '/**' || $sLine == '*/') {
                        continue;
                    }

                    //  Ignore tags
                    if (preg_match('/^\*(.*)?@/', $sLine)) {
                        continue;
                    }

                    $aLabel[] = trim(preg_replace('/^\*?/', '', $sLine));
                }

                if (!empty($aLabel)) {

                    $sLabel = implode(' ', $aLabel);

                } else {

                    $sLabel = camelcase_to_underscore($oMethod->getName());
                    $sLabel = ucfirst(str_replace('_', ' ', $sLabel));
                }

                $this->aSegments[] = (object) array(
                    'slug'   => md5($sClassName . '::' . $oMethod->getName()),
                    'label'  => $sLabel,
                    'class'  => $sClassName,
                    'method' => $oMethod->getName()
                );
            }
        }
    }

    // --------------------------------------------------------------------------

    /**
     * Returns all discovered segments
     * @return array
     */
    public function getAll()
    {
        return $this->aSegments;
    }

    // --------------------------------------------------------------------------

    /**
     * Retruns a flat array of discovered segments
     * @return array
     */
    public function getAllFlat()
    {
        $aItems = $this->getAll();
        $aOut   = array();

        foreach ($aItems as $oItem) {
            $aOut[$oItem->slug] = $oItem->label;
        }

        return $aOut;
    }
}