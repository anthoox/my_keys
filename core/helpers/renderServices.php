<?php
function renderServices(array $services)
{
  echo '<div class="container my-5">
  <h1 class="mb-4 text-center">Mis Aplicaciones</h1>
  <div class="row g-4">';

  if (empty($services)) {
    echo "<p class='text-center text-muted'>Aún no has añadido ningún servicio.</p>";
    echo '</div></div>'; // cerramos container aunque no haya servicios
    return;
  }

  foreach ($services as $service) {
    $serviceName = htmlspecialchars($service['name']);
    $userName = htmlspecialchars($service['username'] ?? 'No especificado');
    $updatedAtRaw = $service['updated_at'] ?? null;
    $updatedAt = $updatedAtRaw ? date('Y-m-d', strtotime($updatedAtRaw)) : 'Sin fecha';

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
              <p class='mb-2'><strong>Usuario:</strong> {$userName}</p>
            </div>
            <div>
                     <button class='btn btn-sm btn-copy'><svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' viewBox='0 0 24 24'>
                    <g fill='none' stroke='#666666' stroke-linecap='round' stroke-linejoin='round' stroke-width='2'>
                      <path d='M7 9.667A2.667 2.667 0 0 1 9.667 7h8.666A2.667 2.667 0 0 1 21 9.667v8.666A2.667 2.667 0 0 1 18.333 21H9.667A2.667 2.667 0 0 1 7 18.333z' />
                      <path d='M4.012 16.737A2 2 0 0 1 3 15V5c0-1.1.9-2 2-2h10c.75 0 1.158.385 1.5 1' />
                    </g>
                  </svg></button>
            </div>
          </div>

          <div class='mb-3 d-flex align-items-center w-100 justify-content-between'>
            <div class='w-70'>
              <strong class='me-2'>Contraseña:</strong>
              <span class='password flex-grow-1'>********</span>
            </div>
            <div class='d-flex'>
              <button class='btn btn-sm btn-show'>
                <!-- SVG del ojo -->
                <svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' viewBox='0 0 24 24'>
                  <path fill='#0d6efd' d='M20.8 17v-1.5c0-1.4-1.4-2.5-2.8-2.5s-2.8 1.1-2.8 2.5V17c-.6 0-1.2.6-1.2 1.2v3.5c0 .7.6 1.3 1.2 1.3h5.5c.7 0 1.3-.6 1.3-1.2v-3.5c0-.7-.6-1.3-1.2-1.3m-1.3 0h-3v-1.5c0-.8.7-1.3 1.5-1.3s1.5.5 1.5 1.3zM15 12c-.9.7-1.5 1.6-1.7 2.7c-.4.2-.8.3-1.3.3c-1.7 0-3-1.3-3-3s1.3-3 3-3s3 1.3 3 3m-3 7.5c-5 0-9.3-3.1-11-7.5c1.7-4.4 6-7.5 11-7.5s9.3 3.1 11 7.5c-.2.5-.5 1-.7 1.5c-.4-.7-.9-1.3-1.6-1.7c-1.7-3.3-5-5.3-8.7-5.3c-3.8 0-7.2 2.1-8.8 5.5c1.7 3.4 5.1 5.5 8.8 5.5h.1c-.1.2-.1.5-.1.7z'/>
                </svg>
              </button>
              <button class='btn btn-sm btn-copy'>
                <!-- SVG del copiar -->
                <svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' viewBox='0 0 24 24'>
                  <g fill='none' stroke='#666666' stroke-linecap='round' stroke-linejoin='round' stroke-width='2'>
                    <path d='M7 9.667A2.667 2.667 0 0 1 9.667 7h8.666A2.667 2.667 0 0 1 21 9.667v8.666A2.667 2.667 0 0 1 18.333 21H9.667A2.667 2.667 0 0 1 7 18.333z'/>
                    <path d='M4.012 16.737A2 2 0 0 1 3 15V5c0-1.1.9-2 2-2h10c.75 0 1.158.385 1.5 1'/>
                  </g>
                </svg>
              </button>
            </div>
          </div>

          <small class='text-muted'>Última actualización: {$updatedAt}</small>
        </div>
      </div>
    </div>";
  }

  echo '</div>'; // Cierra row
}
