<?php 

require_once __DIR__ . "/../vendor/autoload.php";

use Tickets\DB;
use Tickets\CreateTables;

$db = DB::connect();

$createTables = new CreateTables($db);

?>