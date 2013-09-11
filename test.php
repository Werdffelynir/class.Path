<?php
header("Content-type: text/html; charset=utf-8");


// Подключение скрипта
require_once('class_path_v010/class.path.v0.1.0.php');

$p = Path::getInstance(); // Инициализация класса.

// Параметры класса. Не являються обезательными если файл класса лежит в корневой директории приложения.
$p->pathSettings = array(
    "appfolder" =>"classPath",         // Какалог приложения. Этот параметры необходимы если файл class.path.php находиться НЕ в корне приложения.
    "pathfolder"=>"classPath/class_path_v010", // Какалог в котором находится класс. Этот параметры необходимы если файл class.path.php находиться НЕ в корне приложения.
    "separator" => true,               // false если НЕ хотите чтобы в конце строки выводился сепаратор "/". Поумолчанию true выводится.
    "httpremove"=> false,               // true если хотите с всех URL удалить начало строки "http://"
    "scripttime"=> true
);
//$p->scriptS();
/* Иной вывод настроек
$p->pathSettings["appfolder"]   = "classPath";
$p->pathSettings["pathfolder"]  = "classPath/classes";
$p->pathSettings["separator"]   = "true";
$p->pathSettings["httpremove"]  = "false";
$p->pathSettings["scripttime"]  = "true";
*/


// Назначение рабочих каталогов (E:\SERVER\domains\mysite.loc\myApplicationFolder\__рабочий_каталог__\). Если каталога не существует ничего не выводиться
$PATH_admin     = $p->rootDir('admin');         // E:\SERVER\domains\mysite.loc\myApplicationFolder\admin\
$PATH_system    = $p->rootDir('admin\system');  // E:\SERVER\domains\mysite.loc\myApplicationFolder\admin\system\
$PATH_classes   = $p->rootDir('classes');
$PATH_template  = $p->rootDir('template');


// Назначение рабочих каталогов для URL (http://dev.loc/myApplicationFolder/__рабочий_каталог__/)
$URL_plagin     = $p->urlDir('plagin');         // http://dev.loc/myApplicationFolder/plagin/
$URL_template   = $p->urlDir('template');

/* ----------------- Вывод результата ------------------ */

$p->self();     // Путь от корная приложения к скрипту (/myApplicationFolder/index.php)
$p->url();      // URL приложения (http://dev.loc/myApplicationFolder/)
$p->urlSafe();  // URL безопасное соединение (https://dev.loc/myApplicationFolder/)
$p->urlNH();    // Путь от корная домена до приложения (dev.loc/myApplicationFolder/)
// Каждый метод может иметь не обезательный параметр, булевого значение, что выводит результат в ECHO


$p->root;                   // Возратит корень приложения
$p->root();                 // То же что и выше
#$p->root(true);            // true включает ECHO для методов
header("Content-type: text/html; charset=utf-8");

$p->rootD;                  // аналогично
$p->rootD();
#$p->rootD(true);


// Создание путей и вывод "на ходу", 
#$p->rootDir('admin', true); // true включает ECHO для методов


// Другие свойства
$p->host;       // Возвращает имя хоста (dev.loc)
$p->pathfolder; // Возвращает название директории приложения (classPath)
$p->rootpath;   // Корень к приложению (E:\__SERVER\domains\dev.loc\myApplicationFolder\)


?>


<div>
    <p> Вывод методом <b>url([true])</b>: <?php echo $p->url();?> </p>
</div>

<div>
    <p> Вывод методом <b>urlSafe([true])</b>: <?php echo $p->urlSafe();?> </p>
</div>

<div>
    <p> Вывод методом <b>urlNH([true])</b>: <?php echo $p->urlNH();?> </p>
</div>

<div>
    <p> Вывод методом <b>root([true])</b> или свойством <b>root</b>: <?php echo $p->root();?> </p>
</div>

<div>
    <p> Вывод методом <b>rootD([true])</b> или свойством <b>rootD</b>: <?php echo $p->rootD();?> </p>
</div>

