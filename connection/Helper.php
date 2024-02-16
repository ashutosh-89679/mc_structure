<?php

function cleanData($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  function checkDateFormat($date) {
    $date_object = DateTime::createFromFormat('Y-m-d', $date);
    return $date_object !== false && $date_object->format('Y-m-d') === $date;
}

?>