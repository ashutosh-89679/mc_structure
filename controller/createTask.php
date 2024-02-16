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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $jsonData = json_decode($rawPatchData, true);
    
    if (isset($jsonData['title']) && isset($jsonData['description']) && isset($jsonData['due_date'])) {
        $title = $jsonData['title'];
        $description = $jsonData['description'];
        $due_date = cleanData($jsonData['due_date']);


        if(checkDateFormat($due_date) == false) {
            $reponse = new Response(false, 400, 'due_date not in correct format');
            $reponse->send();
        } else if (!is_string($title) || !is_string($description)){
            $reponse = new Response(false, 400, 'title or description is not a string');
            $reponse->send();
        }
        else {
            $query = "INSERT INTO tasks (title, description, date) VALUES (:title, :description, :due_date)";
            $statement = $writeDB->prepare($query);
            $statement->bindParam(':title', $title);
            $statement->bindParam(':description', $description);
            $statement->bindParam(':due_date', $due_date);
            $statement->execute();

            if ($statement->execute()) {
                $response = new Response(true, 200, 'Task created successfully');
                $response->send();
            } else {
                $response = new Response(false, 500, 'Internal Server Error - Unable to create task');
                $response->send();
            }
        }
    } else {
        $reponse = new Response(false, 400, 'title not set');
        $reponse->send();
    }
}
?>
