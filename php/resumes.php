<?php

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
            <a href="/vacancies.html">Вакансии</a>
            <a href="/resumes.html" class="current-page">Резюме</a>
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

                <div><input type="checkbox" class="select"></div>
                <div class="editable"><span>Артём Хорев</span><input type="text" class="edit-cell hidden"></div>
                <div>IT/Разработчик C++</div>
                <div class="editable"><select>
                        <option>техническое собеседование</option>
                        <option>оффер</option>
                </select></div>
                <div class="editable"><span>02.10.24</span><input type="text" class="edit-cell hidden"></div>
                <div><select>
                    <option>HH.ru</option>
                    <option>Авито</option>
                </select></div>
                <div class="editable"><span><a href="#">Ссылка</a></span><input type="text" class="edit-cell hidden"></div>
                <div><select>
                    <option>В работе</option>
                    <option>Отказано</option>
                    <option>Принят</option>
                    <option>Уволился</option>
            </select></div>
                <div>Анатолий Карпов</div>
                <div><button>+Интервью</button></div>
            </div>
        </div>
    </div>
    <script src="/script/table.js"></script>
</body>
</html>