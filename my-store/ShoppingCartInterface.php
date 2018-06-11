<?php
namespace Cart;

interface ShoppingCartInterface
{
    public function setCustomerId($customer_id);
    public function getCustomerId();
    public function setItemId($item_id);
    public function getItemId();
    public function setItemQuantity($quantity);
    public function getItemQuantity();
    public function setTotal($total);
    public function getTotal();
    public function setStatus($status);
    public function getStatus();    
}
