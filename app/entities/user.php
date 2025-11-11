<?php

class User
{
  private $id;
  private $username;
  private $email;
  private $password_hash;
  private $created_at;

  public function __construct(
    int $id, 
    string $username, 
    string $email, 
    ?string $password_hash = null, 
    ?string $created_at = null)
  {
    $this->id = $id;
    $this->username = $username;
    $this->email = $email;
    $this->password_hash = $password_hash;
    $this->created_at = $created_at;
  }

  // Getters
  public function getId()
  {
    return $this->id;
  }
  public function getUsername()
  {
    return $this->username;
  }
  public function getPasswordHash()
  {
    return $this->password_hash;
  }
  public function getEmail()
  {
    return $this->email;
  }
  public function getCreatedAt()
  {
    return $this->created_at;
  }

  // Setters
  public function setId($id): self
  {
    $this->id = $id;

    return $this;
  }
  public function setUsername($username): self
  {
    $this->username = $username;

    return $this;
  }
  public function setEmail($email): self
  {
    $this->email = $email;

    return $this;
  }
  public function setPasswordHash($password_hash): self
  {
    $this->password_hash = $password_hash;

    return $this;
  }
  public function setCreatedAt($created_at): self
  {
    $this->created_at = $created_at;

    return $this;
  }
}
