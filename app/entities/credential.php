<?php

class Credential
{
  private $id;
  private $serviceId;
  private $username;
  private $passwordEncrypted;

  public function __construct($serviceId, $username, $passwordEncrypted = null)
  {
    $this->serviceId = $serviceId;
    $this->username = $username;
    $this->passwordEncrypted = $passwordEncrypted;
  }

  public function getId()
  {
    return $this->id;
  }
  public function getServiceId()
  {
    return $this->serviceId;
  }
  public function getUsername()
  {
    return $this->username;
  }
  public function getPasswordEncrypted()
  {
    return $this->passwordEncrypted;
  }

  public function setPassword($password)
  {

    $this->passwordEncrypted = encryptPassword($password);
  }
}
