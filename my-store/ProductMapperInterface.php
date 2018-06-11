<?php
namespace Product;

interface ProductMapperInterface
{
  public function loadAllProducts();
	public function findProductById($id);
  public function addRating($id, $rating);
	public function insert(Product $product);
	public function update(Product $product);
	public function delete($id);
}
