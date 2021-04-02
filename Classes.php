<?php

class Form
{
    /*public $password;
    public $login;*/
    protected function getMethod($att){
        $str ='';
        foreach($att as $k=>$v){
            $str.=$k.'="'.$v.'" ';
        }
        return $str;
    }
    public function input($att)
    {
        $arr = $this->getMethod($att);
        echo "<input $arr>";
        return null;
    }

    public function submit($att)
    {
        $arr = $this->getMethod($att);
        echo "<input type='submit' $arr>";
        return null;
    }

    public function open($arr2)
    {
        echo "<form action='$arr2[action]' method='$arr2[method]'>";
        return null;
    }

    public function close()
    {
        echo "</form>";
        return null;
    }

}

class SmartForm extends Form {
    protected function getMethod($att){
        if(!empty($_REQUEST[$att['name']])){
            $att['value']=$_REQUEST[$att['name']];
        }
        return parent::getMethod($att);
    }
}

/*$smartForm = new smartForm();
echo $smartForm->open(['action' => 'index.php', 'method' => 'post']);
echo $smartForm->input(['type' => 'text','placeholder'=>'Ваше имя', 'name' => 'name']);
echo $smartForm->password(['placeholder'=>'Ваше пароль', 'name' => 'pass']);
echo $smartForm->textarea(['name' => 'text', 'cols' => 100, 'rows' => 5]);
echo $smartForm->submit(['value'=>'submit']);
echo $smartForm->close();*/

class Cookie
{
    public function set($code)
    {
        setcookie(CAPTCHA_COOKIE, md5($code));
    }

    public function get()
    {
        return $_COOKIE[CAPTCHA_COOKIE];
    }

    public function del()
    {
        unset($_COOKIE['CAPTCHA_COOKIE']);
         //setcookie('CAPTCHA_COOKIE', null, -1, '/');

    }
}

class Session
{
    public function start()
    {
        session_start();
    }

    public function get($arr)
    {
        return $_SESSION[$arr];
    }

    public function stop()
    {
        session_destroy();
    }

    public function del($arr)
    {
        unset ($_SESSION[$arr]);
    }
}

class Logger
{
    //статические переменные
    public static $PATH;
    protected static $loggers = array();

    protected $name;
    protected $file;
    protected $fp;

    public function __construct($name, $file = null)
    {
        $this->name = $name;
        $this->file = $file;

        $this->open();
    }

    public function open()
    {
        if (self::$PATH == null) {
            return;
        }

        $this->fp = fopen($this->file == null ? self::$PATH . '/' . $this->name . '.log' : self::$PATH . '/' . $this->file, 'a+');
    }

    public static function getLogger($name = 'root', $file = null)
    {
        if (!isset(self::$loggers[$name])) {
            self::$loggers[$name] = new Logger($name, $file);
        }

        return self::$loggers[$name];
    }

    public function log($message)
    {
        if (!is_string($message)) {
            // если мы хотим вывести, к примеру, массив
            $this->logPrint($message);
            return;
        }

        $log = '';
        // зафиксируем дату и время происходящего
        $log .= '[' . date('D M d H:i:s Y', time()) . '] ';
        // если мы отправили в функцию больше одного параметра,
        // выведем их тоже
        if (func_num_args() > 1) {
            $params = func_get_args();

            $message = call_user_func_array('sprintf', $params);
        }

        $log .= $message;
        $log .= "\n";
        // запись в файл
        $this->_write($log);
    }

    public function logPrint($obj)
    {
        // заносим все выводимые данные в буфер
        ob_start();

        print_r($obj);
        // очищаем буфер
        $ob = ob_get_clean();

        // записываем
        $this->log($ob);
    }

    protected function _write($string)
    {

        fwrite($this->fp, $string);

    }

// деструктор
    public function __destruct()
    {
        fclose($this->fp);
    }
}

Logger::$PATH = dirname(__FILE__);

/*$smartform = new SmartForm();
$form = new Form();
echo $form->open(['action' => 'index.php', 'method' => 'POST']);
echo $form->input(['type' => 'password', 'value' => 'Password', 'name' => 'password']);
echo $form->input(['type' => 'login', 'value' => 'Login', 'name' => 'login']);
echo $form->input(['type' => 'text', 'value' => '!!!', 'name' => 'text']);
echo $form->submit(['value' => 'go']);
echo $form->close();*/
