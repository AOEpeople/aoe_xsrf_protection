<?php
/**
 * Created by PhpStorm.
 * User: benedikt.ringlein
 * Date: 22.04.2016
 * Time: 10:58
 */

namespace Aoe\XsrfProtection;


use Aoe\XsrfProtection\System\Typo3\FrontendFormProtection;
use TYPO3\CMS\Core\FormProtection\AbstractFormProtection;

class XSRFProtectionService
{

	/**
	 * @var FrontendFormProtection
	 */
	protected $frontendFormProtection;

	/**
	 * XSRFProtectionService constructor.
	 * @param FrontendFormProtection $frontendFormProtection Object that provides token generation and validation
	 */
	public function __construct(FrontendFormProtection $frontendFormProtection)
	{
		$this->frontendFormProtection =  $frontendFormProtection;
	}

	/**
	 * Generates a token for XSRF protection. Every from should have a different form name. In addition to that,
	 * different actions and instance names can be used (optionally).
	 * Necessary information for later valitation is put into the user session.
	 * @param string $formName The form name, should be different for different forms
	 * @param string $action An optional action name
	 * @param string $formInstanceName An instance name for a form (optional). Changing this each time a form is
	 * generated can increase security
	 * @return string The XSRF protection token. This should be validated when receiving a request from the form
	 */
	public function generateToken($formName, $action = '', $formInstanceName = ''){
		return $this->frontendFormProtection->generateToken($formName, $action, $formInstanceName);
	}

	/**
	 * Validates a token against the users session token.
	 * @param string $tokenId The (previously generated) xsrf protection token
	 * @param string $formName The form name (has to be the same, as when the token was generated)
	 * @param string $action The action name (has to be the same, as when the token was generated)
	 * @param string $formInstanceName THe froms instance name (has to be the same, as when the token was generated)
	 * @return bool True, if the token is valid, otherwise false. When this returns false, the request associated with
	 * this token should at least be ignored.
	 */
	public function validateToken($tokenId, $formName, $action = '', $formInstanceName = ''){
		return $this->frontendFormProtection->validateToken($tokenId, $formName, $action, $formInstanceName);
	}
}