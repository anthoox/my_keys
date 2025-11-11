<?php

class Service
{
  private int $id;
  private int $userId;
  private string $name;
  private string $category;
  private ?string $notes;
  private ?string $createdAt;
  private ?string $updatedAt;
  private ?string $username; // usuario de las credenciales, opcional

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

  // Getters
  public function getId(): int
  {
    return $this->id;
  }
  public function getUserId(): int
  {
    return $this->userId;
  }
  public function getName(): string
  {
    return $this->name;
  }
  public function getCategory(): string
  {
    return $this->category;
  }
  public function getNotes(): ?string
  {
    return $this->notes;
  }
  public function getCreatedAt(): ?string
  {
    return $this->createdAt;
  }
  public function getUpdatedAt(): ?string
  {
    return $this->updatedAt;
  }
  public function getUsername(): ?string
  {
    return $this->username;
  }

  // Setters opcionales
  public function setUsername(?string $username): void
  {
    $this->username = $username;
  }
}
