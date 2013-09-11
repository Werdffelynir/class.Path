<?php


/**
 * Класс Path. v0.1.0
 * Предоставляющий гибкое использувание путей и url в приложении.
 * Автор ОЛВердффельнир 2013
 */
class Path {
    
    /**
     * свойста обзора путей
     */
    public $root;   // корень приложения.
    public $rootD;  // корень домина. Незвисимо от того в каких под папках находиться файл.
    
    /**
     * свойста обзора URL
     */
    public $self    = false;
    public $url     = false;
    public $urlSafe = false;
    public $urlNH   = false;
    
    /**
     * Массив. Настройки класса 
     * @param [appfolder]  Назначить если класс в вложеной дир. путь от корня к приложению. Напр: [appfolder]="my_app", если путь ...\www\mysitw.com\php\my_app\index.php
     * @param [pathfolder] Назначить если класс в вложеной дир. путь от корня к классу. Напр: [pathfolder]="my_app\classes\path", если путь ...\www\mysitw.com\php\my_app\classes\path\class.path.php
     * @param [separator]  Показывать в конце розделитель "/"
     * @param [httpremove] Удалить с начала строки символы запроса URL "http://"
     * @param [scripttime] Включить проверку загрузки скрипта, таймер
     */
    public $pathSettings = array(
                                "appfolder" =>false,    // путь от корня к приложению
                                "pathfolder"=>false,    // путь от корня к классу
                                "separator" =>true,     // Показывать в конце розделитель
                                "httpremove"=>false,    // Удалить с начала строки URL запрос
                                "scripttime"=>false     // Включить таймер загрузки скрипта
                            );    
    
    /**
     * Свойства используемые классом для внутрених расщетов.
     * @param string $sFileName имя файла
     * @return mixed
     */
    public $host = false;
    public $pathfolder;
    public $rootpath;
    public $urlpath;
    protected static $instance;
    
    
    /**
     * Закрытыйе методы.
     */
    private function __construct(){} 
    private function __clone() {}
    private function __wakeup() {}
    public static function getInstance() 
    {
        if ( !isset(self::$instance) ) {
            $class = __CLASS__;
            self::$instance = new $class();
        }
        return self::$instance;
    }
    
    /**
     * Определение и вывод сепаратора 
     * @param string $sFileName имя файла
     * @return mixed
     */
    public function sep($url = 'dir')
    {
        
        if($this->pathSettings['separator'] == true AND $url == 'dir')
            return DIRECTORY_SEPARATOR;
        elseif($this->pathSettings['separator'] == true AND $url == 'url')
            return '/';
         else
            return '';
    }
    
    /** root()
     * Метод назначение параметрами свойства и методы, обработчик путей корневой директории.
     * @param string если TRUE возвратит ECHO.
     * @return string абсолютный путь к корневой директории.
     */
    public function root($e = false)
    {
        if(!empty($this->pathSettings['appfolder']))
        {

            $pathfolder = str_replace('/', DIRECTORY_SEPARATOR, $this->pathSettings['pathfolder']);
            $temper = strpos(__FILE__, $pathfolder);
            $result = substr(__FILE__, 0, $temper);
            $rooter = $result.$this->pathSettings['appfolder'];
            
            $this->root = $rooter.$this->sep('dir');
            $this->rootpath = $rooter.DIRECTORY_SEPARATOR;
            
            if($e)
                echo $rooter.$this->sep('dir');
            else
                return $rooter.$this->sep('dir');
        }
        else
        {
            $this->root = dirname(__FILE__).$this->sep('dir');
            $this->rootpath = dirname(__FILE__).DIRECTORY_SEPARATOR;
            
            if($e)
                echo dirname(__FILE__).$this->sep('dir');
            else
                return dirname(__FILE__).$this->sep('dir');            
        }
    }


    /**
     * Вычисление корня домена
     * @param string если TRUE возвратит ECHO.
     * @return string
     */
    public function rootD($e = false)
    {
        $temper = strpos($this->root(), $this->host);
        $result  = substr($this->root(), 0, $temper);

        $this->rootD = $result.$this->host.$this->sep('dir');
        
        if($e)
            echo $result.$this->host.$this->sep('dir');
        else
            return $result.$this->host.$this->sep('dir');
    }
    
