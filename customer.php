<?php
require_once dirname(__FILE__).'/database.php';

class Customer
{

    private $username;
    private $password;

    public function connectToDb()
    {
        return (new DbConnector\Database())->db_connect();
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
        $query = "SELECT username, password FROM user WHERE username = ?";

            if ($stmt = $conn->prepare($query)) {
                $stmt->execute();
                $stmt->bind_param("s", $this->username);
                $stmt->bind_result($username, $password);
                $stmt->execute();
                $result = $stmt->get_result();
                if($result->num_rows === 0) exit('No rows');
                while($row = $result->fetch_assoc()) {
                      if(!$this->checkPassword($row['password'])){
                        trigger_error('Invalid query: ' . $conn->error);
                        exit;
                      }
                        $user[] = $row;
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

print_r((new Customer('newton', 'admin'))->authenticateCustomer());
