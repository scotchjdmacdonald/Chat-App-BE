<?php
include_once __DIR__ . '/../../db/database.php';
include_once __DIR__ . '/../../models/User.php';
require_once __DIR__ . '/../../services/Logger.php';

class UserController {

  protected $db;
  protected $user;

  public function __construct(){
    $database = new Database();
    $this->db = $database->connect();
    $this->user = new User($this->db);    
  }

  public function getUsers(){

    try{
      $result = $this->user->getAll();
      $userArray = array();

      while($row = $result->fetch(\PDO::FETCH_ASSOC)){
          extract($row);
          $userData = array('user_id'=>$user_id, 'username'=>$username);
          array_push($userArray, $userData);  
      }
      return $userArray;

    } catch (Exception $e){
        Logger::log('Failed to get users', Logger::ERROR);
        echo json_encode(
          array('message' => 'Getting all users failed '.$e)
        );
    }
  }
}