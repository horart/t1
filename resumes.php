<?php
require 'php/db.php';
require 'php/common.php';
$cond = "WHERE 1";
$params = [];
if(isset($_GET['status']) && is_array($_GET['status'])) {
    $cond .= " AND r.status IN " . arr_to_in($_GET['status']);
    $params = array_merge($params, $_GET['status']);
}
if(isset($_GET['dep']) && is_array($_GET['dep'])) {
    $cond .= " AND v.dep_id IN " . arr_to_in($_GET['dep']);
    $params = array_merge($params, $_GET['dep']);
}
if(isset($_GET['stage']) && is_array($_GET['stage'])) {
    $cond .= " AND r.stage_id IN " . arr_to_in($_GET['stage']);
    $params = array_merge($params, $_GET['stage']);
}
if(isset($_GET['recruiter']) && is_array($_GET['recruiter'])) {
    $cond .= " AND r.recruiter_id IN " . arr_to_in($_GET['recruiter']);
    $params = array_merge($params, $_GET['recruiter']);
}
if(isset($_GET['vacancy']) && is_array($_GET['vacancy'])) {
    $cond .= " AND r.vacancy_id IN " . arr_to_in($_GET['vacancy']);
    $params = array_merge($params, $_GET['vacancy']);
}
$q = <<<EOF
SELECT r.id as id, r.name as name, d.id as dep_id, d.name as dep, v.position as vacancy, v.id as vac_id, 1 as date, s.id as source_id, s.name as source,
       r.resume_link as resume, r.status as status, rs.name as recruiter, rs.id as recruiter_id, 
       (SELECT stage_types.name 
           FROM meetups
            INNER JOIN stage_types ON meetups.stage_id=stage_types.id
            WHERE candidate_id=r.id
            ORDER BY stage_types.number DESC
            LIMIT 1) as stage, IFNULL((SELECT  meetups.date 
           FROM meetups
            INNER JOIN stage_types ON meetups.stage_id=stage_types.id
            WHERE candidate_id=r.id
            ORDER BY stage_types.number ASC
            LIMIT 1), "") as date
FROM people AS r
INNER JOIN vacancies AS v ON r.vacancy_id = v.id
INNER JOIN sources AS s ON s.id = r.source_id
INNER JOIN departments AS d ON d.id = v.dep_id
INNER JOIN recruiters AS rs ON rs.id = r.recruiter_id
LEFT JOIN people AS p ON p.vacancy_id=r.id
{$cond}
GROUP BY r.id;
EOF; // LAST INTERVIEW!!!
$p = $pdo->prepare($q);
$p->execute($params);
$fa = $p->fetchAll();
$q = "SELECT id, name FROM sources";
$p = $pdo->prepare($q);
$p->execute();
$sources = $p->fetchAll();
$p = $pdo->prepare('SELECT id, name FROM recruiters');
$p->execute();
$recs = $p->fetchAll();
?>
<html>
<head>
    <link rel="stylesheet" href="/style/style.css">
    <link rel="stylesheet" href="/style/table.css">
    <title>HRPanel+ | Резюме</title>
    <meta charset="UTF-8">
</head>
<body>
    <header class="site-header">
        <h1>HRPanel+</h1>
        <nav class="site-nav">
            <a href="/">Главная</a>
            <a href="/vacancies.php">Вакансии</a>
            <a href="/resumes.php" class="current-page">Резюме</a>
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
            <h2>Резюме</h2>
            <div class="table-filter">
                <input type="search" placeholder="Поиск...">
                <div class="actions">
                    <button>Удалить</button>
                </div>
                <div class="right-filters">
                    <div class="filter dep">
                        <button>Выбрать отдел</button>
                        <div class="checkboxes hidden">
                            <label><input type="checkbox"><p>IT</p></label>
                                                </div>
                    </div>
                    <div class="filter status">
                        <button>Статус</button>
                        <div class="checkboxes hidden">
                            <label><input type="checkbox"><p>Отказано</p></label>
                            <label><input type="checkbox"><p>На рассмотрении</p></label>
                            <label><input type="checkbox"><p>В штате</p></label>
                        </div>
                    </div>
                    <dev class="filter recruiter">
                        <button>Рекрутер</button>
                        <div class="checkboxes hidden">
                            <label><input type="checkbox"><p>Анатолий Карпов</p></label>
                        </div>
                    </dev>
                    <dev class="filter resource">
                        <button>Рекрутер</button>
                        <div class="checkboxes hidden">
                            <label><input type="checkbox"><p>HH.ru</p></label>
                            <label><input type="checkbox"><p>Авито</p></label>
                        </div>
                    </dev>
                </div>
            </div>
            <div class="table">
                <div class="row">
                    <div class="thead"><input type="checkbox" class="select"></div>
                    <div class="thead">Имя</div>
                    <div class="thead">Отдел/Вакансия</div>
                    <div class="thead">Этап собеседования</div>
                    <div class="thead">Дата подачи</div>
                    <div class="thead">Источник</div>
                    <div class="thead">Ссылка на резюме</div>
                    <div class="thead">Статус</div>
                    <div class="thead">Ответственный рекрутер</div>
                    <div class="thead">+Интервью</div>
                </div>
                <?php foreach($fa as $res): ?>
                <div class="row" data-id="<?= $res['id'] ?>">
                    <div><input type="checkbox" class="select"></div>
                    <div class="editable"><span>
                        <a href="interviews.php?resume[]=<?= $res['id'] ?>"> <?= $res['name'] ?> </a></span> <input type="text" class="edit-cell"></div>
                    <div><a href="resumes.php?vacancy[]=<?= $res['vac_id'] ?>"><?= $res['dep'] . '/' . $res['vacancy'] ?></a></div>
                    <div><?= $res['stage'] ?></div>
                    <div><span><?= substr($res['date'], 0, 10) ?></span></div>
                    <div class="editable"><span><?= $res['source'] ?></span><select class="edit-cell">
                        <?php foreach($sources as $s): ?>
                        <option value="<?= $s['name'] ?>" <?php if($s['id']==$res['source_id']) echo 'selected' ?>><?= $s['name'] ?></option>
                        <?php endforeach; ?>
                    </select></div>
                    <div class="editable"><span><a href="<?= $res['resume'] ?>">Ссылка</a></span><input type="text" class="edit-cell hidden"></div>
                    <div><?= STATUSES_PEOPLE[$res['status']] ?></div>
                    <div class="editable"><span><a href="resumes.php?recruiter[]=<?= $res['recruiter_id'] ?>"><?= $res['recruiter'] ?></a></span>
                        <select class="edit-cell">
                            <?php foreach($recs as $s): ?>
                            <option value="<?= $s['name'] ?>" <?php if($s['id']==$res['recruiter_id']) echo 'selected' ?>><?= $s['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div><a href="create.php?type=meetup&resume=<?= $res['id'] ?>">+Интервью</a></div>
                </div>
            <?php endforeach; ?>
            </div>
        </div>
    </div>
    <script src="/script/table.js"></script>
</body>
</html>