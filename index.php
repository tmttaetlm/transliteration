<?php
    ini_set('display_errors',1);
    error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <title>NIS Transliterating</title>
    <link rel="stylesheet" href="style.css">
    <!--<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">-->
    <?php include __DIR__.'/сounter/count.php'; ?>
</head>
<body>
    <header>
        <div class="wrapper">
            <div class="logo">
                <h1><a href="/">NIS</a></h1>
                <h2><a href="/">KOSTANAY</a></h2>
            </div>
            <div class="title">
                <h1><a href="/">СИСТЕМА ТРАНСЛИТЕРАЦИИ</a></h1>
            </div>
        </div>
    </header>
    <section>
        <div class="wrapper">
            <div class="tabs">
                <input type="radio" id="global" name="tabs" checked/>
                <label for="global">Массовая транслитерация</label>
                <input type="radio" id="local" name="tabs" />
                <label for="local">Одиночная транслитерация</label>
                <div class="content">
                    <article class="local">
                        <input id="fio" placeholder="Введите ФИО..." />
                        <input id="res" placeholder="Результат транслитерации" readonly/>
                    </article>
                    <article class="global">
                        <p>1. <a href="files/Шаблон.xlsx" download>Скачайте шаблон</a>, заполните его данными учащихся.</p><br>
                        <p>2. Выберите ваш поддомен <select id="subdomen" style="margin-left: 5px;">
                            <option value=""></option>
                            <option value="@akb.nis.edu.kz">@akb.nis.edu.kz</option>
                            <option value="@akt.nis.edu.kz">@akt.nis.edu.kz</option>
                            <option value="@ast.nis.edu.kz">@ast.nis.edu.kz</option>
                            <option value="@atr.nis.edu.kz">@atr.nis.edu.kz</option>
                            <option value="@fmalm.nis.edu.kz">@fmalm.nis.edu.kz</option>
                            <option value="@fmsh.nis.edu.kz">@fmsh.nis.edu.kz</option>
                            <option value="@hbalm.nis.edu.kz">@hbalm.nis.edu.kz</option>
                            <option value="@hbsh.nis.edu.kz">@hbsh.nis.edu.kz</option>
                            <option value="@ib.nis.edu.kz">@ib.nis.edu.kz</option>
                            <option value="@isa.nis.edu.kz">@isa.nis.edu.kz</option>
                            <option value="@krg.nis.edu.kz">@krg.nis.edu.kz</option>
                            <option value="@kst.nis.edu.kz">@kst.nis.edu.kz</option>
                            <option value="@kt.nis.edu.kz">@kt.nis.edu.kz</option>
                            <option value="@kzl.nis.edu.kz">@kzl.nis.edu.kz</option>
                            <option value="@ptr.nis.edu.kz">@ptr.nis.edu.kz</option>
                            <option value="@pvl.nis.edu.kz">@pvl.nis.edu.kz</option>
                            <option value="@sm.nis.edu.kz">@sm.nis.edu.kz</option>
                            <option value="@tk.nis.edu.kz">@tk.nis.edu.kz</option>
                            <option value="@trz.nis.edu.kz">@trz.nis.edu.kz</option>
                            <option value="@ukk.nis.edu.kz">@ukk.nis.edu.kz</option>
                            <option value="@ura.nis.edu.kz">@ura.nis.edu.kz</option>
                        </select></p><br>
                        <div style="display: flex;">
                            <label>3. Выберите заполненный файл шаблона</label>
                            <form id="file-form" enctype="multipart/form-data" action="transliteration.php" method="POST" style="width: 60%;">
                                <input type="file" id="file-select" name="userfile" style="display: none">
                                <label for="file-select" id="label-file" class="label-file">
                                    <img src="images/download.png" id="i-file" style="margin: -6px 0px;">
                                    <span id="span-file">Загрузить файл</span>
                                </label>
                                <input type="text" id="mode" name="mode" value="csv" style="display: none;">
                                <input type="text" id="domen" name="domen" style="display: none;"><br>
                                <input type="checkbox" name="midnames" id="midnames">
                                <label for="midnames">Исключить отчества из ФИО</label>
                                <input type="submit" id="file-send" style="display: none;">
                            </form>
                        </div>
                        <br>
                        <div style="margin-left: 15px; margin-top: 25px;">
                            <p style="margin-top: 10px;">Нажмите <a id="to-csv" disabled>Транслитерация в CSV</a>. После этого скачается транслитерированная таблица <em>Translit-Output.csv</em>.</p>
                            <p style="margin-top: 10px;">Нажмите <a id="to-xls" disabled>Выгрузить учетные данные АД</a> если вам нужен файл с логинами и паролями.</p>
                        </div><br>
                        <p>4. Заполните поля для генерации скрипта.</p>
                        <div style="margin-left: 15px;">
                            <input type="text" id="ip-adres" placeholder="IP адрес вашего сервера КД" />
                            <label style="font-size: 14px;"><em>Если ваш локальный сервер не поддерживает удаленное подключение, можете указать IP головного сервера <b>10.1.0.3</b> - в этом случае учетки появятся после репликации.</em></label><br>
                            <input type="text" id="ou3" class="translit-ou" placeholder="OU" />
                            <input type="text" id="ou2" class="translit-ou" placeholder="OU" />
                            <input type="text" id="ou1" class="translit-ou" placeholder="OU" />
                            <input type="text" id="ou0" class="translit-ou" placeholder="OU" readonly/>
                            <input type="text" class="translit-ou" value="nis" readonly />
                            <input type="text" class="translit-ou" value="edu" readonly />
                            <input type="text" class="translit-ou" value="kz" readonly />
                            <br>
                            <label class="example" id="example">Пример: OU=7, OU=Students, OU=Users, OU=</label>
                            <br>
                            <form id="script-form" enctype="multipart/form-data" action="transliteration.php" method="POST" style="width: 100%;">
                                <input type="checkbox" name="pne" id="pne">
                                <label for="pne">Срок действия пароля неограничен</label>
                                <input type="checkbox" name="cpl" id="cpl">
                                <label for="cpl">Требовать смену пароля при входе в систему</label><br>
                                <input type="checkbox" name="en" id="en">
                                <label for="en">Отключить учетную запись</label>
                                <input type="checkbox" name="ccp" id="ccp">
                                <label for="ccp">Запретить смену пароля пользователем</label>
                                <input type="text" id="mode" name="mode" value="script" style="display: none;">    
                                <input type="text" id="ou" name="ou" style="display: none;">
                                <input type="text" id="ip" name="ip" style="display: none;">
                                <input type="submit" id="script-send" style="display: none;">
                            </form><br>
                        </div>
                        <br><br>
                        <p style="margin-left: 15px;margin-top: 10px;">Нажмите <a id="to-script">Сгенерировать скрипт</a> и сохраните в папку <em>C:\script</em>. В папку также необходимо положить файл <em>Translit-Output.csv</em></p><br>
                        <p>5. Запустите <em>PowerShell</em> скрипт. Для удаленного запуска скрипта, рекомендуем установить <a href="files/WindowsTH-RSAT_WS_1803-x64.msu">пакет модулей RSAT</a> на свой локальный компьютер.</p><br>
                        <p>6. Проверьте выбранную OU в AD, появятся созданные учетки.</p>
                    </article>
                </div>
            </div>
            <article class="standart">
                <table>
                    <caption>Стандарт транслитерации</caption>
                    <tr><th>Рус/Каз буквы</th><th>Транслитерация</th><th>Частный случай</th><th>Пример</th><th>Рус/Каз буквы</th><th>Транслитерация</th><th>Частный случай</th><th>Пример</th></tr>
                    <tr><th>а</th><td>a</td><td></td><td></td><th>ц</th><td>ts</td><td></td><td></td></tr>
                    <tr><th>б</th><td>b</td><td></td><td></td><th>ч</th><td>ch</td><td></td><td></td></tr>
                    <tr><th>в</th><td>v</td><td></td><td></td><th>ш</th><td>sh</td><td></td><td></td></tr>
                    <tr><th>г</th><td>g</td><td></td><td></td><th>щ</th><td>chsh</td><td></td><td></td></tr>
                    <tr><th>д</th><td>d</td><td></td><td></td><th>ъ</th><td></td><td></td><td></td></tr>
                    <tr><th>е</th><td>e, ye</td><td>-ye после а, е, ё, и, о, у, э, ы, ь, ъ<br>-ye в начале слова</td><td>Алеев - Aleyev<br>Кондратьев - Kondratyev<br>Ерболат - Yerbolat</td><th>ы</th><td>y</td><td></td><td></td></tr>
                    <tr><th>ё</th><td>e, ye</td><td>-ye после а, е, ё, и, о, у, э, ы, ь, ъ<br>-ye в начале слова"</td><td>Воробьёв - Vorobyev</td><th>ь</th><td></td><td></td><td></td></tr>
                    <tr><th>ж</th><td>zh</td><td></td><td></td><th>э</th><td>e</td><td></td><td></td></tr>
                    <tr><th>з</th><td>z</td><td></td><td></td><th>ю</th><td>yu</td><td></td><td></td></tr>
                    <tr><th>и</th><td>i</td><td></td><td></td><th>я</th><td>ya, a</td><td>-a если -яя</td><td>Синяя - Sinaya</td></tr>
                    <tr><th>й</th><td>i, y</td><td>-i  в середине слова<br>-y на конце слов</td><td>в середине слова Кайрат - Kairat<br>в конце слова Жақсыбай - Zhaqsybay</td><th>ә</th><td>a</td><td></td><td></td></tr>
                    <tr><th>к</th><td>k</td><td></td><td></td><th>і</th><td>i</td><td></td><td></td></tr>
                    <tr><th>л</th><td>l</td><td></td><td></td><th>ң</th><td>n</td><td></td><td></td></tr>
                    <tr><th>м</th><td>m</td><td></td><td></td><th>ғ</th><td>g</td><td></td><td></td></tr>
                    <tr><th>н</th><td>n</td><td></td><td></td><th>ү</th><td>u</td><td></td><td></td></tr>
                    <tr><th>о</th><td>o</td><td></td><td></td><th>ұ</th><td>u</td><td></td><td></td></tr>
                    <tr><th>п</th><td>p</td><td></td><td></td><th>қ</th><td>q</td><td></td><td></td></tr>
                    <tr><th>р</th><td>r</td><td></td><td></td><th>ө</th><td>o</td><td></td><td></td></tr>
                    <tr><th>с</th><td>s, ss</td><td>-ss в слоге с гласными удваивается</td><td>Аскар Досанов - Askar Dossanov</td><th>һ</th><td>h</td><td></td><td></td></tr>
                    <tr><th>т</th><td>t</td><td></td><td></td><th>дж</th><td>j</td><td></td><td>Джамиля - Jamilya</td></tr>
                    <tr><th>у</th><td>u</td><td></td><td></td><th>ый</th><td>y</td><td></td><td>Подгайный - Podgainy</td></tr>
                    <tr><th>ф</th><td>f</td><td></td><td></td><th>ий</th><td>y</td><td></td><td>Сикорский - Sikorsky</td></tr>
                    <tr><th>х</th><td>kh</td><td></td><td></td><th>кс</th><td>x</td><td></td><td>Ксения Фокс - Xeniya Fox</td></tr>
                </table>
            </article>
        </div>
    </section>
    <footer>
        <?php include __DIR__.'/сounter/informer.php'; ?>
        <p class="copyright">Copyright © <?php echo date('Y') ?> NIS Kostanay</p>
    </footer>
    <script src="scripts.js"></script>
</body>

</html>