<?php

/**
 * TODOLIST
 * Školní projekt k seznámení s Nette a ORM
 * 
 * @author MMR <miroslav.mrazek@gmail.com>
 */

namespace Todolist\Components;


/**
 * Komponenta logoutControl
 */
class LogoutControl extends BaseControl
{


	/**
	 * Provede odhlášení uživatele
	 */
	public function handleLogout()
	{
		$this->presenter->getUser()->logout();
		$this->presenter->flashMessage('Byl jste odhlášen.');
		$this->presenter->redirect('Application:login');
	}


	/**
	 * Defaultní pohled
	 */
	public function render()
	{
		$this->template->setFile(__DIR__ . '/logoutControl.latte');
		$this->template->render();
	}


	/**
	 * Vykreslí komponentu jako tlačítko
	 */
	public function renderButton()
	{
		$this->template->setFile(__DIR__ . '/logoutControlButton.latte');
		$this->template->render();
	}

}


# ---------------------------------------------------------------------------- #

/**
 * Rozhranní pro generovanou továrničku
 */
interface ILogoutControlFactory
{

	/** @return LogoutControl */
	function create();

}
