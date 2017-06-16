<?php
/**
 * THIS IS AN AUTOGENERATED FILE
 * DO NOT MODIFY
 */


namespace Ls\Omni\Client\Loyalty\Entity;

use Ls\Omni\Client\RequestInterface;

class ForgotPasswordEx implements RequestInterface
{

    /**
     * @property string $userNameOrEmail
     */
    protected $userNameOrEmail = null;

    /**
     * @property string $resetCode
     */
    protected $resetCode = null;

    /**
     * @property string $emailSubject
     */
    protected $emailSubject = null;

    /**
     * @property string $emailBody
     */
    protected $emailBody = null;

    /**
     * @param string $userNameOrEmail
     * @return $this
     */
    public function setUserNameOrEmail($userNameOrEmail)
    {
        $this->userNameOrEmail = $userNameOrEmail;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserNameOrEmail()
    {
        return $this->userNameOrEmail;
    }

    /**
     * @param string $resetCode
     * @return $this
     */
    public function setResetCode($resetCode)
    {
        $this->resetCode = $resetCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getResetCode()
    {
        return $this->resetCode;
    }

    /**
     * @param string $emailSubject
     * @return $this
     */
    public function setEmailSubject($emailSubject)
    {
        $this->emailSubject = $emailSubject;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmailSubject()
    {
        return $this->emailSubject;
    }

    /**
     * @param string $emailBody
     * @return $this
     */
    public function setEmailBody($emailBody)
    {
        $this->emailBody = $emailBody;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmailBody()
    {
        return $this->emailBody;
    }


}

