<?php //netteCache[01]000410a:2:{s:4:"time";s:21:"0.61471800 1391789942";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:10:"checkFiles";}i:1;s:86:"C:\Users\User\Dropbox\IIVOS_STV\Netbeans\TODOLIST\todolist\app\templates\@layout.latte";i:2;i:1391789942;}i:1;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:10:"checkConst";}i:1;s:25:"Nette\Framework::REVISION";i:2;s:30:"2855c33 released on 2013-08-28";}}}?><?php

// source file: C:\Users\User\Dropbox\IIVOS_STV\Netbeans\TODOLIST\todolist\app\templates\@layout.latte

?><?php
// prolog Nette\Latte\Macros\CoreMacros
list($_l, $_g) = Nette\Latte\Macros\CoreMacros::initRuntime($template, 'wt2hjo2tq9')
;
// prolog Nette\Latte\Macros\UIMacros
//
// block title
//
if (!function_exists($_l->blocks['title'][] = '_lbb1769959cb_title')) { function _lbb1769959cb_title($_l, $_args) { extract($_args)
;
}}

//
// block head
//
if (!function_exists($_l->blocks['head'][] = '_lb6cb832a176_head')) { function _lb6cb832a176_head($_l, $_args) { extract($_args)
;
}}

//
// block _content
//
if (!function_exists($_l->blocks['_content'][] = '_lb1bd9b26bb7__content')) { function _lb1bd9b26bb7__content($_l, $_args) { extract($_args); $_control->validateControl('content')
;Nette\Latte\Macros\UIMacros::callBlock($_l, 'content', $template->getParameters()) ;
}}

//
// block scripts
//
if (!function_exists($_l->blocks['scripts'][] = '_lb7286514d42_scripts')) { function _lb7286514d42_scripts($_l, $_args) { extract($_args)
?>		<script src="<?php echo htmlSpecialChars($basePath) ?>/js/jquery.js"></script>
		<script src="<?php echo htmlSpecialChars($basePath) ?>/js/bootstrap.js"></script>
		<script src="<?php echo htmlSpecialChars($basePath) ?>/js/netteForms.js"></script>
		<script src="<?php echo htmlSpecialChars($basePath) ?>/js/nette.ajax.js"></script>
		<script src="<?php echo htmlSpecialChars($basePath) ?>/js/main.js"></script>
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
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="description" content="">
<?php if (isset($robots)): ?>		<meta name="robots" content="<?php echo htmlSpecialChars($robots) ?>">
<?php endif ?>

		<title>ÚKOLNÍČEK - <?php if ($_l->extends) { ob_end_clean(); return Nette\Latte\Macros\CoreMacros::includeTemplate($_l->extends, get_defined_vars(), $template)->render(); }
ob_start(); call_user_func(reset($_l->blocks['title']), $_l, get_defined_vars()); echo $template->striptags(ob_get_clean())  ?></title>

		<link rel="stylesheet" media="screen,projection,tv" href="<?php echo htmlSpecialChars($basePath) ?>/css/bootstrap.css">
		<link rel="stylesheet" media="screen,projection,tv" href="<?php echo htmlSpecialChars($basePath) ?>/css/screen.css">
		<link rel="stylesheet" media="print" href="<?php echo htmlSpecialChars($basePath) ?>/css/print.css">
		<link rel="shortcut icon" href="<?php echo htmlSpecialChars($basePath) ?>/favicon.ico">
		<?php call_user_func(reset($_l->blocks['head']), $_l, get_defined_vars())  ?>

	</head>

	<body>
		<script> document.body.className += ' js'</script>

		<div class="container">
<?php $iterations = 0; foreach ($flashes as $flash): ?>			<div class="flash <?php echo htmlSpecialChars($flash->type) ?>
"><?php echo Nette\Templating\Helpers::escapeHtml($flash->message, ENT_NOQUOTES) ?></div>
<?php $iterations++; endforeach ?>
			<div class="navbar navbar-inverse">
				<div class="navbar-inner">
					<ul class="nav pull-left">
<?php if ($user->isLoggedIn()): ?>						<li class="active"><a href="<?php echo htmlSpecialChars($_control->link("Catalog:list")) ?>
">Seznamy</a></li>
<?php endif ?>
					</ul>
					<ul class="nav pull-right">
<?php if ($user->isLoggedIn()): ?>
							<li><?php $_ctrl = $_control->getComponent("logoutControl"); if ($_ctrl instanceof Nette\Application\UI\IRenderable) $_ctrl->validateControl(); $_ctrl->render() ?></li>
<?php else: ?>
							<li class="active"><a href="<?php echo htmlSpecialChars($_control->link("Application:login")) ?>
">Přihlášení</a></li>
<?php endif ?>
					</ul>
				</div>
			</div>

<div id="<?php echo $_control->getSnippetId('content') ?>"><?php call_user_func(reset($_l->blocks['_content']), $_l, $template->getParameters()) ?>
</div>
		</div>

<?php call_user_func(reset($_l->blocks['scripts']), $_l, get_defined_vars())  ?>
	</body>
</html>
