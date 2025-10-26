<?php
function renderServices(array $services)
{
  // var_dump($services);
  // die();
  echo '<div class="container my-5">
  <h1 class="mb-4 text-center">Mis Aplicaciones</h1>
  <div class="row g-4">';
  if (empty($services)) {
    
    echo "<p class='text-center text-muted'>Aún no has añadido ningún servicio.</p>";
    return;
  }

  foreach ($services as $service) {
    $serviceName = htmlspecialchars($service['name']);
    // $username = htmlspecialchars($service['username'] ?? 'No especificado');
    $updatedAt = htmlspecialchars($service['updated_at'] ?? 'Sin fecha');

    echo "
    <div class='col-md-4'>
      <div class='card shadow-sm border-0'>
        <div class='card-header bg-primary text-white d-flex align-items-center'>
          <i class='bi bi-app-indicator me-2'></i>
          <h5 class='card-title mb-0'>{$serviceName}</h5>
        </div>
        <div class='card-body'>
          <div class='mb-3 d-flex align-items-center w-100 justify-content-between'>
            <div class='w-70'>
              <p class='mb-2'><strong>Usuario:</strong> {$serviceName}</p>
            </div>
            <div>
              <button class='btn btn-sm btn-copy'>
                <i class='bi bi-clipboard'></i>
              </button>
            </div>
          </div>
          <div class='mb-3 d-flex align-items-center w-100 justify-content-between'>
            <div class='w-70'>
              <strong class='me-2'>Contraseña:</strong>
              <span class='password flex-grow-1'>********</span>
            </div>
            <div class='d-flex w-25'>
              <button class='btn btn-sm btn-show'><i class='bi bi-eye text-primary'></i></button>
              <button class='btn btn-sm btn-copy'><i class='bi bi-clipboard'></i></button>
            </div>
          </div>
          <small class='text-muted'>Última actualización: {$updatedAt}</small>
        </div>
      </div>
    </div>";
  }
  echo '  </div>';
}
