<?php

/**
 * Email Drip Segment service
 *
 * @package     Nails
 * @subpackage  module-email-drip
 * @category    Service
 * @author      Nails Dev Team
 * @link
 */

namespace Nails\EmailDrip\Service;

use Nails\Common\Factory\Component;
use Nails\Components;
use Nails\Factory;

/**
 * Class Segment
 *
 * @package Nails\EmailDrip\Service
 */
class Segment
{
    /**
     * The discovered segments
     *
     * @var \stdClass[]
     */
    protected $aSegments = [];

    // --------------------------------------------------------------------------

    /**
     * Segment constructor.
     */
    public function __construct()
    {
        /** @var Component $oComponent */
        foreach (Components::available() as $oComponent) {
            if (!empty($oComponent->namespace)) {
                $this->autoLoadSegments($oComponent->namespace);
            }
        }

        arraySortMulti($this->aSegments, 'label');
    }

    // --------------------------------------------------------------------------

    /**
     * Looks for an NAMESPACE/EmailDrip/Segments class in each component and analyses it for public methods
     *
     * @param string $sNamespace The namespace to check
     *
     * @throws \ReflectionException
     */
    protected function autoLoadSegments(string $sNamespace): void
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
                $aLabel = [];

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

                $this->aSegments[] = (object) [
                    'slug'   => md5($sClassName . '::' . $oMethod->getName()),
                    'label'  => $sLabel,
                    'class'  => $sClassName,
                    'method' => $oMethod->getName(),
                ];
            }
        }
    }

    // --------------------------------------------------------------------------

    /**
     * Returns all discovered segments
     *
     * @return \stdClass[]
     */
    public function getAll(): array
    {
        return $this->aSegments;
    }

    // --------------------------------------------------------------------------

    /**
     * Retruns a flat array of discovered segments
     *
     * @return \stdClass[]
     */
    public function getAllFlat(): array
    {
        $aItems = $this->getAll();
        $aOut   = [];

        foreach ($aItems as $oItem) {
            $aOut[$oItem->slug] = $oItem->label;
        }

        return $aOut;
    }
}
