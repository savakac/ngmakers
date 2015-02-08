<?php

namespace App\Presenters;

use Nette,
	App\Model,
	Nette\Security\Passwords;


/**
 * Sign in/out presenters.
 */
class RegistrationPresenter extends BasePresenter
{

	public $database;

	public function __construct(Nette\Database\Context $database) {
		$this->database = $database;
	}

	/**
	 * Sign-in form factory.
	 * @return Nette\Application\UI\Form
	 */
	protected function createComponentRegistrationForm()
	{
		if (!$this->user->isLoggedIn()) {
			$htis->redirect('Sign:in');
		} else {
			$form = new Nette\Application\UI\Form;
			$form->addText('username', 'Username:')->setRequired('Please enter your username.');
			$form->addPassword('password', 'Password:')->setRequired('Please enter your password.');
			$form->addText('rola', 'Rola')->setRequired('Please enter your rola');
			$form->addSubmit('send', 'Sign in');

			// call method signInFormSucceeded() on success
			$form->onSuccess[] = $this->registrationFormSucceeded;
			return $form;
		}
	}


	public function registrationFormSucceeded($form)
	{
		if (!$this->user->isloggedIn()) {
			$this->redirect('Sign:in');
		} else {
			$password = $form->getValues('password');
			$hashPassword = Passwords::hash($password['password'], array('const' => '5', 'sald' => '1234567890123456789012'));
			$values = $form->getValues();
			$values['password'] = $hashPassword;

			$contents = $this->database->table('users')->insert($values);
		}
	}

}
