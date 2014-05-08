<?php

/**
 * TODOLIST
 * Školní projekt k seznámení s Nette a ORM
 * 
 * @author MMR <miroslav.mrazek@gmail.com>
 */

namespace Todolist\Model;

use Nette\ArrayHash;


/**
 * Kolekce entit
 */
class Collection extends ArrayHash
{

	/**
	 * Vrátí pole párů nad aktuální kolekcí
	 * 
	 * @param [string] $idCol   Property, která se použije pro klíče
	 * @param [string] $textCol Property, která se použije pro hodnoty
	 * @return array
	 */
	public function fetchPairs($idCol = 'id', $textCol = 'text')
	{
		$pairs = array();
		foreach ($this as $entity) {
			$pairs[$entity->$idCol] = $entity->$textCol;
		}
		return $pairs;
	}


	/**
	 * Vytvoří pole z aktuální kolekce
	 * 
	 * @return array
	 * @todo Pořešit rekurzivně, aby výsledné pole bylo použitelné.
	 */
	public function toArray()
	{
		return (array) $this;
	}

}
