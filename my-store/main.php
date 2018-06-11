<?php
namespace Newton;

header('Access-Control-Allow-Origin: *');
require_once dirname(__FILE__).'/ProductMapper.php';
require_once dirname(__FILE__).'/ShoppingCartMapper.php';
require_once dirname(__FILE__).'/ShoppingCart.php';
require_once dirname(__FILE__).'/UserMapper.php';
require_once dirname(__FILE__).'/ActionInterface.php';
require_once dirname(__FILE__).'/Database.php';

$request = new class($_REQUEST) implements Action{

  private $target;
  private $db;

  public function __construct($target){
    $this->target = $target;
    extract($this->target);
    $this->destination = $dest;
    $this->username = isset($username) ? $username : '';
    $this->password = isset($password) ? $password : '';
    $this->product_id = isset($product_id) ? $product_id: '';
    $this->rating = isset($rating) ? $rating: '';
    $this->cart_items = isset($cart_items) ? $cart_items: '';
    $this->user_info_id = isset($user_info_id) ? $user_info_id: '';

    $this->db = (new \DB\Database())->db_connect();
  }

  public function getRequest(){
    switch ($this->destination){
      case 'products':
      return (new \Product\ProductMapper($this->db))->loadAllProducts();
        break;
      case 'cart':
        $request_string = json_decode($this->cart_items, true);
        $namepass = (new \User\UserMapper($this->db))->findUserEmailById($request_string['customer_id']);
        $uniqid = uniqid(substr(md5($namepass), 0, 5));
        $old_balance = (new \User\UserMapper($this->db))->getUserBalance($request_string['customer_id']);
        $new_current_balance = (new \User\UserMapper($this->db))->changeUserBalance($request_string['customer_id'], $old_balance, $request_string['new_balance']);
        return (new \Cart\ShoppingCartMapper($this->db))->addOrder($request_string['customer_id'], $uniqid , $request_string['items']);
        break;
      case 'user':
        return (new \User\UserMapper($this->db))->findUserByUsername($this->username, $this->password);
        break;
      case 'rating':
        return (new \Product\ProductMapper($this->db))->addRating($this->product_id, $this->rating);
        break;
      case 'info':
        return (new \User\UserMapper($this->db))->findUserById($this->user_info_id);
        break;
      default:
        return $this->target;
    }
  }

  public function authenticateUser(){

  }

};


$result = $request->getRequest();
echo json_encode($result);
