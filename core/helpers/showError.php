<?php
function showError($errors)
{
  if (!empty($errors)) {
    echo "
       <div class='d-flex justify-content-center align-items-center  w-100'>
    <div class='alert alert-danger col-6'><ul class='mb-0'>";
    // Si $errors es un array, recorremos cada elemento
    if (is_array($errors)) {
      foreach ($errors as $error) {
        echo "<li>$error</li>";
      }
    } else {
      // Si es solo un string
      echo "<li>$errors</li>";
    }
    echo "</ul></div></div>";
  }
  if (isset($_SESSION['errors'])) {
    unset($_SESSION['errors']);
  }
}
