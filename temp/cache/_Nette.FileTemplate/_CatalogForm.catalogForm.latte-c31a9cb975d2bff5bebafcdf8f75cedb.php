<?php //netteCache[01]000436a:2:{s:4:"time";s:21:"0.67246600 1391789942";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:10:"checkFiles";}i:1;s:111:"C:\Users\User\Dropbox\IIVOS_STV\Netbeans\TODOLIST\todolist\app\components\Catalog\CatalogForm\catalogForm.latte";i:2;i:1391789942;}i:1;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:10:"checkConst";}i:1;s:25:"Nette\Framework::REVISION";i:2;s:30:"2855c33 released on 2013-08-28";}}}?><?php

// source file: C:\Users\User\Dropbox\IIVOS_STV\Netbeans\TODOLIST\todolist\app\components\Catalog\CatalogForm\catalogForm.latte

?><?php
// prolog Nette\Latte\Macros\CoreMacros
list($_l, $_g) = Nette\Latte\Macros\CoreMacros::initRuntime($template, 'dtidf9gumo')
;
// prolog Nette\Latte\Macros\UIMacros

// snippets support
if (!empty($_control->snippetMode)) {
	return Nette\Latte\Macros\UIMacros::renderSnippets($_control, $_l, get_defined_vars());
}

//
// main template
//
Nette\Latte\Macros\FormMacros::renderFormBegin($form = $_form = $_control["catalogForm"], array()) ?>
	<p><?php if ($_label = $_form["title"]->getLabel()) echo $_label->addAttributes(array()) ; echo $_form["title"]->getControl()->addAttributes(array()) ?></p>
	<p><?php echo $_form["ok"]->getControl()->addAttributes(array()) ?></p>
<?php Nette\Latte\Macros\FormMacros::renderFormEnd($_form) ;