<?php

declare(strict_types=1);

/**
 * Crypto helper
 * Funciones para encriptar y desencriptar contraseñas de servicios.
 * 
 * Mejoras respecto a la versión anterior:
 * - Variables de clave y IV cargadas una sola vez
 * - Tipado estricto y declaración de tipos de retorno
 * - Manejo de errores de OpenSSL mediante excepciones
 * - Compatible con PHP 8+
 */

$env = parse_ini_file(__DIR__ . '/../../.env');
if (!$env || empty($env['ENCRYPT_KEY']) || empty($env['ENCRYPT_IV'])) {
  throw new RuntimeException("Faltan las variables ENCRYPT_KEY o ENCRYPT_IV en el archivo .env");
}

// Clave y vector de inicialización (IV) globales
define('ENCRYPT_KEY', $env['ENCRYPT_KEY']);
define('ENCRYPT_IV', $env['ENCRYPT_IV']);

/**
 * Encripta un texto usando AES-256-CBC
 *
 * @param string $plainText Texto plano a encriptar
 * @return string Texto encriptado en base64
 * @throws RuntimeException Si la encriptación falla
 */
function encryptPassword($plainText)
{
  $encrypted = openssl_encrypt($plainText, 'AES-256-CBC', ENCRYPT_KEY, 0, ENCRYPT_IV);
  if ($encrypted === false) {
    throw new RuntimeException("Error al encriptar el texto");
  }
  return $encrypted;
}

/**
 * Desencripta un texto previamente encriptado con AES-256-CBC
 *
 * @param string $encryptedText Texto encriptado
 * @return string Texto desencriptado
 * @throws RuntimeException Si la desencriptación falla
 */
function decryptPassword(string $encryptedText): string
{
  $decrypted = openssl_decrypt($encryptedText, 'AES-256-CBC', ENCRYPT_KEY, 0, ENCRYPT_IV);
  if ($decrypted === false) {
    throw new RuntimeException("Error al desencriptar el texto");
  }
  return $decrypted;
}