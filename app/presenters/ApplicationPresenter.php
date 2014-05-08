<?php

/**
 * TODOLIST
 * Školní projekt k seznámení s Nette a ORM
 * 
 * @author MMR <miroslav.mrazek@gmail.com>
 */

namespace Todolist;

use Nette\Application\UI\Form,
	Todolist\Components\ILoginFormFactory;


/**
 * Presenter pro aplikační záležitosti (přihlášení, registrace,…).
 */
class ApplicationPresenter extends BasePresenter
{

	/**
	 * @var \Todolist\Components\ILoginFormFactory
	 * @inject
	 */
	public $loginFormFactory;


	/**
	 * Pohled login
	 */
	public function renderLogin()
	{
	}


	/**
	 * Vytvoří komponentu loginForm
	 * @return Form
	 */
	protected function createComponentLoginForm()
	{
		return $this->loginFormFactory->create();
	}

}
