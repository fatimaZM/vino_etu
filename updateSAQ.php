<!DOCTYPE HTML>
<html>

<head>
    <meta charset="UTF-8" />
</head>

<body>
    <?php
    require("dataconf.php");
    require("config.php");
    $page = 1;
    $nombreProduit = 24; //48 ou 96	

    $saq = new SAQ();
    for ($i = 1; $i < 2; $i++)    //permet d'importer séquentiellement plusieurs pages.
    {
        echo "<h2>page " . ($page + $i) . "</h2>";
        $nombre = $saq->getProduits($nombreProduit, $page + $i);
        echo "importation : " . $nombre . "<br>";
    }

    ?>
</body>

</html