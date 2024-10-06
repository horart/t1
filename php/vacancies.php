<?php
require 'db.php';
$cond = "WHERE r.status=0";
if(isset($_GET['status'])) {
    $cond .= " AND r.status IN " . arr_to_in($_GET[status]);
}
$q = <<<EOF
SELECT r.id as id, d.name AS dep, d.id AS dep_id, r.position as position, r.posted_at as date, r.priority as priority, COUNT(p.id) AS cnt, r.status as status
FROM vacancies AS r 
LEFT JOIN people AS p ON p.vacancy_id=r.id 
INNER JOIN departments AS d ON d.id = r.dep_id
{$cond}
GROUP BY r.id
EOF;
$p = $pdo->prepare($q);
$p->execute([]);
$fa = $p->fetchAll();
var_dump($fa);
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
            <a href="/vacancies.html" class="current-page">Вакансии</a>
            <a href="/resumes.html">Резюме</a>
            <a href="/recruiters.html">Рекрутеры</a>
            <a href="/interviews.html">Интервью</a>
            <a href="/analyzer.html">Анализатор</a>
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
                <div class="thead"><input type="checkbox" class="select"></div>
                <div class="thead">Отдел</div>
                <div class="thead">Позиция</div>
                <div class="thead">Дата создания</div>
                <div class="thead">Приоритет</div>
                <div class="thead">Кандитаты на рассмотрении</div>
                <div class="thead">Закрыта</div>
                <div class="thead">+Кандидат</div>

                
            
                <?php foreach($fa as $row): ?>
                <div class="row" data-id="<?= $row['id'] ?>">
                    <div class="second"><input type="checkbox" class="select"></div>
                    <div class="second"><?= $row['dep'] ?></div>
                    <div class="second"><?= $row['position'] ?></div>
                    <div class="second"><?= $row['date'] ?></div>
                    <div class="second">1</div>
                    <div class="second">5</div>
                    <div class="second">Нет</div>
                    <div class="second"><a href="create.php?type=candidate?vacancy=<?= $row['id'] ?>">+Кандидат</a></div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <script src="/script/table.js"></script>
</body>
</html>