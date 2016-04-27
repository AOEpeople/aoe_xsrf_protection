<?php
namespace Aoe\XsrfProtection\System\Typo3;

use TYPO3\CMS\Core\Authentication\AbstractUserAuthentication;
use TYPO3\CMS\Core\FormProtection\AbstractFormProtection;

class FrontendFormProtection extends AbstractFormProtection
{
    /**
     * Keeps the instance of the user which existed during creation
     * of the object.
     *
     * @var AbstractUserAuthentication
     */
    protected $frontendUser;

    /**
     * Only allow construction if we have a frontend session
     * @param AbstractUserAuthentication $frontendUser the frontend user (for testing / mocking)
     * @throws \TYPO3\CMS\Core\Error\Exception when no frontend user is logged in
     */
    public function __construct(AbstractUserAuthentication $frontendUser = null)
    {
        if ($frontendUser === null) {
            if (isset($GLOBALS['TSFE']->fe_user) && $GLOBALS['TSFE']->fe_user instanceof AbstractUserAuthentication) {
                $this->frontendUser = $GLOBALS['TSFE']->fe_user;
            } else {
                throw new \TYPO3\CMS\Core\Error\Exception('A front-end form protection may only be instantiated if there' .
                    ' is an active front-end session.', 1285067843);
            }
        } else {
            $this->frontendUser = $frontendUser;
        }
    }

    /**
     * Creates or displays an error message telling the user that the submitted
     * form token is invalid.
     *
     * @return void
     */
    protected function createValidationErrorMessage()
    {
    }

    /**
     * Retrieves the saved session token or generates a new one.
     *
     * @return string
     */
    protected function retrieveSessionToken()
    {
        $this->sessionToken = $this->frontendUser->getSessionData('formSessionToken');
        if (empty($this->sessionToken)) {
            $this->sessionToken = $this->generateSessionToken();
            $this->persistSessionToken();
        }
        return $this->sessionToken;
    }

    /**
     * Saves the tokens so that they can be used by a later incarnation of this
     * class.
     *
     * @access private
     * @return void
     */
    public function persistSessionToken()
    {
        $this->frontendUser->setAndSaveSessionData('formSessionToken', $this->sessionToken);
    }

    /**
     * Return language service instance
     *
     * @return \TYPO3\CMS\Lang\LanguageService
     */
    protected function getLanguageService()
    {
        return $GLOBALS['LANG'];
    }

    /**
     * Checks if the current request is an Ajax request
     *
     * @return bool
     */
    protected function isAjaxRequest()
    {
        return (bool)(TYPO3_REQUESTTYPE & TYPO3_REQUESTTYPE_AJAX);
    }
}