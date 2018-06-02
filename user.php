<?php
require_once dirname(__FILE__).'/database.php';

class User
{

    public function connectToDb()
    {
        return (new DbConnector\Database())->db_connect();
    }

    public function checkCustomer(){
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
                echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
            }
    }

}
