<?php

/**
 * Email Drip Email model
 *
 * @package     Nails
 * @subpackage  module-email-drip
 * @category    Model
 * @author      Nails Dev Team
 * @link
 */

namespace Nails\EmailDrip\Model;

use Nails\EmailDrip\Exception\EmailDripException;

class Email implements \JsonSerializable
{
    private $sSubject;
    private $sBodyHtml;
    private $sBodyText;
    private $sTriggerEvent;
    private $oTriggerDelay;
    private $aValidInterval;

    // --------------------------------------------------------------------------

    /**
     * Construct the model
     */
    public function __construct()
    {
        $this->aValidInterval = array('DAY','WEEK','MONTH','YEAR');

        $this->setSubject('');
        $this->setBody('', 'HTML');
        $this->setBody('', 'TEXT');
        $this->setTriggerEvent('');
        $this->setTriggerDelay(1, 'DAY');
    }

    // --------------------------------------------------------------------------

    /**
     * Set the email's subject
     * @param string $sSubject The subject to set
     */
    public function setSubject($sSubject)
    {
        $this->sSubject = $sSubject;
        return $this;
    }

    // --------------------------------------------------------------------------

    /**
     * Get the email's subject
     * @return String
     */
    public function getSubject()
    {
        return $this->sSubject;
    }

    // --------------------------------------------------------------------------

    /**
     * Get the email's body
     * @param  string $sType The type of body to get, HTML or TEXT
     * @return string
     */
    public function setBody($sBody, $sType = 'HTML')
    {
        if ($sType === 'HTML') {

            $this->sBodyHtml = $sBody;

        } elseif ($sType === 'TEXT') {

            $this->sBodyText = $sBody;

        } else {

            throw new EmailDripException(
                '"' . $sType . '" is not a valid body type.',
                0
            );
        }

        return $this;
    }

    // --------------------------------------------------------------------------

    /**
     * Get the email's body
     * @param  string $sType The type of body to get, HTML or TEXT
     * @return string
     */
    public function getBody($sType = 'HTML')
    {
        if ($sType === 'HTML') {

            return $this->sBodyHtml;

        } elseif ($sType === 'TEXT') {

            return $this->sBodyText;

        } else {

            throw new EmailDripException(
                '"' . $sType . '" is not a valid body type.',
                0
            );
        }
    }

    // --------------------------------------------------------------------------

    /**
     * Set the email's trigger event
     * @param string $sTriggerEvent The trigger event to set
     */
    public function setTriggerEvent($sTriggerEvent)
    {
        $this->sTriggerEvent = $sTriggerEvent;
        return $this;
    }

    // --------------------------------------------------------------------------

    /**
     * Get the email's trigger event
     * @return String
     */
    public function getTriggerEvent()
    {
        return $this->sTriggerEvent;
    }

    // --------------------------------------------------------------------------

    /**
     * Set the email's trigger delay
     * @param integer $iInterval The number of units the delay should last for
     * @param string  $sUnit     The units to use for the delay
     */
    public function setTriggerDelay($iInterval, $sUnit)
    {
        if (!in_array($sUnit, $this->aValidInterval)) {

            throw new EmailDripException(
                '"' . $sUnit . '" is not a valid interval.',
                1
            );

        } elseif (!is_integer($iInterval) || $iInterval < 1) {

            throw new EmailDripException(
                '"' . $iInterval . '" must be a positive integer.',
                1
            );

        } else {

            $this->oTriggerDelay           = new \stdClass();
            $this->oTriggerDelay->interval = $iInterval;
            $this->oTriggerDelay->unit     = $sUnit;

            return $this;
        }
    }

    // --------------------------------------------------------------------------

    /**
     * Get the email's trigger delay
     * @return String
     */
    public function getTriggerDelay()
    {
        return $this->oTriggerDelay;
    }

    // --------------------------------------------------------------------------

    /**
     * Allows the email object t be json serialized
     */
    public function JsonSerialize()
    {

        return array(
            'subject' => $this->getSubject(),
            'body_html' => $this->getBody('HTML'),
            'body_text' => $this->getBody('TEXT'),
            'trigger_event' => $this->getTriggerEvent(),
            'trigger_delay' => $this->getTriggerDelay(),
        );
    }
}
