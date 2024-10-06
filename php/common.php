<?php
function arr_to_in($arr) {
    $in  = str_repeat('?,', count($arr) - 1) . '?';
    return "($in)";
}