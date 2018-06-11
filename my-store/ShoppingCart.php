<?php
namespace Cart;

require_once dirname(__FILE__).'/ShoppingCartInterface.php';

class ShoppingCart implements ShoppingCartInterface
{
	private $customer_id;
	private $item_id;
	private $quantity;
	private $total;

	
	public function setCustomerId($customer_id){
	    $this->customer_id = $customer_id;
	    return $this;
    }
    
    public function getCustomerId(){
        return $this->customer_id;
    }
    
    public function setItemId($item_id){
        $this->item_id = $item_id;
        return $this;
    }
    
    public function getItemId(){
        return $this->item_id;
    }
    
    public function setItemQuantity($quantity){
        $this->quantity = $quantity;
        return $this;
    }
    
    public function getItemQuantity(){
        return $this->quantity;
    }
    
    public function setTotal($total){
        $this->total = $total;
        return $this;
    }
    
    public function getTotal(){
        return $this->total;
    }    
    
    public function setStatus($status){
        $this->status = $status;
        return $this;
    }
    
    public function getStatus(){
        return $this->status;
    }
}

//$cart = (new ShoppingCart());
//$cart->setCustomerId('3');
//$d = $cart->getCustomerId();
//echo $d;

