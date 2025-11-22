<?php

/**
 * Entidad que representa un servicio de un usuario.
 * 
 * Esta clase modela los servicios registrados por los usuarios en la aplicación,
 * incluyendo información básica, categoría, notas opcionales y metadatos de creación/actualización.
 * 
 * También puede incluir el nombre de usuario de las credenciales asociadas (opcional).
 */
class Service
{
  /** @var int ID interno del servicio (autogenerado en BD) */
  private int $id;

  /** @var int ID del usuario propietario del servicio */
  private int $userId;

  /** @var string Nombre del servicio */
  private string $name;

  /** @var string Categoría del servicio */
  private string $category;

  /** @var string|null Notas adicionales del servicio (opcional) */
  private ?string $notes;

  /** @var string|null Fecha de creación en formato YYYY-MM-DD HH:MM:SS (opcional) */
  private ?string $createdAt;

  /** @var string|null Fecha de última actualización (opcional) */
  private ?string $updatedAt;

  /** @var string|null Nombre de usuario de las credenciales asociadas (opcional) */
  private ?string $username;


  /**
   * Constructor de la entidad Service.
   *
   * @param int         $id         ID del servicio.
   * @param int         $userId     ID del usuario propietario.
   * @param string      $category   Categoría del servicio.
   * @param string      $name       Nombre del servicio.
   * @param string|null $notes      Notas opcionales del servicio.
   * @param string|null $createdAt  Fecha de creación (opcional).
   * @param string|null $updatedAt  Fecha de actualización (opcional).
   * @param string|null $username   Usuario asociado a las credenciales (opcional).
   */
  public function __construct(
    int $id,
    int $userId,
    string $category,
    string $name,
    ?string $notes = null,
    ?string $createdAt = null,
    ?string $updatedAt = null,
    ?string $username = null
  ) {
    $this->id = $id;
    $this->userId = $userId;
    $this->name = $name;
    $this->category = $category;
    $this->notes = $notes;
    $this->createdAt = $createdAt;
    $this->updatedAt = $updatedAt;
    $this->username = $username;
  }


  // ---------------------------------------------
  // GETTERS
  // ---------------------------------------------

  /** @return int Devuelve el ID del servicio */
  public function getId(): int
  {
    return $this->id;
  }

  /** @return int Devuelve el ID del usuario propietario */
  public function getUserId(): int
  {
    return $this->userId;
  }

  /** @return string Devuelve el nombre del servicio */
  public function getName(): string
  {
    return $this->name;
  }

  /** @return string Devuelve la categoría del servicio */
  public function getCategory(): string
  {
    return $this->category;
  }

  /** @return string|null Devuelve las notas del servicio (opcional) */
  public function getNotes(): ?string
  {
    return $this->notes;
  }

  /** @return string|null Devuelve la fecha de creación */
  public function getCreatedAt(): ?string
  {
    return $this->createdAt;
  }

  /** @return string|null Devuelve la fecha de actualización */
  public function getUpdatedAt(): ?string
  {
    return $this->updatedAt;
  }

  /** @return string|null Devuelve el nombre de usuario de las credenciales asociadas */
  public function getUsername(): ?string
  {
    return $this->username;
  }


  // ---------------------------------------------
  // SETTERS
  // ---------------------------------------------

  /**
   * Establece el nombre de usuario asociado a las credenciales.
   *
   * @param string|null $username Nombre de usuario
   * @return void
   */
  public function setUsername(?string $username): void
  {
    $this->username = $username;
  }
}
