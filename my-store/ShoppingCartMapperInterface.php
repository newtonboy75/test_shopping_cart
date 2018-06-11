<?php
namespace Cart;

interface ShoppingCartMapperInterface
{
  public function addOrder($customerid, $uid, $cart);
	public function findOrderById($id);
	public function update(ShoppingCart $cart);
	public function delete($id);
}
