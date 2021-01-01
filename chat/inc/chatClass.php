<?php
  class chatClass {
    public static function getRestChatLines($id, $hash) {
      $arr = array();
      $jsonData = '{"results":[';
      $db_connection = new mysqli( mysqlServer, mysqlUser, mysqlPass, mysqlDB);
      $db_connection->query( "SET NAMES 'UTF8'" );
      $statement = $db_connection->prepare('
          SELECT  c.id, c.usrname, c.chattext, c.chattime 
          FROM    chat c
          WHERE   c.id > ? 
          AND     c.hash = ?
          AND     c.chattime >= DATE_SUB(NOW(), INTERVAL 3 MONTH)
      ');
      $statement->bind_param( 'is', $id, $hash);
      $statement->execute();
      $statement->bind_result( $id, $usrname, $chattext, $chattime);
      $line = new stdClass;
      while ($statement->fetch()) {
        $line->id = $id;
        $line->usrname = $usrname;
        $line->chattext = $chattext;
        $line->chattime = date('h:ia d-M', strtotime($chattime));
        $arr[] = json_encode($line);
      }
      $statement->close();
      $db_connection->close();
      $jsonData .= implode(",", $arr);
      $jsonData .= ']}';
      return $jsonData;
    }
    
    public static function setChatLines($usrname, $chattext, $hash) {
      $db_connection = new mysqli( mysqlServer, mysqlUser, mysqlPass, mysqlDB);
      $db_connection->query( "SET NAMES 'UTF8'" );
      $statement = $db_connection->prepare( "INSERT INTO chat(usrname, chattext, hash) VALUES(?, ? ,?)");
      $statement->bind_param( 'sss', $usrname, $chattext, $hash);
      $statement->execute();
      $statement->close();
      $db_connection->close();
    }
  }
?>