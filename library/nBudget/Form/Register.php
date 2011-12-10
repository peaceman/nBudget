<?php
/**
 * User: peaceman
 * Date: 10.12.11
 * Time: 11:41
 */
namespace nBudget\Form;

class Register extends \Zend_Form
{
	public function init()
	{
		$usernameField = new \Zend_Form_Element_Text('username');
		$usernameField->setLabel('Username')
			->setRequired(true)
			->setAllowEmpty(false)
			->addValidator(new \Zend_Validate_StringLength(array('min' => 2, 'max' => 16)))
			->addValidator(new \Zend_Validate_Alnum(false));

		$emailField = new \Zend_Form_Element_Text('email');
		$emailField->setLabel('Email')
			->setRequired(true)
			->setAllowEmpty(false)
			->addValidator(new \Zend_Validate_StringLength(array('max' => 128)))
			->addValidator(new \Zend_Validate_EmailAddress());

		$emailRepField = new \Zend_Form_Element_Text('email_rep');
		$emailRepField->setLabel('Email rep.')
			->setRequired(true)
			->setAllowEmpty(false)
			->addValidator(new \Zend_Validate_Identical('email'));

		$passwordField = new \Zend_Form_Element_Password('password');
		$passwordField->setLabel('Password')
			->setRequired(true)
			->setAllowEmpty(false);

		$passwordRepField = new \Zend_Form_Element_Password('password_rep');
		$passwordRepField->setLabel('Password rep.')
			->setRequired(true)
			->setAllowEmpty(false)
			->addValidator(new \Zend_Validate_Identical('password'));

		$submitButton = new \Zend_Form_Element_Submit('register_user');
		$submitButton->setLabel('Register');

		$this->addElements(array(
			$usernameField,
			$emailField,
			$emailRepField,
			$passwordField,
			$passwordRepField,
			$submitButton,
		));
	}
}
 
