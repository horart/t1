<?php
require 'php/db.php';
$q = "SELECT r.id as id, r.name as name, SUM(CASE WHEN p.status=0 THEN 1 ELSE 0 END) AS cnt FROM recruiters AS r LEFT JOIN people AS p ON p.recruiter_id=r.id GROUP BY r.id";
$p = $pdo->prepare($q);
$p->execute([]);
$fa = $p->fetchAll();
?>

<html>
<head>
    <link rel="stylesheet" href="/style/style.css">
    <link rel="stylesheet" href="/style/table.css">
    <meta charset="UTF-8"> 
    <title>HRPanel+ | Рекрутеры</title>
</head>
<body>
    <header class="site-header">
        <h1>HRPanel+</h1>
        <nav class="site-nav">
            <a href="/">Главная</a>
            <a href="/vacancies.php">Вакансии</a>
            <a href="/resumes.php">Резюме</a>
            <a href="/recruiters.php" class="current-page">Рекрутеры</a>
            <a href="/interviews.php">Интервью</a>
            <a href="/analyzer.php">Анализатор</a>
        </nav>
        <div class="header-icons">
            <div class="circle-icon">
                <img src="/icons/signout.svg" alt="выйти">
            </div>
            <div class="circle-icon">
                <img src="/icons/profile.svg" alt="выйти">
            </div>
        </div>
    </header>
    <hr>
    <div class="app">   
        <div class="app-body">
            <h2>Имя</h2>
            <div class="table-filter">
                <input type="search" placeholder="Поиск...">
                <div class="actions">
                    <button>Удалить</button>
                </div>
            </div>
            <div class="table table-recs">
                <div class="row">
                    <div class="thead"><input type="checkbox" class="select"></div>
                    <div class="thead">Имя</div>
                    <div class="thead">Человек в работе</div>
                    <div class="thead">+Задание</div>
                </div>

                <?php foreach($fa as $row): ?>
                <div class="row" data-id="<?= $row['id'] ?>">
                    <div><input type="checkbox" class="select"></div>
                    <div><?= $row['name'] ?></div>
                    <div><a href="resumes.php?status[]=0&recruiter[]=<?= $row['id'] ?>"><?= $row['cnt'] ?></a></div>
                    <div><a href="create.php?type=task&id=<?= $row['id'] ?>">+Задание</a></div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <script src="/script/table.js"></script>
</body>
</html>