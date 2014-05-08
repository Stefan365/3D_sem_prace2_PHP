<?php

/**
 * TODOLIST
 * Školní projekt k seznámení s Nette a ORM
 * 
 * @author MMR <miroslav.mrazek@gmail.com>
 */

namespace Todolist\Model;


/**
 * Fasáda - servisní třída pro komplexní práci s úkoly
 */
class TaskService
{

	/** @var TaskRepository */
	protected $tasks;


	public function __construct(TaskRepository $tasks)
	{
		$this->tasks = $tasks;
	}


	/**
	 * Metoda nastaví úkol jako (ne)splněný
	 * 
	 * @param int     $id
	 * @param boolean $done
	 */
	public function setDone($id, $done = TRUE)
	{
		$task = $this->tasks->get($id);
		$task->done = $done;
		$this->tasks->persist($task);
	}

}
