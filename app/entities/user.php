<?php

/**
 * Entidad que representa un usuario de la aplicación.
 * 
 * Esta clase modela a los usuarios registrados en la aplicación,
 * incluyendo sus datos básicos, correo electrónico, contraseña y fecha de creación.
 */
class User
{
  /** @var int ID del usuario (autogenerado en la base de datos) */
  private $id;

  /** @var string Nombre de usuario */
  private $username;

  /** @var string Correo electrónico del usuario */
  private $email;

  /** @var string|null Contraseña hasheada del usuario (opcional) */
  private $password_hash;

  /** @var string|null Fecha de creación del usuario (opcional) */
  private $created_at;


  /**
   * Constructor de la entidad User
   *
   * @param int         $id            ID del usuario.
   * @param string      $username      Nombre de usuario.
   * @param string      $email         Correo electrónico.
   * @param string|null $password_hash Contraseña hasheada (opcional).
   * @param string|null $created_at    Fecha de creación (opcional).
   */
  public function __construct(
    int $id,
    string $username,
    string $email,
    ?string $password_hash = null,
    ?string $created_at = null
  ) {
    $this->id = $id;
    $this->username = $username;
    $this->email = $email;
    $this->password_hash = $password_hash;
    $this->created_at = $created_at;
  }


  // ---------------------------------------------
  // GETTERS
  // ---------------------------------------------

  /** @return int Devuelve el ID del usuario */
  public function getId()
  {
    return $this->id;
  }

  /** @return string Devuelve el nombre de usuario */
  public function getUsername()
  {
    return $this->username;
  }

  /** @return string|null Devuelve la contraseña hasheada */
  public function getPasswordHash()
  {
    return $this->password_hash;
  }

  /** @return string Devuelve el correo electrónico del usuario */
  public function getEmail()
  {
    return $this->email;
  }

  /** @return string|null Devuelve la fecha de creación del usuario */
  public function getCreatedAt()
  {
    return $this->created_at;
  }


  // ---------------------------------------------
  // SETTERS
  // ---------------------------------------------

  /**
   * Establece el ID del usuario.
   *
   * @param int $id
   * @return self
   */
  public function setId($id): self
  {
    $this->id = $id;
    return $this;
  }

  /**
   * Establece el nombre de usuario.
   *
   * @param string $username
   * @return self
   */
  public function setUsername($username): self
  {
    $this->username = $username;
    return $this;
  }

  /**
   * Establece el correo electrónico.
   *
   * @param string $email
   * @return self
   */
  public function setEmail($email): self
  {
    $this->email = $email;
    return $this;
  }

  /**
   * Establece la contraseña hasheada del usuario.
   *
   * @param string $password_hash
   * @return self
   */
  public function setPasswordHash($password_hash): self
  {
    $this->password_hash = $password_hash;
    return $this;
  }

  /**
   * Establece la fecha de creación del usuario.
   *
   * @param string $created_at
   * @return self
   */
  public function setCreatedAt($created_at): self
  {
    $this->created_at = $created_at;
    return $this;
  }
}
