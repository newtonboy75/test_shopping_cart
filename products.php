<?php
require_once dirname(__FILE__).'/database.php';

class Products
{

    public function connectToDb()
    {
        return (new DbConnector\Database())->db_connect();
    }

    public function getAllItems(){
        $conn = $this->connectToDb();
        $all_prods = array();
        $query = "SELECT p.id, p.name, p.unit_price, pi.name as product_image, (SELECT rating FROM product_rating WHERE id=p.id GROUP BY rating) as rating FROM product p JOIN product_image pi ON p.image = pi.id";

            if ($stmt = $conn->prepare($query)) {
                $stmt->execute();
                $stmt->bind_result($name, $unit_price, $image, $product_image, $rating);

                $result = $stmt->get_result();
                if($result->num_rows === 0) exit('No rows');
                while($row = $result->fetch_assoc()) {
                  //$all_prods[] = $row;
                  $row['quantity'] = 0;
                  array_push($all_prods, $row);
                }
                $stmt->close();
                return $items['items'] = $all_prods;
            } else {
                echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
            }
    }

}

//header("Content-type: application/json");
echo json_encode((new Products)->getAllItems());
