<?php
namespace Product;

class Product implements ProductInterface
{
	private $id;
	private $name;
	private $price;
	private $description;
	private $image_id;
	private $rating;

	public function setId($id){
	    if(!is_int($id){
	        throw new InvalidArgumentException( "Invalid poroduct Id");
	    }
	    $this->id = $id;
	    return $this;
	}

	public function getId(){
	    return $this->id;
	}

	public function setName($name){
	    if($name===''){
	        throw new InvalidArgumentException("Invalid product name");
	    }
	    $this->name = $name;
	    return $this;
	}

	public function getName(){
	    return $this->name;
	}

	public function setPrice($price){
	    if(!floatval($price){
	        throw new InvalidArgumentException("Inavlid price format");
	    }
	    $this->price = $price;
	    return $this;
	}

	public function getPrice(){
	    return $this->price;
	}

	public function setDescription($description){
	    $this->description = $description;
	    return $this;
	}

	public function getDescription(){
	    return $this->description;
	}

	public function setImageId($image_id){
	    $this->image_id = $image_id;
	    return $this;
	}

	public function getImageId(){
	    return $this->image_id;
	}

	public function setRating($rating){
		$this->rating = $rating;
		return $this;
	}

	public function getRating(){
		return $this-rating;
	}

}
