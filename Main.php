<?php
header('Access-Control-Allow-Origin: *');
require_once dirname(__FILE__).'/Products.php';
require_once dirname(__FILE__).'/ShoppingCart.php';
require_once dirname(__FILE__).'/Customer.php';

$obj = new class($_REQUEST){

  private $target;

  public function __construct($target){
    $this->target = $target;
    extract($this->target);
    $this->destination = $dest;
    $this->username = isset($username) ? $username : '';
    $this->password = isset($password) ? $password : '';
  }

  public function getRequest(){
    switch ($this->destination){
      case 'products':
      return (new Newton\Products())->process();
        break;
      case 'cart';
        return 'cart';
        break;
      case 'user';
        return (new Newton\Customer($this->username, $this->password))->authenticateCustomer();
        break;
      default:
      return $this->target;
    }
  }
};


$c = $obj->getRequest();
echo json_encode($c);
