<?php

$INSERT_QUERY = "INSERT INTO users(user_id, username)
                    VALUES(null, :username)";

$GETALLUSERS_QUERY = "SELECT user_id, username FROM users";
                                        
?>