<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Models' . DIRECTORY_SEPARATOR . 'Database.php';

class UserModel
{
  private $conn;

  function __construct()
  {
    $database = new Database();
    $this->conn = $database->getConnection();
  }

  public function findAll()
  {
    $query = "SELECT * FROM users";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function find($id)
  {
    $query = "SELECT * FROM users WHERE id = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function findBy(array $params)
  {
    $query = "SELECT * FROM users WHERE " . implode(' AND ', array_map(function ($key) {
      return "$key = :$key";
    }, array_keys($params)));
    $stmt = $this->conn->prepare($query);
    foreach ($params as $key => $value) {
      $stmt->bindValue(":$key", $value);
    }
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function add($nom, $password, $email, $date_inscription)
  {
    $query = "INSERT INTO users (nom, password, email, date_inscription)
    VALUES (:nom, :password, :email, :date_inscription)";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':date_inscription', $date_inscription);
    $stmt->execute();
    return $this->conn->lastInsertId();
  }

  public function update($id, $nom, $password, $email)
  {
    $query = "UPDATE users 
              SET nom = :nom, password = :password, email = :email
              WHERE id = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':email', $email);

    return $stmt->execute();
  }

  public function delete($id)
  {
    $query = "DELETE FROM users WHERE id = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->rowCount() > 0;
  }
}
