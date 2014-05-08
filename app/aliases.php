<?php

/**
 * TODOLIST
 * Školní projekt k seznámení s Nette a ORM
 * 
 * @author MMR <miroslav.mrazek@gmail.com>
 */

use Nette\Diagnostics\Debugger;


/*
 * Rychlé aliasy pro často používané funkce
 */


/**
 * Zkratka pro rychlé dumpování do DebugBaru
 * 
 * @param mixed  $var
 * @param string $title
 * @return mixed 
 */
function barDump($var, $title = '')
{
	$backtrace = debug_backtrace();
	$source = (isset($backtrace[1]['class'])) ?
		$backtrace[1]['class'] :
		basename($backtrace[0]['file']);
	$line = $backtrace[0]['line'];
	$title .= (empty($title) ? : ' – ');

	return Debugger::barDump($var, $title . $source . ' (' . $line . ')');
}
