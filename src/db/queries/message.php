<?php

$GETALLMESSAGES_QUERY= "SELECT * FROM messages
                        WHERE recipient_id IN (:recipient_id, :sender_id)
                        AND sender_id IN (:sender_id, :recipient_id)
                        ORDER BY created_at ASC";

$INSERTMESSAGE_QUERY= "INSERT INTO messages(message_text, sender_id, recipient_id, created_at)
                        VALUES(:message_text, :sender_id, :recipient_id, datetime('now'))";
                                        
?>