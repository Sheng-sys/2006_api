<?php
  
  //接口授权

  $username = $_POST['name'];
  $pwd = $_POST['pwd'];
  //print_r($_POST);
  
  //连接数据库
  include('pdo.php');
  
  //查询数据库 验证用户名密码是否匹配
  $pdo = getPdo();
  $sql = "select * from users where user_name = '$username'";
  $res = $pdo->query($sql);
  $date = $res->fetch(PDO::FETCH_ASSOC);
  
  $password = password_verify($pwd,$date['pwd']);
  if($username == $date['user_name']){
      if($pwd == $password){
          //生成token值  并保存到数据库
            $num = '1998';
            $username = 'liusheng';
            $expire = time()+86400*7;//token值保存时间
            $sha1_str = sha1($num.$username.mt_rand(1,999999).time());
            $token = substr($sha1_str,10,20);
            
            //删除原有记录
            $sql3 = "delete from p_token where uid = {$date['u_id']}"; //根据用户id删除原有记录
            $pdo->exec($sql3);
           
            //生成新数据
            $uid = $date['u_id'];//数据库里的用户id
            $sql2 = "insert into p_token (uid,token,expire) values ('$uid','$token','$expire')";//添加的sql语句
            $res2 = $pdo->query($sql2);//执行sql
            if($res2 != " "){
                $response = [
                    "errno" => "0",
                    "mgs" => "授权成功",
                    "data" => [
                        'token' => $token
                    ]   
                ];
            }
      }
  }else{
        $response = [
            "errno" => "400004",
            "mgs" => "授权失败"   
        ];
        
        echo json_encode($response);
        exit;
  }

  echo json_encode($response);

?>