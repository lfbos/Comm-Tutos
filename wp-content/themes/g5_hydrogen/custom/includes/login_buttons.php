<?php
/**
 * Login Buttons
 * =====================
 *
 *
 *
 * @author      Current authors: Luis Boscan <luife642@gmail.com>
 *
 *              Original author: Luis Boscan <luife642@gmail.com>
 *
 * @license     Code and contributions have 'MIT License'
 *
 *
 * @version     0.0.1
 */
class Login_Buttons 
{	
	/**
     * Register URL.
     * @var string
     */
	protected $registerURL;
	/**
     * Login URL.
     * @var string
     */
	protected $loginURL;

	public function __construct() {
		$this->setRegisterURL(wp_registration_url()); //wp_registration_url();
		$this->setLoginURL(wp_login_url()); // wp_login_url();
    }

    /**
     * Set the Register URL
     *
     * @param string
     */
    public function setRegisterURL($registerURL) {
    	$this->registerURL = $registerURL;
    }

    /**
     * Set the Register URL
     *
     * @param string
     */
    public function setLoginURL($loginURL) {
    	$this->loginURL = $loginURL;
    }

    /**
     * Retrieves the Register URL.
     *
     * @return string
     */
    public function getRegisterURL() {
    	return $this->registerURL;
    }

    /**
     * Retrieves the Login URL.
     *
     * @return string
     */
    public function getLoginURL() {
    	return $this->loginURL;
    }
}