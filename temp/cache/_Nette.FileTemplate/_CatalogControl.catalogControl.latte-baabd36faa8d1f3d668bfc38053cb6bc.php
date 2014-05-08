<?php //netteCache[01]000442a:2:{s:4:"time";s:21:"0.50054600 1391790144";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:10:"checkFiles";}i:1;s:117:"C:\Users\User\Dropbox\IIVOS_STV\Netbeans\TODOLIST\todolist\app\components\Catalog\CatalogControl\catalogControl.latte";i:2;i:1391790144;}i:1;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:10:"checkConst";}i:1;s:25:"Nette\Framework::REVISION";i:2;s:30:"2855c33 released on 2013-08-28";}}}?><?php

// source file: C:\Users\User\Dropbox\IIVOS_STV\Netbeans\TODOLIST\todolist\app\components\Catalog\CatalogControl\catalogControl.latte

?><?php
// prolog Nette\Latte\Macros\CoreMacros
list($_l, $_g) = Nette\Latte\Macros\CoreMacros::initRuntime($template, 'vtjhcyacfe')
;
// prolog Nette\Latte\Macros\UIMacros
//
// block _tasks
//
if (!function_exists($_l->blocks['_tasks'][] = '_lb2ce39dccc7__tasks')) { function _lb2ce39dccc7__tasks($_l, $_args) { extract($_args); $_control->validateControl('tasks')
?>			<ul>
<?php $iterations = 0; foreach ($tasks as $task): ?>				<li>
					<span<?php if ($_l->tmp = array_filter(array($task->done ? 'done' : NULL))) echo ' class="' . htmlSpecialChars(implode(" ", array_unique($_l->tmp))) . '"' ?>
><?php echo Nette\Templating\Helpers::escapeHtml($task->text, ENT_NOQUOTES) ?></span> | 

<?php if ($task->done): ?>
						<a class="ajax" href="<?php echo htmlSpecialChars($_control->link("setDone!", array($task->id, 'no'))) ?>
">Nesplněno!</a>
<?php else: ?>
						<a class="ajax" href="<?php echo htmlSpecialChars($_control->link("setDone!", array($task->id, 'yes'))) ?>
">Splněno!</a>
<?php endif ?>

				</li>
<?php $iterations++; endforeach ?>
			</ul>
<?php
}}

//
// end of blocks
//

// template extending and snippets support

$_l->extends = empty($template->_extended) && isset($_control) && $_control instanceof Nette\Application\UI\Presenter ? $_control->findLayoutTemplateFile() : NULL; $template->_extended = $_extended = TRUE;


if ($_l->extends) {
	ob_start();

} elseif (!empty($_control->snippetMode)) {
	return Nette\Latte\Macros\UIMacros::renderSnippets($_control, $_l, get_defined_vars());
}

//
// main template
//
?>
<div class="row">

<?php if (isset($catalog)): ?>	<div id="tasks" class="span5">
		<h2>Úkoly v seznamu <?php echo Nette\Templating\Helpers::escapeHtml($catalog->title, ENT_NOQUOTES) ?></h2>
<?php if ($_l->extends) { ob_end_clean(); return Nette\Latte\Macros\CoreMacros::includeTemplate($_l->extends, get_defined_vars(), $template)->render(); } ?>
<div id="<?php echo $_control->getSnippetId('tasks') ?>"><?php call_user_func(reset($_l->blocks['_tasks']), $_l, $template->getParameters()) ?>
</div>	</div>
<?php endif ?>

<?php if (isset($catalog)): ?>	<div id="taskForm" class="span5">
		<h2>Nový úkol</h2>
<?php $_ctrl = $_control->getComponent("newTaskForm"); if ($_ctrl instanceof Nette\Application\UI\IRenderable) $_ctrl->validateControl(); $_ctrl->render() ?>
	</div>
<?php endif ?>

</div>