
<?php
require 'php/db.php';
$q = 'SELECT v.id as id, v.position as pos, d.name as dep FROM vacancies as v INNER JOIN departments as d ON d.id = v.dep_id WHERE v.status = 0';
$p = $pdo->prepare($q);
$p->execute();
$vacs = $p->fetchAll();
$q = 'SELECT id, name FROM sources';
$p = $pdo->prepare($q);
$p->execute();
$sources = $p->fetchAll();
$q = 'SELECT id, name FROM people WHERE status=0';
$p = $pdo->prepare($q);
$p->execute();
$cands = $p->fetchAll();
$q = 'SELECT id, name, number FROM stage_types ORDER BY number ASC';
$p = $pdo->prepare($q);
$p->execute();
$stages = $p->fetchAll();
$q = 'SELECT id, name FROM departments';
$p = $pdo->prepare($q);
$p->execute();
$deps = $p->fetchAll();
$q = 'SELECT id, name FROM recruiters';
$p = $pdo->prepare($q);
$p->execute();
$recs = $p->fetchAll();

$q = 'SELECT (SUM(CASE WHEN status=3 THEN 1 ELSE 0 END)/COUNT(*))*100 FROM meetups WHERE stage_id=999';
$p = $pdo->prepare($q);
$p->execute();
$accept_rate = $p->fetchAll()[0][0];
$q = <<<EOF
SELECT (SELECT COUNT(*) FROM meetups WHERE stage_id=999)/(SELECT COUNT(*) FROM meetups WHERE stage_id=1)*100
EOF;
$p = $pdo->prepare($q);
$p->execute();
$offer_to_interview = $p->fetchAll()[0][0];
?>

<html>
<head>
    <link rel="stylesheet" href="/style/style.css">
    <link rel="stylesheet" href="/style/dashboard.css">
    <meta charset="UTF-8"> 
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <title>HRPanel+</title>
</head>
<body>
    <header class="site-header">
        <h1>HRPanel+</h1>
        <nav class="site-nav">
            <a href="/" class="current-page">Главная</a>
            <a href="/vacancies.php">Вакансии</a>
            <a href="/resumes.php">Резюме</a>
            <a href="/recruiters.php">Рекрутеры</a>
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
            <div class="app-grid">
                <section class="section overview-section">
                    <h2>Статистика</h2>
                    <div class="tiles">
                        <article class="tile">
                                <h3>23дн.</h3>
                                <p>время закрытия</p>
                        </article>
                        <article class="tile">
                            <h3>15дн.</h3>
                            <p>время найма</p>
                        </article>
                        <article class="tile">
                            <h3><?= round($accept_rate) ?>%</h3>
                            <p>офферов принимают</p>
                        </article>
                        <article class="tile">
                            <h3><?= round($offer_to_interview) ?>%</h3>
                            <p>оффер/интервью</p>
                        </article>
                    </div>
                </section>
                <section class="section pending-section">
                    <h2>Текущие задачи</h2>
                    <ul class="pending-list">
                        <li>задача 1: Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloribus laborum neque, nobis voluptate voluptatibus labore saepe deserunt totam recusandae quas.</li>
                        <li>задача 2</li>
                        <li>задача 3</li>
                    </ul>
                </section>
                <section class="quick-create-section">
                    <?php require 'createform.php' ?>
                </section>
                <section class="infogr-section">
                    <h2>Статистика</h2>
                    <div class="info-grid">
                        <div id="funnel"></div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <script src="/script/index.js"></script>
    <script>document.querySelectorAll('input[type=date]').forEach(e=>e.valueAsDate=new Date())</script>
</body>
</html>