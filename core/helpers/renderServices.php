<?php
function renderServices(array $services)
{
  echo '<div class="container">
  <h1 class="mb-4">Contraseñas</h1>
  <div class="row g-4">';

  if (empty($services)) {
    echo "<p class='text-center text-muted'>Aún no has añadido ningún servicio.</p>";
    echo '</div></div>'; // cerramos container aunque no haya servicios
    return;
  }

  foreach ($services as $service) {

    $service_id = htmlspecialchars($service->getId());
    $service_name = htmlspecialchars($service->getName());
    $user_name = htmlspecialchars($service->getUsername() ?? 'No especificado');
    $updated_at_raw = $service->getUpdatedAt();
    $updated_at = $updated_at_raw ? date('Y-m-d', strtotime($updated_at_raw)) : 'Sin fecha';

    echo "
    <div class='col-md-4'>
      <div class='card shadow-sm border-0'>
        <div class='card-header bg-primary text-white d-flex align-items-center justify-content-between'>
          <h5 class='card-title mb-0'>{$service_name}</h5>
          <div>
            <div class='btn btn-sm btn-show p-1 edit-service-btn' data-bs-toggle='modal' 
            data-bs-target='#editServiceModal'
            data-id='{$service_id}'
            data-name='{$service_name}'
            data-user='{$user_name}'
            data-password='********'>
              <svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' viewBox='0 0 1792 1408'>
                <path fill='#fbfbfb' d='m888 1056l116-116l-152-152l-116 116v56h96v96zm440-720q-16-16-33 1L945 687q-17 17-1 33t33-1l350-350q17-17 1-33m80 594v190q0 119-84.5 203.5T1120 1408H288q-119 0-203.5-84.5T0 1120V288Q0 169 84.5 84.5T288 0h832q63 0 117 25q15 7 18 23q3 17-9 29l-49 49q-14 14-32 8q-23-6-45-6H288q-66 0-113 47t-47 113v832q0 66 47 113t113 47h832q66 0 113-47t47-113V994q0-13 9-22l64-64q15-15 35-7t20 29m-96-738l288 288l-672 672H640V864zm444 132l-92 92l-288-288l92-92q28-28 68-28t68 28l152 152q28 28 28 68t-28 68' />
              </svg>
            </div>
            <div class='btn btn-sm btn-show p-1 del-service-btn' data-bs-toggle='modal'  data-bs-target='#delServiceModal' data-id='{$service_id}'>
              <svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' viewBox='0 0 24 24'>
              <path fill='#fbfbfb' d='M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zM17 6H7v13h10zM9 17h2V8H9zm4 0h2V8h-2zM7 6v13z' />
              </svg>
          </div>
        </div>


        </div>
        <div class='card-body'>
          <div class='mb-3 d-flex align-items-center w-100 justify-content-between'>
            <div class='w-70'>
              <p class='mb-2'><strong>Usuario:</strong><span id='userName'> {$user_name}</span> </p>
            </div>
            <div>
              <button class='btn btn-sm btn-copy p-1'>
                <svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' viewBox='0 0 24 24'>
                 <g fill='none' stroke='#666666' stroke-linecap='round' stroke-linejoin='round' stroke-width='2'>
                    <path d='M7 9.667A2.667 2.667 0 0 1 9.667 7h8.666A2.667 2.667 0 0 1 21 9.667v8.666A2.667 2.667 0 0 1 18.333 21H9.667A2.667 2.667 0 0 1 7 18.333z' />
                    <path d='M4.012 16.737A2 2 0 0 1 3 15V5c0-1.1.9-2 2-2h10c.75 0 1.158.385 1.5 1' />
                  </g>
                </svg>
              </button>
            </div>
          </div>

          <div class='mb-3 d-flex align-items-center w-100 justify-content-between'>
            <div class='w-70'>
              <strong class='me-2'>Contraseña:</strong>
              <span class='password flex-grow-1'>********</span>
            </div>
            <div class='d-flex'>
              <button class='btn btn-sm btn-show p-1 me-3'>
                <!-- SVG del ojo -->
                <svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' viewBox='0 0 24 24'>
                  <path fill='#0d6efd' d='M20.8 17v-1.5c0-1.4-1.4-2.5-2.8-2.5s-2.8 1.1-2.8 2.5V17c-.6 0-1.2.6-1.2 1.2v3.5c0 .7.6 1.3 1.2 1.3h5.5c.7 0 1.3-.6 1.3-1.2v-3.5c0-.7-.6-1.3-1.2-1.3m-1.3 0h-3v-1.5c0-.8.7-1.3 1.5-1.3s1.5.5 1.5 1.3zM15 12c-.9.7-1.5 1.6-1.7 2.7c-.4.2-.8.3-1.3.3c-1.7 0-3-1.3-3-3s1.3-3 3-3s3 1.3 3 3m-3 7.5c-5 0-9.3-3.1-11-7.5c1.7-4.4 6-7.5 11-7.5s9.3 3.1 11 7.5c-.2.5-.5 1-.7 1.5c-.4-.7-.9-1.3-1.6-1.7c-1.7-3.3-5-5.3-8.7-5.3c-3.8 0-7.2 2.1-8.8 5.5c1.7 3.4 5.1 5.5 8.8 5.5h.1c-.1.2-.1.5-.1.7z'/>
                </svg>
              </button> 
              <button class='btn btn-sm btn-copy p-1'>
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

          <small class='text-muted'>Última actualización: {$updated_at}</small>
        </div>

        
      </div>
    </div>";
  }

  echo '</div>'; // Cierra row
}
