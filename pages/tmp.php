<?php

for($i=0; $i<=255; $i++)
{
    $tmp=mb_convert_encoding('&#' . intval($i) . ';', 'ASCII', 'HTML-ENTITIES');
    if (preg_match('@[^\w]@', $tmp))
    echo $i."\t\t".$tmp."<br>";

}