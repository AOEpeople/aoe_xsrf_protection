<?php

/**
 * Created by PhpStorm.
 * User: benedikt.ringlein
 * Date: 14.04.2016
 * Time: 15:36
 */

class FrontendFormProtectionTest extends PHPUnit_Framework_TestCase
{
	const FORMNAME = "FORMNAME";
	const FORMNAME2 = "YOURFORM";
	/**
	 * @var \Aoe\XsrfProtection\System\Typo3\FrontendFormProtection
	 */
	protected $frontendFormProtection;

	/**
	 * @var
	 */
	protected $fe_user;

	public function setUp()
	{
		$GLOBALS['LANG'] = $this->getMock('\\TYPO3\\CMS\\Lang\\LanguageService');
		$this->fe_user = $this->getMock('\\TYPO3\\CMS\Core\\Authentication\\AbstractUserAuthentication');
		$this->frontendFormProtection = new \Aoe\XsrfProtection\System\Typo3\FrontendFormProtection($this->fe_user);
	}

	/**
	 * Tests, if the same token is retrieved on subsequent calls and the token
	 * is stored in the form protection (-> getSessionData only called once).
	 *
	 * @test
	 */
	public function testSameSessionSameToken()
	{
		$this->fe_user->expects($this->once())->method('getSessionData');
		$firstToken = $this->frontendFormProtection->generateToken(self::FORMNAME);
		$secondToken = $this->frontendFormProtection->generateToken(self::FORMNAME);
		$this->assertEquals($firstToken, $secondToken);
	}

	/**
	 * Tests, if a different token is retrieved with different sessions.
	 * Since the form protection is created new, the session data has to be
	 * retrieved twice from the user object.
	 *
	 * @test
	 */
	public function testDifferentSessionDifferentToken()
	{
		$this->fe_user->expects($this->once())->method('getSessionData');
		$firstToken = $this->frontendFormProtection->generateToken(self::FORMNAME);
		$this->fe_user = $this->getMock('\TYPO3\CMS\Core\Authentication\AbstractUserAuthentication');
		$this->fe_user->expects($this->once())->method('getSessionData');
		$this->frontendFormProtection = new \Aoe\XsrfProtection\System\Typo3\FrontendFormProtection($this->fe_user);
		$secondToken = $this->frontendFormProtection->generateToken(self::FORMNAME);
		$this->assertNotEquals($firstToken, $secondToken);
	}

	/**
	 * Tests, if different tokens are retrieved on subsequent calls with different form names but the same
	 * session token (-> getSessionData only called once).
	 *
	 * @test
	 */
	public function testDifferentFormnameDifferentToken()
	{
		$this->fe_user->expects($this->once())->method('getSessionData');
		$firstToken = $this->frontendFormProtection->generateToken(self::FORMNAME);
		$secondToken = $this->frontendFormProtection->generateToken(self::FORMNAME2);
		$this->assertNotEquals($firstToken, $secondToken);
	}

	/**
	 * Tests, if a correct token can be validated.
	 *
	 * @test
	 */
	public function testValidateCorrectToken()
	{
		$this->fe_user->expects($this->once())->method('getSessionData');
		$token = $this->frontendFormProtection->generateToken(self::FORMNAME);
		$valid = $this->frontendFormProtection->validateToken($token, self::FORMNAME);
		$this->assertTrue($valid);
	}

	/**
	 * Tests, if an incorrect token can not be validated.
	 *
	 * @test
	 */
	public function testDontValidateIncorrectToken()
	{
		$this->fe_user->expects($this->once())->method('getSessionData');
		$token = $this->frontendFormProtection->generateToken(self::FORMNAME);
		$valid = $this->frontendFormProtection->validateToken("00000000000000000000000000000000", self::FORMNAME);
		$this->assertFalse($valid);
	}

	/**
	 * Tests, if a correct token cant be validated with a wrong form name.
	 *
	 * @test
	 */
	public function testDontValidateCorrectTokenIncorrectFormname()
	{
		$this->fe_user->expects($this->once())->method('getSessionData');
		$token = $this->frontendFormProtection->generateToken(self::FORMNAME);
		$valid = $this->frontendFormProtection->validateToken($token, self::FORMNAME2);
		$this->assertFalse($valid);
	}

}
