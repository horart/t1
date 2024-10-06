<?php
require 'php/db.php';
require 'php/common.php';
$cond = "WHERE p.status=0";
$params = [];
if(isset($_GET['status']) && is_array($_GET['status'])) {
    $cond .= " AND r.status IN " . arr_to_in($_GET['status']);
    $params = array_merge($params, $_GET['status']);
}
if(isset($_GET['dep']) && is_array($_GET['dep'])) {
    $cond .= " AND r.dep_id IN " . arr_to_in($_GET['dep']);
    $params = array_merge($params, $_GET['dep']);
}
$q = <<<EOF
SELECT r.id as id, d.name AS dep, d.id AS dep_id, 
r.position as position, r.posted_at as date, 
r.priority as priority, SUM(CASE WHEN p.status=0 THEN 1 ELSE 0 END) AS cnt, 
r.status as status
FROM vacancies AS r 
INNER JOIN departments AS d ON d.id = r.dep_id
LEFT JOIN people AS p ON p.vacancy_id=r.id
GROUP BY r.id
EOF;
$p = $pdo->prepare($q);
$p->execute($params);
$fa = $p->fetchAll();
$q = "SELECT id, name FROM `departments`";
$p = $pdo->prepare($q);
$p->execute();
$deps = $p->fetchAll();
?>
<html>
<head>
    <link rel="stylesheet" href="/style/style.css">
    <link rel="stylesheet" href="/style/table.css">
    <meta charset="UTF-8"> 
    <title>HRPanel+ | Вакансии</title>
</head>
<body>
    <header class="site-header">
        <h1>HRPanel+</h1>
        <nav class="site-nav">
            <a href="/">Главная</a>
            <a href="/vacancies.php" class="current-page">Вакансии</a>
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
            <h2>Вакансии</h2>
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
                    <div class="filter ">
                        <button>Открытые/Закрытые</button>
                        <div class="checkboxes hidden">
                            <label><input type="checkbox"><p>Только открытые</p></label>
                            <label><input type="checkbox"><p>Только закрытые</p></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table table-vacs">
                <div class="row">
                    <div class="thead"><input type="checkbox" class="select"></div>
                    <div class="thead" name="dep">Отдел</div>
                    <div class="thead" name="pos">Позиция</div>
                    <div class="thead" name="date">Дата создания</div>
                    <div class="thead" name="prior">Приоритет</div>
                    <div class="thead" name="cnt">Кандитаты на рассмотрении</div>
                    <div class="thead" name="status">Статус</div>
                    <div class="thead">+Кандидат</div>
                </div>

                <?php foreach($fa as $row): ?>
                <div class="row" data-id="<?= $row['id'] ?>">
                    <div class="second"><input type="checkbox" class="select"></div>
                    <div class="second editable"><span><?= $row['dep'] ?></span><select class="edit-cell">
                        <?php foreach($deps as $dep): ?>
                        <option value="<?= $dep['name'] ?>" <?php if($dep['id']==$row['dep_id']) echo 'selected' ?>><?= $dep['name'] ?></option>
                        <?php endforeach; ?>
                    </select></div>
                    <div class="second editable"><span><?= $row['position'] ?></span><input type="text" class="edit-cell"></div>
                    <div class="second editable"><span><?= substr($row['date'], 0, 10) ?></span><input type="date" class="edit-cell"></div>
                    <div class="second editable"><span><?= $row['priority'] ?></span><input type="number" class="edit-cell"></div>
                    <div class="second"><a href="resumes.php?status[]=0&vacancy[]=<?= $row['id'] ?>"><?= $row['cnt'] ?></a></div>
                    <div class="second"><?= STATUSES_VACS[$row['status']] ?></div>
                    <div class="second"><a href="create.php?type=candidate?vacancy=<?= $row['id'] ?>">+Кандидат</a></div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <script src="/script/table.js"></script>
</body>
</html>