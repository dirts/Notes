<?php

    $conn = new PDO('mysql:host=10.6.3.77:3303;dbname=im', 'mlstmpdb', 'mlstmpdb123456');

    $sql = 'select * from `Person` where personID = :pid';
    $param = array('pid'=> 1);

    $sth = $conn->prepare($sql);
    $sth->execute($param);
    $res = $sth->fetchAll();


?>
