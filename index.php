<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>朝礼タイトル|PHP試作</title>
</head>
<body>
  <h2 style="text-align:center">朝礼タイトル（自動生成）</h2>
  <section 
  style="
    max-width:26rem;
    background-color:azure;
    margin:0 auto;
    padding: 1rem;
  ">
    <?php
    // 初期値設定
      $year = '';
      $month = '';
      $day = '23';

      $year = $year ? $year : date("Y");
      $month = $month ? $month : date("m");
      $day = $day ? $day : date("d");

      $api = 'https://koyomi.zingsystem.com/api/';
      $param = array(
        'mode' => "d"
      ,'cnt'  => "1"
      ,'targetyyyy' => $year
      ,'targetmm' => $month
      ,'targetdd' => $day
      );

      $ch = curl_init($api);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

      curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($param));

      $result = curl_exec($ch);
      curl_close($ch);

      $data = json_decode($result, true);
      $date = $data['datelist'][date($year."-".$month."-".$day)];
      // $date = $data['datelist'][date("Y-m-d")];

      # 今日の曜日
      $yostr='日月火水木金土';
      $yo = mb_substr($yostr,date("w"),1);

      # 挨拶文を自動出力
      
      $mydate = mktime(0,0,0,$month,$day,$year);// 表示用年月日に整形
      $sekki = $date['sekki'] ? "◆".$date['sekki'] : "";//二十四節気を設定

      $message = '🐯 おはようございます！ 🐯'
                  ."<br> --- "
                  .$year
                  .'('.$date['gengo'].$date['wareki']
                  .')年'
                  .date("n",$mydate).'月'
                  .date("j",$mydate).'日('.$yo.')'
                  .$date['rokuyou']
                  .$sekki
                  .' ---';
      echo $message;
      
  ?>
  </section>
  <p  style="
    max-width:26rem;
    color: red;
    text-align:right;
    margin:0 auto;
    padding: 1.6rem;
  ">💓現在試験運用中です</p>
 </body>
</html>