<?php //netteCache[01]000415a:2:{s:4:"time";s:21:"0.47950100 1391789942";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:10:"checkFiles";}i:1;s:91:"C:\Users\User\Dropbox\IIVOS_STV\Netbeans\TODOLIST\todolist\app\templates\Catalog\list.latte";i:2;i:1391789942;}i:1;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:10:"checkConst";}i:1;s:25:"Nette\Framework::REVISION";i:2;s:30:"2855c33 released on 2013-08-28";}}}?><?php

// source file: C:\Users\User\Dropbox\IIVOS_STV\Netbeans\TODOLIST\todolist\app\templates\Catalog\list.latte

?><?php
// prolog Nette\Latte\Macros\CoreMacros
list($_l, $_g) = Nette\Latte\Macros\CoreMacros::initRuntime($template, '974z5ofkgx')
;
// prolog Nette\Latte\Macros\UIMacros
//
// block content
//
if (!function_exists($_l->blocks['content'][] = '_lbdece87b23c_content')) { function _lbdece87b23c_content($_l, $_args) { extract($_args)
?><div class="row">
	<div id="catalogs" class="span5">
<?php call_user_func(reset($_l->blocks['title']), $_l, get_defined_vars())  ?>		<ul class="nav nav-list"<?php echo ' id="' . $_control->getSnippetId('list') . '"' ?>>
<?php call_user_func(reset($_l->blocks['_list']), $_l, $template->getParameters()) ?>
		</ul>
	</div>

	<div id="catalogForm" class="span5">
		<h2>Nový seznam</h2>
<?php $_ctrl = $_control->getComponent("newCatalogForm"); if ($_ctrl instanceof Nette\Application\UI\IRenderable) $_ctrl->validateControl(); $_ctrl->render() ?>
	</div>
</div>

<?php if (!is_null($catalogId)): ?>
	<hr>
<?php $_ctrl = $_control->getComponent("catalogControl"); if ($_ctrl instanceof Nette\Application\UI\IRenderable) $_ctrl->validateControl(); $_ctrl->render($catalogId) ;endif ?>

<?php
}}

//
// block title
//
if (!function_exists($_l->blocks['title'][] = '_lbe4b1896ea1_title')) { function _lbe4b1896ea1_title($_l, $_args) { extract($_args)
?>		<h2>Seznamy úkolů</h2>
<?php
}}

//
// block _list
//
if (!function_exists($_l->blocks['_list'][] = '_lbba7a57593e__list')) { function _lbba7a57593e__list($_l, $_args) { extract($_args); $_control->validateControl('list')
;$iterations = 0; foreach ($catalogs as $catalog): ?>			<li<?php if ($_l->tmp = array_filter(array($catalog->id == $catalogId ? 'active' : NULL))) echo ' class="' . htmlSpecialChars(implode(" ", array_unique($_l->tmp))) . '"' ?>>
				<a href="<?php echo htmlSpecialChars($_control->link("Catalog:list", array($catalog->id))) ?>
"><?php echo Nette\Templating\Helpers::escapeHtml($catalog->title, ENT_NOQUOTES) ?></a>
			</li>
<?php $iterations++; endforeach ;
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

<?php if ($_l->extends) { ob_end_clean(); return Nette\Latte\Macros\CoreMacros::includeTemplate($_l->extends, get_defined_vars(), $template)->render(); }
call_user_func(reset($_l->blocks['content']), $_l, get_defined_vars()) ; 