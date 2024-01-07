<?php
    try{
        $db = new PDO("mysql:host=localhost; dbname=hastane_otomasyonu; charest=utf8",'root','2003ocak9A');
        
    }
    catch(Exception $e){
        echo $e->getMessage();
    }
?>