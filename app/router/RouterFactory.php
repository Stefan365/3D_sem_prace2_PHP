<?php

/**
 * TODOLIST
 * Školní projekt k seznámení s Nette a ORM
 * 
 * @author MMR <miroslav.mrazek@gmail.com>
 */

namespace Todolist;

use Nette\Application\Routers\RouteList,
	Nette\Application\Routers\Route;


/**
 * Router factory.
 */
class RouterFactory
{

	/**
	 * @return \Nette\Application\IRouter
	 */
	public function createRouter()
	{
		$router = new RouteList();
		$router[] = new Route('index.php', 'Catalog:list', Route::ONE_WAY);
		//router najprv uvadza presenter, potom action:
        $router[] = new Route('<presenter>/<action>[/<id>]', 'Catalog:list');
		$router[] = new Route('druha','Homepage:two', Route::SECURED);
		
        return $router;
        
        
        
	}

}
