<?php

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "http://" . $_GET["region"] . ".battle.net/wow/en/character/" . $_GET["realm"] . "/" . $_GET["name"] . "/advanced"); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

preg_match_all("/\<div class=\"slot-contents\"\>\s*<a href=\"(?:javascript:;|\/wow\/en\/item\/(\d+))\"/",curl_exec($ch),$out, PREG_PATTERN_ORDER);

$arm = array();
$arm['head'] = $out[1][0];
$arm['neck'] = $out[1][1];
$arm['shoulders'] = $out[1][2];
$arm['back'] = $out[1][3];
$arm['chest'] = $out[1][4];
$arm['shirt'] = $out[1][5];
$arm['tabard'] = $out[1][6];
$arm['wrist'] = $out[1][7];
$arm['hands'] = $out[1][8];
$arm['waist'] = $out[1][9];
$arm['legs'] = $out[1][10];
$arm['feet'] = $out[1][11];
$arm['ring1'] = $out[1][12];
$arm['ring2'] = $out[1][13];
$arm['trinket1'] = $out[1][14];
$arm['trinket2'] = $out[1][15];
$arm['mainhand'] = $out[1][16];
$arm['offhand'] = $out[1][17];
$arm['ranged'] = $out[1][18];
    
echo json_encode($arm);
?>