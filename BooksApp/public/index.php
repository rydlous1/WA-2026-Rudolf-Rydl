<?php

//pro účely výuky a ladění serveru
//je vhodné zapnout kompletní zobrazování chyb
ini_set('display_error', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//načtení třídy routeru, která se postará o zpracování URL
require_once '../';

//inicializace aplikace a spuštění procesu 
$app = new App();