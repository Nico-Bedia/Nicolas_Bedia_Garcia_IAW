<?php
function esPrimo($num) {
    if ($num < 2) return false;
    for ($i = 2; $i <= $num / 2; $i++) {
        if ($num % $i == 0) {
            return false;
        }
    }
    return true;
}

for ($num = 3; $num <= 999; $num++) {
    if (esPrimo($num)) {
        echo $num . " ";
    }
}
