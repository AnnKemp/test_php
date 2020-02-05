<?php
$pokeName=$id=0;

//https://stackify.com/display-php-errors/
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!empty($_GET)) {

    $pokeName=$_GET['pname'];
    //echo $PokeName;

  $get = file_get_contents("https://pokeapi.co/api/v2/pokemon/".$pokeName);
    $response = json_decode($get, true); //because of true, it's in an array
    //var_dump($response);
    //
    echo '<p>Pokemon: '.($response['forms'][0]['name']).'</p>';
    echo '<img src="'.($response['sprites']['front_default']).'" width="250" />';
    echo "<ul>";
    $random_keys = array_rand($response['moves'], 4);
    echo '<li>'.($response['moves'][$random_keys[0]]['move']['name']).'</li>';
    echo '<li>'.($response['moves'][$random_keys[1]]['move']['name']).'</li>';
    echo '<li>'.($response['moves'][$random_keys[2]]['move']['name']).'</li>';
    echo '<li>'.($response['moves'][$random_keys[3]]['move']['name']).'</li>';
    echo "</ul>";

  $id_string=($response['forms'][0]['url']);
  $id=substr($id_string,-2,-1);

  echo $id;

    $get_2= file_get_contents("https://pokeapi.co/api/v2/evolution-chain/".$id);
   // $get_2= file_get_contents("https://pokeapi.co/api/v2/pokemon/type/3/".$id);
    $response_2 = json_decode($get_2, true); //because of true, it's in an array
    var_dump($response_2);
}else{
    echo "geen data van de form ontvangen!";
}
?>
<html>
<head>
    <style>

    </style>
</head>
<body>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">

    Add your Pokemon name here: <input type="text" name="pname">
    <input type="submit" value="search">
</form>
</body>
</html>