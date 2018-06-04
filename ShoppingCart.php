<?php
namespace Newton;

require_once dirname(__FILE__).'/Action.php';
require_once dirname(__FILE__).'/Database.php';


class ShoppingCart implements Action
{

  public function connectToDb()
  {
    return (new DbConnector\Database())->db_connect();
  }

  public function __construct($product_id, $rating){
    $this->product_id = $product_id;
    $this->rating = $rating;
  }

  private function Order(){
    $conn = $this->connectToDb();
    $query = "SELECT id, name, unit_price FROM product";

    if ($stmt = $conn->prepare($query)) {
      $stmt->execute();
      $stmt->bind_result($name, $unit_price);

      $result = $stmt->get_result();
      if($result->num_rows === 0) exit('No rows');
      while($row = $result->fetch_assoc()) {
        $all_prods[] = $row;
      }
      $stmt->close();
      return $all_prods;
    } else {
      return "Prepare failed: (" . $conn->errno . ") " . $conn->error;
    }
  }

  private function addRating(){
    $conn = $this->connectToDb();
    $query = "INSERT INTO product_rating (product_id, rating) VALUES (?, ?)";
    if ($stmt = $conn->prepare($query)) {
      $stmt->bind_param("ss", $this->product_id, $this->rating);
      $stmt->execute();
      return mysqli_affected_rows($conn);
    }
  }

  public function process(){
    
  }

}

//print_r((new Products)->getAllItems());
//(new ShoppingCart('2', '2'))->addRating();
