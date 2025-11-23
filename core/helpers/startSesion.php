<?php

/**
 * Inicia la sesión PHP si no ha sido iniciada aún.
 *
 * Comprueba el estado de la sesión y solo llama a session_start()
 * si no hay ninguna sesión activa.
 */
function startSession(): void
{
  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }
}
