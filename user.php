<?php
   
   //判断是否有token参数
   if(empty($_GET['token'])){
       $response = [
           "errno" => "400005",
           "mgs" => "缺少token参数"
       ];

       echo json_encode($response,JSON_UNESCAPED_UNICODE);
       exit;
   }
   
   $token = $_GET['token'];//接收token值

   //验证token参数
   include('pdo.php');
   $pdo = getPdo();
   $sql = "select * from p_token where token = '$token'";//根据token参数查询数据
   $res = $pdo->query($sql);
   $date = $res->fetch(PDO::FETCH_ASSOC);

   if($date && time()<$date['expire']){
       $sql2 = "select * from users where u_id = {$date['uid']}";//根据p_token表中的uid(用户id)查询users(用户表)的用户账号信息
       $res2 = $pdo->query($sql2);
       $row = $res2->fetch(PDO::FETCH_ASSOC);
     
       $response = [
            "errno" => "0",
            "mgs" => "获取用户信息成功",
            "data" => [
                'userinfo' => $row
            ]
       ];
   }else{
       $response = [
            "errno" => "400006",
            "mgs" => "获取失败"
       ];
    
       echo json_encode($response,JSON_UNESCAPED_UNICODE);
       exit;
   }

   echo json_encode($response);
?>