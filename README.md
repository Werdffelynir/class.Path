php-class-Path
==============

Класс Path. v0.1.0 Предоставляющий гибкое использувание путей и url в приложении.



### Подключение скрипта и использувание

```
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
```
