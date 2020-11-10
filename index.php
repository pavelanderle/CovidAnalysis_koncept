<?php
    require_once("vendor/autoload.php");
    $latte = new Latte\Engine;

    $latte->setTempDirectory('temp');

    $conn = new mysqli("localhost", "root", "root", "covid");
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SET CHARACTER SET UTF8";
    $result = $conn->query($sql);

    $sql = "SELECT kod,nazev FROM kraj";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        $krajList[]=array($row["kod"],$row["nazev"]);
      }
    } else {
      echo "0 results";
    }

    if(isset($_GET["kraj"])){
        //todo $resultCovidInKraj[celkovy počet v kraji, celkový počet žen v kraji ....]
        //todo $resultImpactForeign[počet v CZ, počet v AT ....]
    }
    else{
        $resultCovidInKraj=["0","0","0","0","0","Vyberte název kraje"];
        $resultImpactForeign=[];
    }
    $conn->close();
    
    $params = [
        'krajList' => $krajList,
        'resultCovidInKraj' => $resultCovidInKraj,
        'resultImpactForeign' => $resultImpactForeign
    ];
    
    // kresli na výstup
    $latte->render('templates/covidAnalysis.latte', $params);
?>