 <section class="w-100 hero mt-5 d-flex gap-4 flex-column justify-content-center align-items-center">
   <div class="hero-image">
     <img src="<?= FULL_BASE_URL ?>/resources/imgs/hero.png" alt="Imagen de candado">
   </div>
   <h1 class="mt-2">Bienvenido a Gestor de Claves</h1>
   <p class="col-6 text-center">
     Gestiona todos tus servicios y contraseñas de forma segura, rápida y sencilla.
     Accede a tus datos, actualiza tu información y protege tus cuentas con un solo lugar,
     pensado para simplificar tu día a día y mantener tu información bajo control.
   </p>

   <div class="d-flex gap-2  justify-content-center">
     <a href="<?= FULL_BASE_URL ?>/?c=auth&a=login" class="btn btn-primary btn-hero">Iniciar Sesión</a>
     <a href="<?= FULL_BASE_URL ?>/?c=auth&a=register" class="btn btn-outline-primary btn-hero">Registro</a>
   </div>
 </section>

 <?php
  require_once __DIR__ . '/../../views/components/footer.php';

  ?>