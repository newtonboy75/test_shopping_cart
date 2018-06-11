<?php
namespace User;

interface UserInterface
{
    public function setUsername($username);
    public function getUsername();
    public function setFirstName($first_name);
    public function getFirstName();
    public function setLastName($first_name);
    public function getLastName();
    public function setPassword($password);
    public function getPassword();
    public function setAddress($address);
    public function getAddress();
}
