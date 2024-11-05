<?php
$arr = [
    [1,"pankaj","sde","$1000"],
    [2,"ankaj","sde","$2000"],
    [3,"panaj","sde","$3000"],
    [4,"nkaj","sde","$4000"],
    [5,"pank","sde","$5000"],
];
for($i = 0 ; $i < count($arr); $i++) {
    for($j=0; $j < count($arr[$i]); $j++){
        echo $arr[$i][$j] . " " ;
    }
    echo "<br>";
};
?>
