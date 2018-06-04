<?php
namespace Newton;

require_once dirname(__FILE__).'/Action.php';
require_once dirname(__FILE__).'/Database.php';

class Products implements Action
{

    public function connectToDb()
    {
        return (new Database())->db_connect();
    }

    public function process(){
        $conn = $this->connectToDb();
        $all_prods = array();
        $query = "SELECT p.id, p.name, p.unit_price, pi.name AS product_image,
        (SELECT SUM(rt.rating)*1 FROM product_rating rt WHERE rt.product_id = p.id AND rt.rating = 1) AS rating1,
        (SELECT SUM(rt.rating)*2 FROM product_rating rt WHERE rt.product_id = p.id AND rt.rating = 2) AS rating2,
        (SELECT SUM(rt.rating)*3 FROM product_rating rt WHERE rt.product_id = p.id AND rt.rating = 3) AS rating3,
        (SELECT SUM(rt.rating)*4 FROM product_rating rt WHERE rt.product_id = p.id AND rt.rating = 4) AS rating4,
        (SELECT SUM(rt.rating)*5 FROM product_rating rt WHERE rt.product_id = p.id AND rt.rating = 5) AS rating5,

        (SELECT SUM(rt.rating) FROM product_rating rt WHERE rt.product_id = p.id AND rt.rating = 1) AS sum_rating1,
        (SELECT SUM(rt.rating) FROM product_rating rt WHERE rt.product_id = p.id AND rt.rating = 2) AS sum_rating2,
        (SELECT SUM(rt.rating) FROM product_rating rt WHERE rt.product_id = p.id AND rt.rating = 3) AS sum_rating3,
        (SELECT SUM(rt.rating) FROM product_rating rt WHERE rt.product_id = p.id AND rt.rating = 4) AS sum_rating4,
        (SELECT SUM(rt.rating) FROM product_rating rt WHERE rt.product_id = p.id AND rt.rating = 5) AS sum_rating5

        FROM product p JOIN product_image pi ON p.image = pi.id";

            if ($stmt = $conn->prepare($query)) {
                $stmt->execute();
                $stmt->bind_result($name, $unit_price, $image, $product_image, $rating1, $rating2, $rating3, $rating4, $rating5,
                $sum_rating1, $sum_rating2, $sum_rating3, $sum_rating4, $sum_rating5);

                $result = $stmt->get_result();
                if($result->num_rows === 0) exit('No rows');
                while($row = $result->fetch_assoc()) {
                  //$all_prods[] = $row;
                  $row['rating'] = ceil(($row['rating1'] + $row['rating2'] + $row['rating3'] + $row['rating4'] + $row['rating5']) /
                  ($row['sum_rating1'] + $row['sum_rating2'] + $row['sum_rating3'] + $row['sum_rating4'] + $row['sum_rating5']));
                  array_push($all_prods, $row);
                }
                $stmt->close();
                return $items['items'] = $all_prods;

            } else {
                return "Prepare failed: (" . $conn->errno . ") " . $conn->error;
            }
    }

}

//header("Content-type: application/json");
//echo json_encode((new Products)->process());
//print_r((new Products)->process());
//echo PHP_EOL;
