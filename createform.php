<?php if(!isset($type)) $type = 'meetup'; ?>
<div class="quick-create">
                        <img src="icons/plus-circle.svg" alt="" class="bigplus">
                        <form class="create-form" action="" method="post">
                            <h2>Добавить
                                <select class="form-option">
                                  <option value="candidate" <?php if($type=='candidate') echo 'selected'; ?>>кандидата</option>
                                  <option value="meetup" <?php if($type=='meetup') echo 'selected'; ?>>интервью</option>
                                  <option value="vacancy" <?php if($type=='vacancy') echo 'selected'; ?>>вакансию</option>
                                </select></h2>
                            <div class="fields">
                                <div class="create-option candidate">
                                    <label for="">Имя: <input type="text" name="name" required></label>
                                    <label for="">Вакансия:                                 <select required name="vacancy" class="form-option">
                                    <?php foreach($vacs as $vac): ?>
                                    <option value="<?= $vac['id'] ?>"><?= $vac['dep'] . '/' . $vac['pos'] ?></option>
                                    <?php endforeach; ?>
                                    </select></label>
                                    <label for="">Источник:                                 <select name="source" class="form-option">
                                        <?php foreach($sources as $s): ?>
                                        <option value="<?= $s['id'] ?>"><?= $s['name'] ?></option>
                                        <?php endforeach; ?>
                                    </select></label>
                                    <label for="">Ссылка на резюме: <input type="text" required name="resume"></label>
                                    <label for="">Рекрутер:                                 <select class="form-option" name="rec" required>
                                    <?php foreach($recs as $s): ?>
                                    <option value="<?= $s['id'] ?>"><?= $s['name'] ?></option>
                                    
                                    <?php endforeach; ?>
                                    </select></label>
                                </div>
                                <div class="create-option meetup">
                                    <label for="">Кандидат: 
                                        <select name="resume" required>
                                        <?php foreach($cands as $s): ?>
                                        <option value="<?= $s['id'] ?>"><?= $s['name'] ?></option>
                                        <?php endforeach; ?>
                                        </select>
                                    </label>
                                    <label for="">Этап: 
                                        <select name="stage" required>
                                        <?php foreach($stages as $s): ?>
                                        <option value="<?= $s['id'] ?>"><?= $s['name'] . ' ' . $s['number'] ?></option>
                                        <?php endforeach; ?>
                                        </select>
                                    </label>
                                    <label for="">Дата: <input type="date" name="date" required></label>
                                    <label for="">Оценка: <input type="number" required value="5" name="mark"></label>
                                    <label for="">Статус:
                                        <select name="status" required>
                                            <option value="0">На рассмотрении</option>
                                            <option value="1">Отклонен</option>
                                            <option value="2">Прошел/option>
                                            <option value="3">Принят</option>
                                            <option value="4">Уволился</option>                                        
                                        </select>
                                    </label>
                                            
                                </div>
                            <div class="create-option vacancy">
                                    <label for="">Позиция: <input type="text" required name="position"></label>
                                    <label for="">Отдел:                                 <select class="form-option" name="dep" required>
                                    <?php foreach($deps as $s): ?>
                                    <option value="<?= $s['id'] ?>"><?= $s['name'] ?></option>
                                    
                                    <?php endforeach; ?>
                                    </select></label>
                                    <label for="">Дата cоздания: <input type="date" name="date" required></label>
                                    <label for="">Приоритет: <input type="number" required value="1" name="priority"></label>
                                </div>
                            </div>
                            <button type="submit">ОК</button>
                        </form>
                    </div>