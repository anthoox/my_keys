<?php

function encryptPassword($plainText)
{
  $env = parse_ini_file(__DIR__ . '/../../.env');

  $key = $env['ENCRYPT_KEY'];
  $iv = $env['ENCRYPT_IV'];
  return openssl_encrypt($plainText, 'AES-256-CBC', $key, 0, $iv);
}

function decryptPassword($encryptedText)
{
  $env = parse_ini_file(__DIR__ . '/../../.env');

  $key = $env['ENCRYPT_KEY'];
  $iv = $env['ENCRYPT_IV'];
  return openssl_decrypt($encryptedText, 'AES-256-CBC', $key, 0, $iv);
}
