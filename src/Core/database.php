<?php 

namespace Core;

require_once __DIR__ . "/../../vendor/autoload.php";

use Core\DB;
use Core\CreateTables;

$db = DB::connect();

$createTables = new CreateTables($db);

?>