<?php

class services {
  // Aquí puedes definir las propiedades y métodos de la clase Services
  public $id;
  public $user_id;
  public $service_name;
  public $category_id;
  public $notes;
  public $created_at;

  

  /**
   * Get the value of id
   */
  public function getId()
  {
    return $this->id;
  }

  /**
   * Set the value of id
   */
  public function setId($id): self
  {
    $this->id = $id;

    return $this;
  }

  /**
   * Get the value of user_id
   */
  public function getUserId()
  {
    return $this->user_id;
  }

  /**
   * Set the value of user_id
   */
  public function setUserId($user_id): self
  {
    $this->user_id = $user_id;

    return $this;
  }

  /**
   * Get the value of service_name
   */
  public function getServiceName()
  {
    return $this->service_name;
  }

  /**
   * Set the value of service_name
   */
  public function setServiceName($service_name): self
  {
    $this->service_name = $service_name;

    return $this;
  }

  /**
   * Get the value of category_id
   */
  public function getCategoryId()
  {
    return $this->category_id;
  }

  /**
   * Set the value of category_id
   */
  public function setCategoryId($category_id): self
  {
    $this->category_id = $category_id;

    return $this;
  }

  /**
   * Get the value of notes
   */
  public function getNotes()
  {
    return $this->notes;
  }

  /**
   * Set the value of notes
   */
  public function setNotes($notes): self
  {
    $this->notes = $notes;

    return $this;
  }

  /**
   * Get the value of created_at
   */
  public function getCreatedAt()
  {
    return $this->created_at;
  }

  /**
   * Set the value of created_at
   */
  public function setCreatedAt($created_at): self
  {
    $this->created_at = $created_at;

    return $this;
  }

  public function getAllServices() {
    // Aquí iría la lógica para obtener todos los servicios desde la base de datos
    echo 'Estas en la vista de los servicios';
  }
} 