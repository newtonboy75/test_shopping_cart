<?php
namespace DB;

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
    $this->host = 'https://mysql.cba.pl';
    $this->user = 'newtonboy32775';
    $this->pass = 'Renton32775';
    $this->db = 'newtonboy';
    $this->mysqli = new \MySQLi($this->host, $this->user, $this->pass, $this->db) or die(mysqli_error("an error occured when connecting to db"));
    return $this->mysqli;
  }
}

?>
