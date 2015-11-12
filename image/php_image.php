<?php 
/**
 * 返回随机颜色
 * @return [type] [description]
 */
function colorRand(){
    //$color = dechex(rand(3355443,13421772));
    $color = dechex(rand(1048576,16777215));
    $color = "#".$color;
    return $color;
}


