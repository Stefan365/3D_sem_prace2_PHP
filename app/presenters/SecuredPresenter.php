<?php

/**
 * TODOLIST
 * Školní projekt k seznámení s Nette a ORM
 * 
 * @author MMR <miroslav.mrazek@gmail.com>
 */

namespace Todolist;

use Todolist\Model\User,
	Todolist\Model\UserRepository,
	Todolist\Components\LogoutControl,
	Todolist\Components\ILogoutControlFactory;


/**
 * Presenter, který pustí dál jen přihlášeného uživatele
 */
abstract class SecuredPresenter extends BasePresenter
{
	
	/** @var User */
	protected $userEntity;

	/** @var UserRepository */
	private $users;

	/**
	 * @var \Todolist\Components\ILogoutControlFactory
	 * @inject
	 */
	public $logoutControlFactory;


	public function startup()
	{
		parent::startup();

		if (!$this->user->isLoggedIn()) {
			$this->flashMessage("Bez přihlášení nelze vstoupit do aplikace.");
			$this->redirect('Application:login');
		}
		
		$this->userEntity = $this->users->get($this->user->id);
	}
	
	
	/**
	 * Vytvoří komponentu logoutControl
	 * 
	 * @return LogoutControl
	 */
	public function createComponentLogoutControl()
	{
		return $this->logoutControlFactory->create();
	}
	
	
	/**
	 * Injector
	 * 
	 * @param UserRepository $users
	 */
	public function injectUserRepository(UserRepository $users)
	{
		$this->users = $users;
	}

}
