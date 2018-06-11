<?php
namespace Cart;

require_once dirname(__FILE__).'/ShoppingCartMapperInterface.php';

class ShoppingCartMapper implements ShoppingCartMapperInterface
{
private $db;

    public function __construct($db){
        $this->db = $db;
    }

    public function addOrder($customerid, $uid, $cart){

    $query = "INSERT INTO orders (customer_id, order_id, item_id, item_quantity, total) VALUES (?,?,?,?,?)";

      if ($stmt = $this->db->prepare($query)) {

        for ($i = 0; $i < count($cart); ++$i)
        {
            $stmt->bind_param('isiid', $customerid, $uid, $cart[$i]['item_id'], $cart[$i]['quantity'], $cart[$i]['total']);
            $stmt->execute();
            $last_inserted_id = mysqli_affected_rows($this->db);
        }

        return $last_inserted_id;
        $stmt->close();
      }
    }


	public function findOrderById($id){

	$query = "SELECT * FROM orders WHERE id=?";

        if ($stmt = $this->db->prepare($query)) {

          $stmt->bind_param("i", $id);
          $stmt->execute();
          $stmt->bind_result($id, $customer_id, $date_ordered, $item_id, $item_quantity, $total, $status);

          $result = $stmt->get_result();
          if($result->num_rows === 0) exit('No rows');
          while($row = $result->fetch_assoc()) {
            $order[] = $row;
          }
          $stmt->close();
          return $order;
        } else {
          return "Prepare failed: (" . $this->db->errno . ") " . $this->db->error;
        }
	}
	public function update(ShoppingCart $cart){
	//not implemented yet
	}
	public function delete($id){
	//not implemented yet
	}
}
