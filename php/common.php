<?php
function arr_to_in($arr) {
    $in  = str_repeat('?,', count($arr) - 1) . '?';
    return "($in)";
}
const STATUSES_PEOPLE = [
    0 => "В работе",
    1 => "Отклонен",
    3 => "Принят",
    4 => "Уволился"
];
const STATUSES_VACS = [
    0 => "Открыта",
    3 => "Закрыта",
    4 => "Уволился"
];
const STATUSES_INTS = [
    0 => "На рассмотрении",
    1 => "Отклонен",
    2 => "Прошел",
    3 => "Принят на работу",
    4 => "Уволился"
];