<?php
namespace User;

require_once dirname(__FILE__).'/UserInterface.php';

class User implements UserInterface{

private $username;
private $first_name;
private $last_name;
private $address;
private $password;

public function setUsername($username)
{
  $this->username = $username;
  return $this;
}

public function getUsername(){
  return $this->username;
}

public function setFirstName($first_name)
{
  $this->first_name = $first_name;
  return $this;
}

public function getFirstName(){
  return $this->first_name;
}

public function setLastName($first_name)
{
    $this->last_name = $last_name;
    return $this;
}

public function getLastName(){
    return $this->last_name;
}

public function setPassword($password)
{
  $this->password = $password;
}

public function getPassword(){
    return $this->password;
}
public function setAddress($address)
{
  $this->address = $address;
}
public function getAddress()
{
  return $this->address;
}

}