    /** rootDir()
     * Метод назначающий директории для доступа абсолютного пути
     * @param string имя папки, путь от корня приложения.
     * @param string если TRUE возвратит ECHO.
     * @return string
     */
    public function rootDir($namedir=null, $e = false)
    {
        
        $this->root();
        
        $namedir = (is_null($namedir)) ? $this->pathfolder : $namedir;
        
        //echo "<h1>".$this->rootpath.$namedir."</h1>";
        
        if(is_dir($this->rootpath.$namedir))
        {
            if($e)
                echo $this->rootpath.$namedir.$this->sep('dir');
            else
                return $this->rootpath.$namedir.$this->sep('dir');  
        }
        else
        {
            return exit("<h2 style='color:red'>ERROR - FOLDER [" .$namedir. "] UNDEFINED in directory [".$this->rootpath.$namedir."]!</h2>");
        }
            
    }
    
    
    /** rootDir()
     * Метод назначающий директории для доступа относительного пути
     * @param string имя папки, путь от корня приложения.
     * @param string если TRUE возвратит ECHO.
     * @return string
     */
    public function rootDirRel($namedir, $e = false)
    {
        if($e)
            echo $namedir.$this->sep('dir');
        else
            return $namedir.$this->sep('dir');
    }


    /** domin()
     * Метод назначение параметрами свойства и методы, обработчик URL адресов.
     * @param string $domin если автоматически не опрелелено, нужно указать доменное имя
     */
    public function domin($domin = null)
    {
        
        echo $domin;
        
        if($domin == null){
            $http_host =  $_SERVER['HTTP_HOST'];
        }else{
            $http_host = $domin;
        }
        $this->host = $http_host;
        
        $scr_nam_arr = explode("/", trim($_SERVER['SCRIPT_NAME']));
        array_pop($scr_nam_arr);
        
        $scr_nam_arr = array_filter( $scr_nam_arr, function($el){ 
            return !empty($el); }
        );

        $pathfolder = join('/',$scr_nam_arr);
        $this->pathfolder = $pathfolder;
        
        $http = ($this->pathSettings['httpremove'] == false) ? "http://" : '';

        $this->self = "".$_SERVER['SCRIPT_NAME'];
        $this->url = $http.$http_host."/".$pathfolder.$this->sep('url');
        $this->urlpath = $http.$http_host."/".$pathfolder.'/';
        $this->urlSafe = "https://".$http_host."/".$pathfolder.$this->sep('url');
        $this->urlNH = $http_host."/".$pathfolder.$this->sep('url');
    }
    
    /** 
     * Метод быстрого доступа путь от корня приложения до этого скрипта, включая название скрипта.
     * @param string если TRUE возвратит ECHO.
     * @return string
     */
    public function self($e = false)
    {
        if($e)
            echo $this->self;
        else
            return $this->self;
    }
    
    /** 
     * Метод быстрого доступа к URL корень приложения.
     * @param string если TRUE возвратит ECHO.
     * @return string
     */
    public function url($e = false)
    {
        if($e)
            echo $this->url;
        else
            return $this->url;
    }
    
    /** 
     * Метод быстрого доступа к URL путь корня приложения по безопасному протоколу "https://".
     * @param string если TRUE возвратит ECHO.
     * @return string
     */
    public function urlSafe($e = false)
    {
        if($e)
            echo $this->urlSafe;
        else
            return $this->urlSafe;
    }
    
    /** 
     * Метод быстрого доступа к URL корня приложения, без "http://".
     * @param string если TRUE возвратит ECHO.
     * @return string
     */
    public function urlNH($e = false)
    {
        if($e)
            echo $this->urlNH;
        else
            return $this->urlNH;
    }
    
    /** 
     * Метод назначающий директории для доступа по URL 
     * @param string имя папки, путь от корня.
     * @param string если TRUE возвратит ECHO.
     * @return string
     */
    public function urlDir($namedir=null, $e = false)
    {

        $this->domin();
        //$namedir = (is_null($namedir)) ? $this->rootD: $namedir;
        
        if(is_dir($this->rootpath.$namedir)){

            if($e == false)
                return $this->urlpath.$namedir.$this->sep('url');
            else
                echo $this->urlpath.$namedir.$this->sep('url');

        }
        else
        {
            return exit("<h2 style='color:red'>ERROR - FOLDER [" .$namedir. "] UNDEFINED in directory [".$this->urlpath."]!</h2>");
        }
    }
    
    
    /** 
     * Проверка загрузки страницы скрипта. Только для PHP5.4
     * @param boolean параметр на тип вывода результата. TRUE - ECHO
     * @return string результат
     */
    public function scriptR($e = false)
    {
        if(version_compare(PHP_VERSION, '5.4.0') >= 0 AND $this->pathSettings['scripttime'] == true ) {
            
            $time = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
            if($e)
                echo $time;
            else
                return $time;
        }
        else
        {
            return exit("<h2 style='color:red'>REQUIR PHP VERSION 5.4. ! THIS '" .PHP_VERSION. " OR SET OPTION you_path_obj->pathSettings['scripttime']  = 'true';</h2>");
        }
    }
    
    
    
    
} // ---- END CLASS PATH ------------------------------------------------------------------------------

