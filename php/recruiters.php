<?php
require 'php/db.php';
$q = "SELECT r.id, r.name, COUNT(p.id) FROM recruiters AS r INNER JOIN people AS p "
$pdo->prepare();