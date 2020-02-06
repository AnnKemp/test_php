<?php
$pokeName=$id=0;

//https://stackify.com/display-php-errors/
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!empty($_GET)) {

    $pokeName=$_GET['pname'];

  $get = file_get_contents("https://pokeapi.co/api/v2/pokemon/".$pokeName);
    $response = json_decode($get, true); //because of true, it's in an array
   //var_dump($response);
    // get and show the name as a kind of title
    echo '<H1>'.($response['forms'][0]['name']).'</H1>';
    // put it in a var
    $namePoke=($response['forms'][0]['name']);
    // get and show image
    if(($namePoke=="gyarados")||($namePoke=="venusaur")||($namePoke=="charmeleon")){ // fixing an esthetic problem some pokemons are too big
        echo '<img src="'.($response['sprites']['front_default']).'" width="130" id="bigPokemon" style="top: 150px; margin-left:-240px" />';
    }else{
        echo '<img src="'.($response['sprites']['front_default']).'" width="230" id="bigPokemon" />';
    }
    // make the div
    echo '<div id="moves">';
    // make the list
    echo "<ul>";

    $random_keys = array_rand($response['moves'], 4);

    for ($x=0;$x<4;$x++){
        $move=($response['moves'][$random_keys[$x]]['move']['name']);
        if (empty($move)) {
            $move=""; // dit was om die foutmeldingen te doen stoppen maar dat doen ze niet maar het werkt dus ik zet ze gewoon af.
            echo '<li></li>';
        }else {
            echo '<li>' . $move . '</li>';
        }
    }
    echo "</ul>";
    echo "</div>";
    // get the string with the id at the end
  $id_string=($response['forms'][0]['url']);
  // cut the id off with substring
  $id=substr($id_string,-2,-1);

  echo '<p id="id">'.$id."</p>";

  // search into the spieces by poke-name
$get_next= file_get_contents("https://pokeapi.co/api/v2/pokemon-species/".$namePoke);
$response_next = json_decode($get_next, true);    // because of true, it's in an array
//var_dump($response_next);

   $checkIf_data=$response_next['evolves_from_species']['name'];

   if(empty($checkIf_data)) {
        echo '<p id="smallOne_name"></p>';
    } else {
       // get in this get-date name of the small one
       $evolves_name=$response_next['evolves_from_species']['name'];
       echo '<p id="smallOne_name">'.$evolves_name.'</p>';

       // do again a get with this name to get the sprite/picture of the small one
       $get_smallOne= file_get_contents("https://pokeapi.co/api/v2/pokemon/".$evolves_name);
       $response_smallOne = json_decode($get_smallOne, true);    // because of true, it's in an array
//var_dump($response_smallOne);

       // put the link into an img src to show it
       echo '<img src="'.($response_smallOne['sprites']['front_default']).'" width="230" id="smallPokemon" />';
    }
}else{
    echo "<p id='noData_error'>Please fill in a name and click on the round blue 'search' button</p>";
}
?>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">

    <title>Another poke-ding</title>
    <link href="assets/style.css" rel="stylesheet">
</head>
<body>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">

    <p id="instruction">Add the Pokemon name here >></p> <br /><input type="text" name="pname" id="inputField">
    <input type="submit" value="search" id="send">
</form>
</body>
</html>