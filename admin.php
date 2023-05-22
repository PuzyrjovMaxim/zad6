<?php

/**
 * Задача 6. Реализовать вход администратора с использованием
 * HTTP-авторизации для просмотра и удаления результатов.
 **/

 if($_SERVER['REQUEST_METHOD']=='GET'){
  $user = 'u47770';
  $pass = '445614';
  $db = new PDO('mysql:host=localhost;dbname=u47770', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
  $pass_hash=array();
  try{
    $get=$db->prepare("select pass from admin where user=?");
    $get->execute(array('admin'));
    $pass_hash=$get->fetchAll()[0][0];
  }
  catch(PDOException $e){
    print('Error: '.$e->getMessage());
  }
  // Пример HTTP-аутентификации.
  // PHP хранит логин и пароль в суперглобальном массиве $_SERVER.
  // Подробнее см. стр. 26 и 99 в учебном пособии Веб-программирование и веб-сервисы.
  if (empty($_SERVER['PHP_AUTH_USER']) ||
      empty($_SERVER['PHP_AUTH_PW']) ||
      $_SERVER['PHP_AUTH_USER'] != 'admin' ||
      md5($_SERVER['PHP_AUTH_PW']) != md5('123')) {
    header('HTTP/1.1 401 Unanthorized');
    header('WWW-Authenticate: Basic realm="My site"');
    print('<h1>401 Требуется авторизация</h1>');
    exit();
  }
  if(!empty($_COOKIE['del'])){
    echo 'Пользователь '.$_COOKIE['del_user'].' был удалён <br>';
    setcookie('del','');
    setcookie('del_user','');
  }
  print('Вы успешно авторизовались и видите защищенные паролем данные.');

  $users=array();
  $abl=array();
  $abl_def=array('1','2','3','4','5');
  $abl_count=array();

  try{
    $get=$db->prepare("SELECT * FROM application");
    $get->execute();
    $info=$get->fetchALL();
    $get2=$db->prepare("SELECT application_id, ability_id from application_ability");
    $get2->execute();
    $info2=$get2->fetchALL();
    $count=$db->prepare("select count(*) from application_ability where ability_id=?");
    foreach($abl_def as $abil){
      $i=0;
      $count->execute(array($abil));
      $abil_count[]=$count->fetchAll()[$i][0];
      $i++;
    }
  }
  // *********
  // Здесь нужно прочитать отправленные ранее пользователями данные и вывести в таблицу.
  // Реализовать просмотр и удаление всех данных.
  // *********
  catch(PDOException $e){
    print('Error: '.$e->getMessage());
    exit();
  }
  $users=$info;
  $abl=$info2;
  include('table.php');
}