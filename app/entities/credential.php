<?php

/**
 * Entidad que representa unas credenciales asociadas a un servicio.
 * 
 * Esta clase modela los datos de acceso almacenados en la base de datos,
 * incluyendo el ID del servicio, el nombre de usuario y la contraseña cifrada.
 * 
 * La entidad NO cifra automáticamente en el constructor, solo al usar setPassword(),
 * lo cual permite flexibilidad al cargar datos desde la BD.
 */
class Credential
{
  /** @var int|null ID interno de la credencial (autogenerado en BD) */
  private $id;

  /** @var int ID del servicio al que pertenecen las credenciales */
  private $serviceId;

  /** @var string Nombre de usuario usado para acceder al servicio */
  private $username;

  /** @var string|null Contraseña cifrada (no en texto plano) */
  private $passwordEncrypted;


  /**
   * Constructor de la entidad Credential
   *
   * @param int         $serviceId          ID del servicio propietario.
   * @param string      $username           Nombre de usuario.
   * @param string|null $passwordEncrypted  Contraseña ya cifrada (opcional).
   */
  public function __construct($serviceId, $username, $passwordEncrypted = null)
  {
    $this->serviceId = $serviceId;
    $this->username = $username;
    $this->passwordEncrypted = $passwordEncrypted;
  }


  /**
   * Obtiene el ID de la credencial.
   * @return int|null
   */
  public function getId()
  {
    return $this->id;
  }


  /**
   * Obtiene el ID del servicio asociado.
   * @return int
   */
  public function getServiceId()
  {
    return $this->serviceId;
  }


  /**
   * Obtiene el nombre de usuario de la credencial.
   * @return string
   */
  public function getUsername()
  {
    return $this->username;
  }


  /**
   * Obtiene la contraseña cifrada almacenada.
   * @return string|null
   */
  public function getPasswordEncrypted()
  {
    return $this->passwordEncrypted;
  }


  /**
   * Establece una nueva contraseña (en texto plano) y la cifra automáticamente.
   *
   * @param string $password Contraseña SIN cifrar.
   * @return void
   */
  public function setPassword($password)
  {
    // encryptPassword() debe ser una función helper global
    $this->passwordEncrypted = encryptPassword($password);
  }
}
