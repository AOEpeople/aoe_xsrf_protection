<?php

/**
 * Created by PhpStorm.
 * User: benedikt.ringlein
 * Date: 14.04.2016
 * Time: 15:36
 */

class FrontendFormProtectionTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var \Aoe\XsrfProtection\System\Typo3\FrontendFormProtection
	 */
	protected $frontendFormProtection;

	/**
	 * @var \TYPO3\CMS\Core\Authentication\AbstractUserAuthentication
	 */
	protected $fe_user;

	public function setUp()
	{
		$this->fe_user = $this->getMock('\TYPO3\CMS\Core\Authentication\AbstractUserAuthentication');
		$this->frontendFormProtection = new \Aoe\XsrfProtection\System\Typo3\FrontendFormProtection($this->fe_user);
	}

	/**
	 * Tests, if the same token is retrieved on subsequent calls
	 *
	 * @test
	 */
	public function testSameSessionSameToken()
	{
		$firstToken = $this->frontendFormProtection->generateToken("FORMNAME");
		$secondToken = $this->frontendFormProtection->generateToken("FORMNAME");
		$this->assertEquals($firstToken, $secondToken);
	}

	/**
	 * Tests, if a different token is retrieved with different sessions
	 *
	 * @test
	 */
	public function testDifferentSessionDifferentToken()
	{
		$firstToken = $this->frontendFormProtection->generateToken("FORMNAME");
		$this->fe_user = $this->getMock('\TYPO3\CMS\Core\Authentication\AbstractUserAuthentication');
		$this->frontendFormProtection = new \Aoe\XsrfProtection\System\Typo3\FrontendFormProtection($this->fe_user);
		$secondToken = $this->frontendFormProtection->generateToken("FORMNAME");
		$this->assertNotEquals($firstToken, $secondToken);
	}

	/**
	 * Tests, if different tokens are retrieved on subsequent calls with different form names
	 *
	 * @test
	 */
	public function testDifferentFormnaemeDifferentToken()
	{
		$firstToken = $this->frontendFormProtection->generateToken("MYFORM");
		$secondToken = $this->frontendFormProtection->generateToken("YOURFORM");
		$this->assertNotEquals($firstToken, $secondToken);
	}
}
