  <?php

  if (!empty($_SESSION['success_message'])) {
    echo "<div class='alert alert-success'>{$_SESSION['success_message']}</div>";
    unset($_SESSION['success_message']);
  }

  if (!empty($_SESSION['error_message'])) {
    echo "<div class='alert alert-danger'>{$_SESSION['error_message']}</div>";
    unset($_SESSION['error_message']);
  }
  ?>



  <?php require_once __DIR__  . '/../../../app/views/components/modals/modalsUsers.php' ?>

  </div>

</div>
  <?php require_once __DIR__  . '/../../../app/views/components/footer.php' ?>