<?php
require 'php/db.php';
$type = $_GET['type'] ?? null;
if(!isset($type) && !$type) $type = 'candidate';
switch ($type) {
    case 'candidate':
        $name = $_POST['name'] ?? null;
        $vacancy = $_POST['vacancy'] ?? null;
        $source = $_POST['source'] ?? null;
        $resume = $_POST['resume'] ?? null;
        $rec = $_POST['rec'] ?? null;
        if(!$name || !$vacancy || !$source || !$resume || !$rec) {
            break;
        }
        $q = 'INSERT INTO people (name, source_id, resume_link, vacancy_id, recruiter_id) VALUES (?, ?, ?, ?, ?)';
        $p = $pdo->prepare($q);
        $p->execute([$name, $source, $resume, $vacancy, $rec]);
        $nid = $pdo->lastInsertId();
        $q = 'INSERT INTO meetups (vacancy_id, stage_id, status, candidate_id) VALUES (?, ?, ?, ?)';
        $p = $pdo->prepare($q);
        $p->execute([$vacancy, 1, 0, $nid]);
        header('Location: /');
        exit();
        break;
    case 'meetup':
        $resume = $_POST['resume'] ?? null;
        $stage = $_POST['stage'] ?? null;
        $date = $_POST['date'] ?? null;
        $mark = $_POST['mark'] ?? null;
        $status = $_POST['status'] ?? null;
        if(!$resume || !$stage || !$date || !$mark) {
            break;
        }
        $q = 'INSERT INTO meetups (vacancy_id, stage_id, status, candidate_id, date, mark) VALUES ((SELECT vacancy_id FROM people WHERE id = ?), ?, ?, ?, ?, ?)';
        $p = $pdo->prepare($q);
        $p->execute([$resume, $stage, $status, $resume, $date, $mark]);
        $q = 'UPDATE people SET stage_id=? WHERE id=?';
        $p = $pdo->prepare($q);
        $p->execute([$stage, $resume]);
        if($status == 3 || $status == 4) {
            $q = 'UPDATE vacancies INNER JOIN people ON people.vacancy_id = vacancies.id SET vacancies.status=?, vacancies.closed_at=? WHERE people.vacancy_id=?';
            $p = $pdo->prepare($q);
            $p->execute([$status, $date, $resume]);
        }
        if($status == 3 || $status == 4 || $status == 1) {
            $q = 'UPDATE people SET status=? WHERE id=?';
            $p = $pdo->prepare($q);
            $p->execute([$status, $resume]);
        }
        header('Location: /');
        exit();
        break;
    case 'vacancy':
        $dep = $_POST['dep'] ?? null;
        $priority = $_POST['priority'] ?? null;
        $date = $_POST['date'] ?? null;
        $position = $_POST['position'] ?? null;
        if(!$dep || !$priority || !$date || !$position) {
            break;
        }
        $q = 'INSERT INTO vacancies (position, dep_id, posted_at, priority) VALUES (?, ?, ?, ?)';
        $p = $pdo->prepare($q);
        $p->execute([$position, $dep, $date, $priority]);
        header('Location: /');
        exit();
        break;

    default:
        # code...
        break;
}
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
                <section class="quick-create-section">
                    <?php require 'createform.php' ?>
                </section>
            </div>
        </div>
    </div>
    <script src="/script/index.js"></script>
    <script>document.querySelectorAll('input[type=date]').forEach(e=>e.valueAsDate=new Date())</script>
</body>
</html>