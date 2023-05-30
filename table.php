<div class="table1">
  <table style = "margin-top: 60px; margin-right: 180px">
    <tr>
      <th>Name</th>
      <th>Email</th>
      <th>Year</th>
      <th>Sex</th>
      <th>Limbs</th>
      <th>Ability</th>
      <th>Biography</th>
    </tr>
    <?php
    foreach($users as $user){
        echo '
          <tr>
            <td>'.$user['name'].'</td>
            <td>'.$user['email'].'</td>
            <td>'.$user['year'].'</td>
            <td>'.$user['sex'].'</td>
            <td>'.$user['limbs'].'</td>
            <td>';
              $user_pwrs=array(
                  "1"=>FALSE,
                  "2"=>FALSE,
                  "3"=>FALSE,
                  "4"=>FALSE,
                  "5"=>FALSE,
              );
              foreach($pwrs as $pwr){
                  if($pwr['application_id']==$user['id']){
                    if($pwr['ability_id']=='1'){
                        $user_pwrs['1']=TRUE;
                    }
                    if($pwr['ability_id']=='2'){
                        $user_pwrs['2']=TRUE;
                    }
                    if($pwr['ability_id']=='3'){
                        $user_pwrs['3']=TRUE;
                    }      
                    if($pwr['ability_id']=='4'){
                      $user_pwrs['4']=TRUE;
                    }  
                    if($pwr['ability_id']=='5'){
                      $uuser_pwrs['5']=TRUE;
                    }                   
                  }
              }
              if($user_pwrs['1']){echo '1<br>';}
              if($user_pwrs['2']){echo '2<br>';}
              if($user_pwrs['3']){echo '3<br>';}
              if($user_pwrs['4']){echo '4<br>';}
              if($user_pwrs['5']){echo '5<br>';}
            echo '</td>
            <td>'.$user['biography'].'</td>
            <td>
              <form method="get" action="index.php">
                <input name=edit_id value='.$user['id'].' hidden>
                <input type="submit" value=Edit>
              </form>
            </td>
          </tr>';
      }
    ?>
  </table>
  <?php
  printf('Пользователи без суперспособностей: %d <br>',$pwrs_count[0]);
  printf('Пользователи с телепортацией: %d <br>',$pwrs_count[1]);
  printf('Пользователи с невидимостью: %d <br>',$pwrs_count[2]);
  printf('Пользователи с мгновенным переводом: %d <br>',$pwrs_count[3]);
  printf('Пользователи с полётом: %d <br>',$pwrs_count[4]);
  ?>
  </div>
