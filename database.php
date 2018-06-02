<?php

namespace DbConnector;

class Database{
  private $host;
  private $user;
  private $pass;
  private $db;
  public $mysqli;

  public function __construct() {
    $this->db_connect();
  }

  public function db_connect():object{
    $this->host = 'localhost';
    $this->user = 'root';
    $this->pass = 'renton75';
    $this->db = 'products';
    $this->mysqli = new \MySQLi($this->host, $this->user, $this->pass, $this->db) or die(mysqli_error());
    return $this->mysqli;
  }
}
?>
