<?php
function showError($errors)
{
  if (!empty($errors)) {
    echo "<div class='alert alert-danger'><ul>";
    // Si $errors es un array, recorremos cada elemento
    if (is_array($errors)) {
      foreach ($errors as $error) {
        echo "<li>$error</li>";
      }
    } else {
      // Si es solo un string
      echo "<li>$errors</li>";
    }
    echo "</ul></div>";
  }
}
