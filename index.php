<?php
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
if (empty($_SERVER['PHP_AUTH_USER']) ||
      empty($_SERVER['PHP_AUTH_PW']) ||
      $_SERVER['PHP_AUTH_USER'] != 'admin' ||
      md5($_SERVER['PHP_AUTH_PW']) != $pass_hash) {
    header('HTTP/1.1 401 Unanthorized');
    header('WWW-Authenticate: Basic realm="My site"');
    print('<h1>401 Unauthorized (Требуется авторизация)</h1>');
    exit();
}
if(empty($_GET['edit_id'])){
  header('Location: admin.php');
}
header('Content-Type: text/html; charset=UTF-8');
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $messages = array();
  if (!empty($_COOKIE['save'])) {
    setcookie('save', '', 100000);
    $messages[] = 'Спасибо, результаты сохранены.';
    setcookie('name_value', '', 100000);
    setcookie('email_value', '', 100000);
    setcookie('year_value', '', 100000);
    setcookie('sex_value', '', 100000);
    setcookie('limbs_value', '', 100000);
    setcookie('biography_value', '', 100000);
    setcookie('1_value', '', 100000);
    setcookie('2_value', '', 100000);
    setcookie('3_value', '', 100000);
    setcookie('4_value', '', 100000);
    setcookie('5_value', '', 100000);
    setcookie('check_value', '', 100000);
  }
  
  $errors = array();
  $error=FALSE;
  $errors['name'] = !empty($_COOKIE['name_error']);
  $errors['name1'] = !empty($_COOKIE['name_error1']);
  $errors['email'] = !empty($_COOKIE['email_error']);
  $errors['email1'] = !empty($_COOKIE['email_error1']);
  $errors['year'] = !empty($_COOKIE['year_error']);
  $errors['sex'] = !empty($_COOKIE['sex_error']);
  $errors['limbs'] = !empty($_COOKIE['limbs_error']);
  $errors['ability'] = !empty($_COOKIE['ability_error']);
  $errors['biography'] = !empty($_COOKIE['biography_error']);
  $errors['check'] = !empty($_COOKIE['check_error']);
  if ($errors['name']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('name_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Заполните имя.</div>';
  }
  if ($errors['name1']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('name_error1', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">В имени не могут присутствовать цифры.</div>';
  }
  if ($errors['email']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('email_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Заполните корректно email.</div>';
  }
  if ($errors['year']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('year_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Заполните год рождения.</div>';
  }
  if ($errors['sex']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('sex_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Заполните пол.</div>';
  }
  if ($errors['limbs']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('limbs_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Заполните кол-во конечностей.</div>';
  }
  if ($errors['ability']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('ability_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Заполните поле с суперспособностями.</div>';
  }
  if ($errors['biography']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('biography_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Заполните корректно биографию.</div>';
  }
  if ($errors['check']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('check_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Вы должны согласиться с условиями ипользования данных.</div>';
  }
  $values = array();
  $values['1'] = 0;
  $values['2'] = 0;
  $values['3'] = 0;
  $values['4'] = 0;
  $values['5'] = 0;
  
  $user = 'u47770';
  $pass = '445614';
  $db = new PDO('mysql:host=localhost;dbname=u47770', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
  try{
      $id=$_GET['edit_id'];
      $get=$db->prepare("SELECT * FROM application WHERE id=?");
      $get->bindParam(1,$id);
      $get->execute();
      $inf=$get->fetchALL();
      $values['name']=$inf[0]['name'];
      $values['email']=$inf[0]['email'];
      $values['year']=$inf[0]['year'];
      $values['sex']=$inf[0]['sex'];
      $values['limbs']=$inf[0]['limbs'];
      $values['biography']=$inf[0]['biography'];
    
      $get2=$db->prepare("SELECT ability_id FROM application_ability WHERE application_id=?");
      $get2->bindParam(1,$id);
      $get2->execute();
      $inf2=$get2->fetchALL();
      for($i=0;$i<count($inf2);$i++){
        if($inf2[$i]['ability_id']=='1'){
          $values['1']=1;
        }
        if($inf2[$i]['ability_id']=='2'){
          $values['2']=1;
        }
        if($inf2[$i]['ability_id']=='3'){
          $values['3']=1;
        }
        if($inf2[$i]['ability_id']=='4'){
          $values['4']=1;
        }
        if($inf2[$i]['ability_id']=='5'){
          $values['5']=1;
        }
      }
    }
    catch(PDOException $e){
      print('Error: '.$e->getMessage());
      exit();
  }
  include('form.php');
}
else {
  if(!empty($_POST['save'])){
    $id=$_POST['nform'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $year = $_POST['year'];
    $pol=$_POST['sex'];
    $limbs=$_POST['limbs'];
    $powers=$_POST['ability'];
    $bio=$_POST['biography'];

    //Регулярные выражения
    $bioregex = "/^\s*\w+[\w\s\.,-]*$/";
    $nameregex = "/^\w+[\w\s-]*$/";
    $mailregex = "/^[\w\.-]+@([\w-]+\.)+[\w-]{2,4}$/";
    $errors = FALSE;
    
    if (empty($name) || (!preg_match($nameregex,$name))) {
      setcookie('name_error', '1', time() + 24*60 * 60);
      setcookie('name_value', '', 100000);
      $errors = TRUE;
    }

    if (empty($email) || !filter_var($email,FILTER_VALIDATE_EMAIL) ||
     (!preg_match($mailregex,$email))) {
      setcookie('email_error', '1', time() + 24*60 * 60);
      setcookie('email_value', '', 100000);
      $errors = TRUE;
    }
    
    if (!isset($year)) {
      setcookie('year_error', '1', time() + 24 * 60 * 60);
      setcookie('year_value', '', 100000);
      $errors = TRUE;
    }
   
    if (!isset($pol)) {
      setcookie('pol_error', '1', time() + 24 * 60 * 60);
      setcookie('pol_value', '', 100000);
      $errors = TRUE;
    }
    
    if (!isset($limbs)) {
      setcookie('limb_error', '1', time() + 24 * 60 * 60);
      setcookie('limb_value', '', 100000);
      $errors = TRUE;
    }

    if (!isset($powers)) {
      setcookie('super_error', '1', time() + 24 * 60 * 60);
      $errors = TRUE;
    }
    
    if ((empty($bio)) || (!preg_match($bioregex,$bio))) {
      setcookie('bio_error', '1', time() + 24 * 60 * 60);
      setcookie('bio_value', '', 100000);
      $errors = TRUE;
    }
    
    if ($errors) {
      setcookie('save','',100000);
      header('Location: index.php?edit_id='.$id);
    }
    else {
      setcookie('name_error', '', 100000);
      setcookie('email_error', '', 100000);
      setcookie('year_error', '', 100000);
      setcookie('sex_error', '', 100000);
      setcookie('limbs_error', '', 100000);
      setcookie('ability_error', '', 100000);
      setcookie('biography_error', '', 100000);
      setcookie('check_error', '', 100000);
    }
    
    $user = 'u47770';
    $pass = '445614';
    $db = new PDO('mysql:host=localhost;dbname=u47770', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
    if(!$errors){
      $upd=$db->prepare("UPDATE application SET name=:name, email=:email, year=:byear, sex=:pol, limbs=:limbs, biography=:bio WHERE id=:id");
      $cols=array(
        ':name'=>$name,
        ':email'=>$email,
        ':byear'=>$year,
        ':pol'=>$pol,
        ':limbs'=>$limbs,
        ':bio'=>$bio
      );
      foreach($cols as $k=>&$v){
        $upd->bindParam($k,$v);
      }
      $upd->bindParam(':id',$id);
      $upd->execute();
      $del=$db->prepare("DELETE FROM application_ability WHERE application_id=?");
      $del->execute(array($id));
      $upd1=$db->prepare("INSERT INTO application_ability SET ability_id=:power, application_id=:id");
      $upd1->bindParam(':id',$id);
      foreach($powers as $pwr){
        $upd1->bindParam(':power',$pwr);
        $upd1->execute();
      }
    }
    
    if(!$errors){
      setcookie('save', '1');
    }
    header('Location: index.php?edit_id='.$id);
  }
  else {
    $id=$_POST['nform'];
    $user = 'u47770';
    $pass = '445614';
    $db = new PDO('mysql:host=localhost;dbname=u47770', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
    try {
      $del=$db->prepare("DELETE FROM application_ability WHERE application_id=?");
      $del->execute(array($id));
      $stmt = $db->prepare("DELETE FROM application WHERE id=?");
      $stmt -> execute(array($id));
    }
    catch(PDOException $e){
      print('Error : ' . $e->getMessage());
    exit();
    }
    setcookie('del','1');
    setcookie('del_user',$id);
    header('Location: admin.php');
  }

}
