<?php

$soucet = $a + $b;
echo "Úvodní text: $a + $b = $soucet";

printr($uzivatele);

if ($uzivatele != null) {
    echo "<table>";
    foreach ($uzivatele as $uzivatel) {
        echo "<tr><td>$uzivatel[jmeno]</td><tr><td>$uzivatel[prijmeni]</td></tr>";
    }
    echo "</table>";

}