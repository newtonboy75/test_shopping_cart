<?php
namespace Newton;

require_once dirname(__FILE__).'/Database.php';

class Customer
{

  private $username;
  private $password;

  public function connectToDb()
  {
    return (new Database())->db_connect();
  }

  public function __construct($username, $password){
    $this->username = $username;
    $this->password = $password;
  }

  public function checkPassword($pass){
    $is_valid_pass = (password_verify($this->password, $pass) ? true : false);
    return $is_valid_pass;
  }

  public function authenticateCustomer(){
    $conn = $this->connectToDb();
    $query = "SELECT u.username, u.password, cb.balance FROM user u JOIN customer_balance cb ON u.id = cb. customer_id WHERE username = ?";

    if ($stmt = $conn->prepare($query)) {
      $stmt->execute();
      $stmt->bind_param("s", $this->username);
      $stmt->bind_result($username, $password, $balance);
      $stmt->execute();
      $result = $stmt->get_result();
      if($result->num_rows === 0) exit('0');
      $pass = $result->fetch_array(MYSQLI_NUM);

      if(!$this->checkPassword($pass[1])){
        $user['user'] = '0';
      }else{
              $user = array('user'=>$pass[0], 'balance'=>$pass[2]);
      }

      $stmt->close();

      return $user;


    } else {
      echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
    }
  }

  public function getCustomerBalance(){
  }

}

//print_r((new Customer('newton', 'admin'))->authenticateCustomer());
