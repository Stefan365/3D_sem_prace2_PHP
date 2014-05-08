<?php

/**
 * TODOLIST
 * Školní projekt k seznámení s Nette a ORM
 * 
 * @author MMR <miroslav.mrazek@gmail.com>
 */

namespace Todolist\Components;

use Todolist\Model\TaskService,
	Todolist\Model\CatalogRepository,
	Todolist\Components\TaskForm,
	Todolist\Components\ITaskFormFactory,
	Nette\InvalidArgumentException;


/**
 * Komponenta catalogControl
 */
class CatalogControl extends BaseControl
{

	/** @var TaskService */
	protected $taskService;

	/** @var CatalogRepository */
	protected $catalogs;

	/** @var ITaskFormFactory */
	protected $taskFormFactory;


	
	public function __construct(TaskService $taskService,
								CatalogRepository $catalogs,
								ITaskFormFactory $taskFormFactory)
	{
		parent::__construct();
		$this->taskService = $taskService;
		$this->catalogs = $catalogs;
		$this->taskFormFactory = $taskFormFactory;
	}


	/** defaultní pohled */
	public function render($id)
	{
		$catalog = $this->catalogs->get($id);
		$this->template->catalog = $catalog;
		$this->template->tasks = $catalog->tasks;
		
		$this->template->setFile(__DIR__ . '/catalogControl.latte');
		$this->template->render();
	}


	/**
	 * Signál, který nastaví úkol jako (ne)splněný
	 * 
	 * @param int    $id
	 * @param string $done 'yes'|'no'
	 */
	public function handleSetDone($taskId, $done)
	{
		if ($done === "yes") {
			$done = TRUE;
		}
		elseif ($done === "no") {
			$done = FALSE;
		}
		else {
			throw new InvalidArgumentException("Parametr 'done' může nabývat jen hodnot 'yes', nebo 'no'.");
		}

		$this->taskService->setDone($taskId, $done);
		
		if ($this->presenter->isAjax()) {
			$this->invalidateControl('tasks');
		}
		else {
			$this->presenter->redirect('this');
		}
	}


	/**
	 * Vytvoří komponentu newTaskForm
	 * 
	 * @return TaskForm
	 */
	public function createComponentNewTaskForm()
	{
		$newTaskForm = $this->taskFormFactory->create();
		return $newTaskForm;
	}

}


# ---------------------------------------------------------------------------- #

/**
 * Rozhranní pro generovanou továrničku
 */
interface ICatalogControlFactory
{

	/** @return CatalogControl */
	function create();

}