<div>
    <p> Вывод набраных каталогов <b>urlDir('__директория__' [, true])</b>: <br />
        <ul>
            <li><?php echo $URL_plagin; ?> </li>
            <li><?php echo $URL_template; ?> </li>
        </ul>
    </p>
</div>

<div>
    <p> Вывод набраных каталогов <b>rootDir('__директория__' [, true])</b>: <br />
        <ul>
            <li><?php echo $PATH_admin; ?> </li>
            <li><?php $p->rootDir('admin', true); ?>  - динамически сознаный параметр.</li>
            <li><?php echo $PATH_system; ?> </li>
            <li><?php echo $PATH_classes; ?> </li>
            <li><?php echo $PATH_template; ?> </li>
        </ul>
    </p>
</div>

<div>
    <p> Вывод методом <b>scriptR([true])</b> времеи загрузки скрипта: <?php $p->scriptR(true);?> </p>
</div>

<br /><h2>Перед выводом предведущей информации, были определены инициализующие параметры класса следующие:</h2>
<pre><code>
require_once('classes/class.path.php');

$p = Path::getInstance(); // Применение, инициализация класса.

// Параметры класса
$p->pathSettings = array(
    "appfolder" =>"classPath",         // Какалог приложения. Этот параметры необходимы если файл class.path.php находиться НЕ в корне приложения.
    "pathfolder"=>"classPath/classes", // Какалог в котором находится класс. Этот параметры необходимы если файл class.path.php находиться НЕ в корне приложения.
    "separator" => true,               // false если НЕ хотите чтобы в конце строки выводился сепаратор "/". Поумолчанию true выводится.
    "httpremove"=> false,              // true если хотите с всех URL удалить начало строки "http://"
    "scripttime"=> false               // ключить счетчик, вычисляет затраченое время на загрузку скрипта, вызывать методом scriptR()
);


// Назначение рабочих каталогов (E:\SERVER\domains\mysite.loc\myApplicationFolder\__рабочий_каталог__\). Если каталога не существует ничего не выводиться
$PATH_admin     = $p->rootDir('admin');         // E:\SERVER\domains\mysite.loc\myApplicationFolder\admin\
$PATH_system    = $p->rootDir('admin\system');  // E:\SERVER\domains\mysite.loc\myApplicationFolder\admin\system\
$PATH_classes   = $p->rootDir('classes');
$PATH_template  = $p->rootDir('template');


// Назначение рабочих каталогов для URL (http://dev.loc/myApplicationFolder/__рабочий_каталог__/)
$URL_plagin     = $p->urlDir('plagin');         // http://dev.loc/myApplicationFolder/plagin/
$URL_template   = $p->urlDir('template');
echo $URL_plagin;

$p->pathCreated(); // Какрытие настроек, для инициализации всех свойст и методов.


$p->self();     // Путь от корная приложения к скрипту (/myApplicationFolder/index.php)
$p->url();      // URL приложения (http://dev.loc/myApplicationFolder/)
$p->urlSafe();  // URL безопасное соединение (https://dev.loc/myApplicationFolder/)
$p->urlNH();    // Путь от корная домена до приложения (dev.loc/myApplicationFolder/)
// Каждый метод может иметь не обезательный параметр, булевого значение, что выводит результат в ECHO


$p->root;                   // Возратит корень приложения
$p->root();                 // То же что и выше
#$p->root(true);            // true включает ECHO для методов


$p->rootD;                  // аналогично
$p->rootD();
#$p->rootD(true);


// Создание путей и вывод "на ходу", 
#$p->rootDir('admin', true); // true включает echo для методов


// Другие свойства
$p->host;       // Возвращает имя хоста (dev.loc)
$p->pathfolder; // Возвращает название директории приложения (classPath)
$p->rootpath;   // Корень к приложению (E:\__SERVER\domains\dev.loc\myApplicationFolder\)

$p->scriptR()   //  Выводи время загрузки скрипта, если в настройках включено.

</code></pre>







<?php
//$time = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
//echo "Время загрузки внешнее: <b> $time </b> секунд<br>";
echo "Время загрузки скрипта: <b> ".$p->scriptR()." </b> секунд<br>";
?>
