<?php
require 'php/db.php';
require 'php/common.php';
$cond = "WHERE 1";
$params = [];
if(isset($_GET['status']) && is_array($_GET['status'])) {
    $cond .= " AND m.status IN " . arr_to_in($_GET['status']);
    $params = array_merge($params, $_GET['status']);
}
if(isset($_GET['dep']) && is_array($_GET['dep'])) {
    $cond .= " AND v.dep_id IN " . arr_to_in($_GET['dep']);
    $params = array_merge($params, $_GET['dep']);
}
if(isset($_GET['vacancy']) && is_array($_GET['vacancy'])) {
    $cond .= " AND m.vacancy_id IN " . arr_to_in($_GET['vacancy']);
    $params = array_merge($params, $_GET['vacancy']);
}
if(isset($_GET['recruiter']) && is_array($_GET['recruiter'])) {
    $cond .= " AND p.recruiter_id IN " . arr_to_in($_GET['recruiter']);
    $params = array_merge($params, $_GET['recruiter']);
}
if(isset($_GET['stage']) && is_array($_GET['stage'])) {
    $cond .= " AND m.stage_id IN " . arr_to_in($_GET['stage']);
    $params = array_merge($params, $_GET['stage']);
}
if(isset($_GET['status']) && is_array($_GET['stage'])) {
    $cond .= " AND m.status IN " . arr_to_in($_GET['stage']);
    $params = array_merge($params, $_GET['stage']);
}
if(isset($_GET['resume']) && is_array($_GET['resume'])) {
    $cond .= " AND m.candidate_id IN " . arr_to_in($_GET['resume']);
    $params = array_merge($params, $_GET['resume']);
}
$q = <<<EOF
SELECT m.id, p.name as name, p.id as res_id, d.id as dep_id, d.name as dep, 
       v.position as vacancy, v.id as vac_id, v.priority as priority, st.name as stage, st.id as stage_id, 
       m.date as date, p.resume_link as resume, m.mark as mark, r.id as rec_id, r.name as rec, m.status as status
FROM meetups AS m
INNER JOIN people AS p ON m.candidate_id = p.id
INNER JOIN vacancies AS v ON m.vacancy_id = v.id
INNER JOIN recruiters AS r ON p.recruiter_id = r.id
INNER JOIN stage_types AS st ON m.stage_id = st.id
INNER JOIN departments AS d ON v.dep_id = d.id
{$cond}
GROUP BY m.id
EOF; // LAST INTERVIEW!!!
$p = $pdo->prepare($q);
$p->execute($params);
$fa = $p->fetchAll();
$q = "SELECT id, name FROM sources";
$p = $pdo->prepare($q);
$p->execute();
$sources = $p->fetchAll();
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
            <a href="/resumes.php">Резюме</a>
            <a href="/recruiters.php">Рекрутеры</a>
            <a href="/interviews.php" class="current-page">Интервью</a>
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
            <div class="table table-ins">
                <div class="row">
                    <div class="thead"><input type="checkbox" class="select"></div>
                    <div class="thead">Имя</div>
                    <div class="thead">Отдел/Вакансия</div>
                    <div class="thead">Приоритет</div>
                    <div class="thead">Этап собеседования</div>
                    <div class="thead">Дата <br>(с подачи)</div>
                    <div class="thead">Ссылка на резюме</div>
                    <div class="thead">Оценка</div>
                    <div class="thead">Рекрутер</div>
                    <div class="thead">Статус</div>
                    <div class="thead">+Интервью</div>
                </div>
                    <!-- принят отклонен или прошел -->
                <?php foreach($fa as $int): ?>
                <div class="row" data-id="<?= $int['id'] ?>">
                    <div><input type="checkbox" class="select"></div>
                    <div><a href="interviews.php?resume[]=<?= $int['res_id'] ?>"><?= $int['name'] ?></a></div>
                    <div><a href="interviews.php?vacancy[]=<?= $int['vac_id'] ?>"><?= $int['dep'] . '/' . $int['vacancy'] ?></a></div>
                    <div><?= $int['priority'] ?></div>
                    <div><a href="interviews.php?stage[]=<?= $int['stage_id'] ?>"><?= $int['stage'] ?></a></div>
                    <div><?= substr($int['date'], 0, 10) ?></div>
                    <div><a href="<?= $int['resume'] ?>">ссылка</a></div>
                    <div class="editable"><span><?= $int['mark'] ?></span><input type="number" class="edit-cell"></div>
                    <div><a href="resumes.php?recruiter[]=<?= $int['rec_id'] ?>"><?= $int['rec'] ?></a></div>
                    <div class="editable"><span><?= STATUSES_INTS[$int['status']] ?>
                    <select class="edit-cell">
                        <option value="0" <?php if($int['status'] == 0) echo 'selected'?>>На рассмотрении</option>
                        <option value="1" <?php if($int['status'] == 1) echo 'selected'?>>Прошёл</option>
                        <option value="2" <?php if($int['status'] == 2) echo 'selected'?>>Принят на работу</option>
                    </select></span></div>
                    <div><a href="create.php?type=meetup&vacancy=<?= $int['vac_id'] ?>">+Интервью</a></div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <script src="/script/table.js"></script>
</body>
</html>