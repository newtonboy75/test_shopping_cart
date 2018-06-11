<?php
namespace User;

interface UserMapperInterface
{
	public function findUserByUsername($username, $password);
	public function findUserById($id);
	public function findUserEmailById($id);
	public function changeUserBalance($id, $old_balance, $current_balance);
	public function getUserBalance($id);
	public function addUser(User $user);
  //more methods here in the future
}
