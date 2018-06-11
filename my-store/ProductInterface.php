<?php
namespace Product;

interface ProductInterface
{
    public function setId($id);
    public function getId();
    public function setName($name);
    public function getName();
    public function setPrice($price);
    public function getPrice();
    public function setDescription($description);
    public function getDescription();
    public function setImageId($image_id);
    public function getImageId(); 
    
}
