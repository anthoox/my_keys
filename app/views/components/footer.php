<?php

/**
 * Footer de la aplicación
 *
 * Funciones:
 * - Cierre de contenedores principales (<div> y <body>)
 * - Definición de la constante BASE_URL para JS
 * - Inclusión de scripts necesarios:
 *     - Bootstrap JS (bundle)
 *     - Script propio de la aplicación (script.js)
 * - Etiqueta <footer> vacía (puede usarse para contenido adicional en el futuro)
 *
 * Nota:
 * - Se recomienda no colocar lógica de PHP pesada aquí.
 * - Mantener este archivo limpio y enfocado solo en la parte visual y scripts.
 */
require_once __DIR__ . '/../../../core/config/config.php';
?>

</div>
</div>

<script>
  const BASE_URL = "<?= FULL_BASE_URL ?>";
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= FULL_BASE_URL ?>/js/script.js"></script>

</body>

<footer></footer>

</html>