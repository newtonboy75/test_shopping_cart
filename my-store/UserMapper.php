<?php
namespace User;
require_once dirname(__FILE__).'/User.php';
require_once dirname(__FILE__).'/UserMapperInterface.php';


class UserMapper implements UserMapperInterface
{

  private $db;

  public function __construct($db){
    $this->db = $db;
  }

  public function findUserByUsername($username, $password){

    $query = "SELECT u.username AS customer_name, u.password, cb.balance, u.id FROM user u JOIN customer_balance cb ON u.id = cb.customer_id WHERE username =?";

    if ($stmt = $this->db->prepare($query)) {
      $stmt->bind_param("s", $username);
      $stmt->bind_result($customer_name, $password, $balance, $id);
      $stmt->execute();
      $result = $stmt->get_result();
      if($result->num_rows === 0) exit("0");
      $pass = $result->fetch_array(MYSQLI_NUM);

      if(password_verify($password, $pass[1]) === true){
        $user = array("customer_id"=>$pass[3], "user"=>$pass[0], "balance"=>$pass[2]);
      }else{
        $user['user'] = '0';
      }

      $stmt->close();
      return $user;
    } else {
      echo "Prepare failed: (" . $this->db->errno . ") " . $this->db->error;
    }
  }

  public function findUserEmailById($id){
    $query = "SELECT email FROM user WHERE id =?";

    if ($stmt = $this->db->prepare($query)) {
      $stmt->bind_param("i", $id);
      $stmt->bind_result($email);
      $stmt->execute();
      $result = $stmt->get_result();
      if($result->num_rows === 0) exit("0");
      $pass = $result->fetch_array(MYSQLI_NUM);

      return $pass[0].$pass[1];

      $stmt->close();
    } else {
      echo "Prepare failed: (" . $this->db->errno . ") " . $this->db->error;
    }
  }

  public function findUserById($id){
    $user = array();
    $query = "SELECT u.username AS user, CONCAT(u.first_name, ' ', u.last_name) AS full_name, u.email, u.address, cb.balance, cb.previous_balance, u.id as customer_id FROM user u JOIN customer_balance cb ON u.id = cb.customer_id WHERE u.id =?";

    if ($stmt = $this->db->prepare($query)) {
      $stmt->bind_param("i", $id);
      $stmt->execute();
      $stmt->bind_result($customer_name, $full_name, $balance, $previous_balance, $email, $address, $id);
      $result = $stmt->get_result();
      if($result->num_rows === 0) exit("0");
      $user = $result->fetch_array(MYSQLI_ASSOC);

      //new query for user orders
      $order = "SELECT o.order_id, o.date_ordered, ps.status FROM product_status ps JOIN orders o  ON o.status = ps.id WHERE o.customer_id = ? ORDER BY date_ordered DESC";
      $stmt = $this->db->prepare($order);
      $stmt->bind_param("i", $id);
      $stmt->execute();
      $result = $stmt->get_result();
      if($result->num_rows === 0) exit("0");

      while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
        $user['orders'][] = array($row['order_id'], $row['date_ordered'], $row['status']);
      }

      return $user;

      $stmt->close();
    } else {
      echo "Prepare failed: (" . $this->db->errno . ") " . $this->db->error;
    }
  }

  public function getUserBalance($id){
    $query = "SELECT balance FROM customer_balance WHERE customer_id =?";

    if ($stmt = $this->db->prepare($query)) {
      $stmt->bind_param("i", $id);
      $stmt->bind_result($balance);
      $stmt->execute();
      $result = $stmt->get_result();
      if($result->num_rows === 0) exit("0");
      $pass = $result->fetch_array(MYSQLI_NUM);
      $stmt->close();
      return $pass[0];
    } else {
      echo "Prepare failed: (" . $this->db->errno . ") " . $this->db->error;
    }
  }

  public function changeUserBalance($id, $old_balance, $current_balance){
    $query = "UPDATE customer_balance SET balance=?, previous_balance=? WHERE customer_id =?";

    if ($stmt = $this->db->prepare($query)) {
      $stmt->bind_param("ddi", $current_balance, $old_balance, $id);
      $stmt->bind_result($balance);
      $stmt->execute();
      $stmt->close();

    } else {
      echo "Prepare failed: (" . $this->db->errno . ") " . $this->db->error;
    }
  }

  public function addUser(User $user){
    //not yet implemented
  }

}
