<?php

/**
 * TODOLIST
 * Školní projekt k seznámení s Nette a ORM
 * 
 * @author MMR <miroslav.mrazek@gmail.com>
 */

namespace Todolist\Model;


/**
 * Entita reprezentující seznam úkolů
 * 
 * @property User   $user  m:hasOne
 * @property Task[] $tasks m:belongsToMany
 * 
 * @property int    $id
 * @property string $title
 */
class Catalog extends Entity
{
	
}
