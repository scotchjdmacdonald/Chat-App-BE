<?php
    include_once __DIR__ . '/../db/database.php';
    include_once __DIR__ . '/../api/routes/Routes.php';     
    require __DIR__ . '/../../vendor/autoload.php';
    
    $app = (new Routes())->get();
    
    $database = new Database();
    $db = $database->connect();    
    $database->createTables($db);

    $app->run();
?>