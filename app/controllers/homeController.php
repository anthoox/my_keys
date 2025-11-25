<?php

/**
 * Controlador HomeController
 * --------------------------
 * Controlador encargado de gestionar la pantalla de inicio de la aplicación.
 * 
 * Funcionalidades:
 * - index(): carga la vista principal de la pantalla de inicio.
 * 
 * Notas:
 * - Sigue la convención MVC del proyecto.
 * - La vista está ubicada en /app/views/home/index.php.
 */
class HomeController
{

  /**
   * Método index
   * -------------
   * Carga la vista de inicio de la aplicación.
   * 
   * No recibe parámetros. Simplemente incluye la vista correspondiente.
   * 
   * @return void
   */
  public function index(): void
  {
    // Incluir la vista de inicio
    require_once __DIR__ . '/../views/home/index.php';
  }
}
