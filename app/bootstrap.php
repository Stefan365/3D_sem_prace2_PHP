<?php

/**
 * TODOLIST
 * Školní projekt k seznámení s Nette a ORM
 * 
 * @author MMR <miroslav.mrazek@gmail.com>
 */

use Nette\Config\Configurator;


/*
 * Příprava a vytvoření DI kontejneru
 */

# Načteme třídy Nette
require __DIR__ . '/../libs/autoload.php';

# Vytvoříme nový konfigurátor
$configurator = new Configurator;

# Povolíme ladící a logovací funkce
//$configurator->setDebugMode(TRUE);  # vynutí debug mód i na produkčním serveru
$configurator->enableDebugger(__DIR__ . '/../log');

# Zapneme a nakonfigurujeme RobotLoader
$configurator->setTempDirectory(__DIR__ . '/../temp');
$configurator->createRobotLoader()
	->addDirectory(__DIR__)              # APP_DIR
	->addDirectory(__DIR__ . '/../libs') # LIBS_DIR
	->register();

# Načteme konfigurační soubory
$configurator->addConfig(__DIR__ . '/config/config.neon');
$configurator->addConfig(__DIR__ . '/config/config.local.neon');

# Z připraveného konfigurátoru vytvoříme a vrátíme DI kontejner
return $configurator->createContainer();
