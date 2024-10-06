<?php
require 'php/db.php';
$df = $_GET['date_from'] ?? null;
$dt = $_GET['date_to'] ?? null;
$type = $_GET['type'];
switch ($type) {
    case 'funnel':
        $cond = "";
        if($df && $dt) {
            $cond = "WHERE meetups.date BETWEEN ? and ?";
        }
        $q = "SELECT name, COUNT(meetups.id) as cnt FROM meetups INNER JOIN stage_types ON stage_types.id=meetups.stage_id {$cond} GROUP BY stage_id ORDER BY number ASC";
        $p = $pdo->prepare($q);
        $p->execute($cond ? [$df, $dt]: []);
        $fa = $p->fetchAll();
        $data = [];
        $cats = [];
        foreach ($fa as $row) {
            $data[] = $row['cnt'];
            $cats[] = $row['name'];
        }
        exit(json_encode(
            [
                'data' => $data,
                'cats' => $cats
            ]
            ));
        break;
    
    default:
        # code...
        break;
}
