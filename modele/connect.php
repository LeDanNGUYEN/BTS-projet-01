<?php

function connectBdd(){
    try{
        $username = "root";
        $password = "";
        $dbh = new PDO('mysql:host=localhost;dbname=conservatoire_v0',$username,$password);
        return $dbh;
    }
    catch(PDOException $e)
    {
        print "Error!: ".$e->getMessage()."<br/>";
        die();
    }
}