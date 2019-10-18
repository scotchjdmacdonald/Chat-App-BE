<?php
include_once __DIR__ . '/../../db/database.php';
include_once __DIR__ . '/../../models/Message.php';

class MessageController {

  protected $db;
  protected $message;

  public function __construct(){
    $database = new Database();
    $this->db = $database->connect();
    $this->message = new Message($this->db);    
  }

  public function createNewMessage($data){

    $this->message->message_text = $data['message_text'];
    $this->message->sender_id = $data['sender_id'];
    $this->message->recipient_id = $data['recipient_id'];    

    try {
        $id = $this->message->createMessage();
        $rdata = array("message_id" => $id);
        return $rdata;
    } catch (Exception $e){
        echo json_encode(
            array('message' => 'Sending message failed'.$e)
        );  
    }
  }

  public function getMessagesForConversation($sender_id, $recipient_id){
      
    try {
        $result = $this->message->getAllForConversation($sender_id, $recipient_id);
        $messageArray = array();

        while($row = $result->fetch(\PDO::FETCH_ASSOC)){
            extract($row);
            $messageData = array(
                    'message_id'=>$message_id,
                    'sender_id'=>$sender_id,
                    'recipient_id'=>$recipient_id,
                    'message_text'=>$message_text,
                    'created_at'=>$created_at,);
            array_push($messageArray, $messageData);  
        }
        return $messageArray;

    } catch (Exception $e){
        echo json_encode(
          array('message' => 'Getting messages failed '.$e)
        );
    }
  }
}