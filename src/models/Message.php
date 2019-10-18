<?php
require_once __DIR__ . '/../services/Logger.php';

class Message {

    private $dbConnection;

    public $message_id;
    public $sender_id;
    public $recipient_id;
    public $created_at;
    public $message_text;
    
    public function __construct($db) {
        $this->dbConnection = $db;
    }

    public function getAllForConversation($sender_id, $recipient_id){
        include __DIR__ . '/../db/queries/message.php';

        $stmt = $this->dbConnection->prepare($GETALLMESSAGES_QUERY);
        $stmt->bindParam(':sender_id', $sender_id);
        $stmt->bindParam(':recipient_id', $recipient_id);

        if($stmt->execute()){
            Logger::log('Message retrieval successful for id:' . 
            $sender_id . 'to' . $recipient_id);
            return $stmt;
        }
        else {
            Logger::log('Error retrieving messages for id: ' . $this->sender_id . 
            ' to ' . $this->recipient_id, Logger::ERROR);
            return new Exception('Failed to create message');
        }

    }

    public function createMessage(){
        include __DIR__ . '/../db/queries/message.php';

        $stmt = $this->dbConnection->prepare($INSERTMESSAGE_QUERY);
        $stmt->bindParam(':message_text', $this->message_text);
        $stmt->bindParam(':sender_id', $this->sender_id);
        $stmt->bindParam(':recipient_id', $this->recipient_id);

        if($stmt->execute()){
            Logger::log('Message creation successful: ' . 
                $this->message_text . ' from ' . $this->sender_id);
            $id = $this->dbConnection->lastInsertId();
            return $id;
        } 
        else {
            Logger::log('Error creating message in db, from: ' . $this->sender_id . 
                ' to ' . $this->recipient_id, Logger::ERROR);
            return new Exception('Failed to create message');
        }
    }
}

?>