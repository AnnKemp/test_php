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
    // get and show name
    echo '<H1>'.($response['forms'][0]['name']).'</H1>';
    // put it in a var
    $namePoke=($response['forms'][0]['name']);
    // get and show image
    if($namePoke=="gyarados"){
      //  top: 109px;
    //margin-left:-290p
        echo '<img src="'.($response['sprites']['front_default']).'" width="130" id="bigPokemon" style="" />';
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
            echo '<li></li>';
        }else {
            echo '<li>' . $move . '</li>';
        }
    }
    echo "</ul>";
    echo "</div>";

  $id_string=($response['forms'][0]['url']);
  $id=substr($id_string,-2,-1);

  echo '<p id="id">'.$id."</p>";

   // $get_2= file_get_contents("https://pokeapi.co/api/v2/pokemon-species/".$id);
   // $get_2= file_get_contents("https://pokeapi.co/api/v2/pokemon/type/3/".$id);
    //$response_2 = json_decode($get_2, true); //because of true, it's in an array
    //var_dump($response_2);

  /*  async function getPrevo() {
    let response = await fetch("https://pokeapi.co/api/v2/pokemon-species/" + input.value.toLowerCase() + "");
    // let response = await fetch(`https://pokeapi.co/api/v2/pokemon-species/${input.value.toLowerCase()}`);
    let evolutionData = await response.json();

    console.log(evolutionData);
    if (evolutionData.evolves_from_species == null) {
        document.getElementById('prevEvolution').innerHTML = "";
        evoImage.setAttribute("src", "")
    } else {
        const preName = evolutionData.evolves_from_species.name;
        document.getElementById('prevEvolution').innerHTML = "Previous Evolution: " + preName;
        preForm(preName);
    }

    nextEvo = evolutionData.evolution_chain.url;
    getNext(nextEvo);
}

async function preForm(prevolution) {
    let response = await fetch(`https://pokeapi.co/api/v2/pokemon/${prevolution}`);
    let preData = await response.json();
    console.log(preData);
    let pokemonSprite = preData.sprites.front_default;

    evoImage.setAttribute("src", pokemonSprite);
    // co */
}else{
    echo "didn't receive any data from the form";
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