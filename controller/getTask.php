<?php
require_once('../connection/db.php');
require_once('../model/Response.php');
require_once('../connection/Helper.php');


try {
    $writeDB = DB::connectWriteDB();
    $readDB = DB::connectReadDB();
  }
  catch(PDOException $ex) {
    // log connection error for troubleshooting and return a json error response
    error_log("Connection Error: ".$ex, 0);
    $response = new Response(false, 500, 'Connection Error');
  }

$rawPatchData = file_get_contents('php://input');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $query = "SELECT * FROM tasks";
    $statement = $readDB->prepare($query);
    $statement->execute();
    $tasks = $statement->fetchAll();

    if(count($tasks) > 0) {
        $response = new Response(true, 200, 'Tasks retrieved successfully', $tasks);
        $response->send();
    } else {
        $response = new Response(false, 404, 'No tasks found');
        $response->send();
    }

}