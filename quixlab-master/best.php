<?php
require("php/connect_db.php");
//grade ในแต่ละgrouptype 
$sql_grouptype = "SELECT SUM(gs.gpax)/COUNT(gs.gpax) as grade ,sg.`group-type` as grouptype FROM `grade-summary` AS gs INNER JOIN `subject-group` AS sg ON gs.gid = sg.gid GROUP BY sg.`group-type`;";
$grouptype = $conn->query($sql_grouptype);
$data = array();
$sum = 0;

foreach ($grouptype as $ad) {
    array_push($data, $ad['grade']);
    $sum = $sum + $ad['grade'];
}
//grade ในแต่ละgrouptype ของนิสิต64
$sql_gpax64 = "SELECT SUM(gs.gpax)/COUNT(gs.gpax) as grade ,sg.`group-type`  as grouptype FROM `grade-summary` AS gs 
INNER JOIN `subject-group` AS sg ON gs.gid = sg.gid 
INNER JOIN `student` AS st ON st.sid = gs.sid 
WHERE st.`start-year` = 64
GROUP BY sg.`group-type`;";
$sum64 = 0;
$gpax64 = $conn->query($sql_gpax64);
$data64 = array();
foreach ($gpax64 as $ad) {
  array_push($data64, $ad['grade']);
  $sum64 = $sum64 + $ad['grade'];
}

//grade ในแต่ละgrouptype ของนิสิต63
$sql_gpax63 = "SELECT SUM(gs.gpax)/COUNT(gs.gpax) as grade ,sg.`group-type`  as grouptype FROM `grade-summary` AS gs 
INNER JOIN `subject-group` AS sg ON gs.gid = sg.gid 
INNER JOIN `student` AS st ON st.sid = gs.sid 
WHERE st.`start-year` = 63
GROUP BY sg.`group-type`;";
$sum63 = 0;
$gpax63 = $conn->query($sql_gpax63);
$data63 = array();
foreach ($gpax63 as $ad) {
  array_push($data63, $ad['grade']);
  $sum63 = $sum63 + $ad['grade'];
}

//grade ในแต่ละgrouptype ของนิสิต62
$sql_gpax62 = "SELECT SUM(gs.gpax)/COUNT(gs.gpax) as grade ,sg.`group-type`  as grouptype FROM `grade-summary` AS gs 
INNER JOIN `subject-group` AS sg ON gs.gid = sg.gid 
INNER JOIN `student` AS st ON st.sid = gs.sid 
WHERE st.`start-year` = 62
GROUP BY sg.`group-type`;";
$sum62 = 0;
$gpax62 = $conn->query($sql_gpax62);
$data62 = array();
foreach ($gpax62 as $ad) {
    array_push($data62, $ad['grade']);
    $sum62 = $sum62 + $ad['grade'];
}
?>



<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Quixlab - Bootstrap Admin Dashboard Template by Themefisher.com</title>
  <!-- Favicon icon -->
  <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
  <!-- Custom Stylesheet -->
  <link href="css/style.css" rel="stylesheet">
  <style>
    body {
      margin: 0;
      padding: 0;
      background: #5d9ab2 url("img_tree.png") no-repeat top left;
    }

    .container {
      display: flex;
      justify-content: space-between;
      margin-left: 200px;
      margin-right: 200px;
    }

    .center_div {
      display: flex;
      flex-direction: column;
      align-items: center;
      border: 1px solid gray;
      margin-left: auto;
      margin-right: auto;
      width: 90%;
      background-color: #d0f0f6;
      text-align: left;
      padding: 8px;
    }

    .left {
      width: 50%;
      padding: 10px;
      background-color: #d0f0f6;
    }

    .right {
      width: 50%;
      padding: 10px;
      background-color: #d0f0f6;
    }

    canvas {
      width: 250px;
      /* ปรับขนาดตามความต้องการ */
      height: 250px;
      /* ปรับขนาดตามความต้องการ */
    }
  </style>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body>
  <div class="container">
    <div class="left">
    
      <div class="center_div">
        <div class="card-body">
          <h4 class="card-title">เกรดเฉลี่ยรวมเทียบกับวิชาในภาค,ในคณะ,นอกคณะ</h4>
          <canvas id="singelBarChart" width="500" height="250"></canvas>
        </div>
        <p>วิชาในภาค <?php echo "GPAX " . $data[0]  ?></p>
        <p>วิชาในคณะ <?php echo "GPAX " . $data[1]  ?></p>
        <p>วิชานอกคณะ <?php echo "GPAX " . $data[2]  ?></p>
        <p>รวม: <?php echo  "จำนวนGPAX " . $sum . ""  ?></p>
        <p>นิสิตเรียนวิชาในคณะได้ดีที่สุด<?php echo  "โดยจำนวนGPAX " . $data[1] . ""  ?></p>
      </div>

      <div class="center_div">
        <div class="card-body">
          <h4 class="card-title">เกรดเฉลี่ยรวมเทียบกับวิชาในภาค,ในคณะ,นอกคณะปี64</h4>
          <canvas id="singelBarChart1" width="500" height="250"></canvas>
        </div>
        <p>วิชาในภาค <?php echo "GPAX " . $data64[0]  ?></p>
        <p>วิชาในคณะ <?php echo "GPAX " . $data64[1]  ?></p>
        <p>วิชานอกคณะ <?php echo "GPAX " . $data64[2]  ?></p>
        <p>รวม: <?php echo  "จำนวนGPAX " . $sum64 . ""  ?></p>
        <p>นิสิตเรียนวิชาในคณะได้ดีที่สุด<?php echo  "โดยจำนวนGPAX " . $data64[1] . ""  ?></p>
      </div>
    </div>
    <div class="right">
      <div class="center_div">
        <div class="card-body">
          <h4 class="card-title">เกรดเฉลี่ยรวมเทียบกับวิชาในภาค,ในคณะ,นอกคณะปี63</h4>
          <canvas id="singelBarChart2" width="500" height="250"></canvas>
        </div>
        <p>วิชาในภาค <?php echo "GPAX " . $data63[0]  ?></p>
        <p>วิชาในคณะ <?php echo "GPAX " . $data63[1]  ?></p>
        <p>วิชานอกคณะ <?php echo "GPAX " . $data63[2]  ?></p>
        <p>รวม: <?php echo  "จำนวนGPAX " . $sum63 . ""  ?></p>
        <p>นิสิตเรียนวิชาในคณะได้ดีที่สุด<?php echo  "โดยจำนวนGPAX " . $data63[1] . ""  ?></p>
      </div>
      <div class="center_div">
        <div class="card-body">
          <h4 class="card-title">เกรดเฉลี่ยรวมเทียบกับวิชาในภาค,ในคณะ,นอกคณะปี62</h4>
          <canvas id="singelBarChart3" width="500" height="250"></canvas>
        </div>
        <p>วิชาในภาค <?php echo "GPAX " . $data62[0]  ?></p>
        <p>วิชาในคณะ <?php echo "GPAX " . $data62[1]  ?></p>
        <p>วิชานอกคณะ <?php echo "GPAX " . $data62[2]  ?></p>
        <p>รวม: <?php echo  "จำนวนGPAX " . $sum62 . ""  ?></p>
        <p>นิสิตเรียนวิชาในคณะได้ดีที่สุด<?php echo  "โดยจำนวนGPAX " . $data62[1] . ""  ?></p>
      </div>
    </div>

    <script>
        //เกรดเฉลี่ยรวมเทียบกับวิชาในภาค,ในคณะ,นอกคณะ
      var ctx = document.getElementById("singelBarChart").getContext('2d');
      ctx.height = 150;
      var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: ['วิชาในภาค ', 'วิชาในคณะ ', 'วิชานอกคณะ '],
          datasets: [{
            data: <?php echo json_encode($data); ?>,
            borderColor: ["rgba(117, 113, 249, 0.9)",
              "rgba(249, 113, 117, 0.9)",
              "rgba(113, 249, 117, 0.9)",
              "rgba(249, 249, 117, 0.9)"
            ],
            backgroundColor: ["rgba(117, 113, 249, 0.5)",
              "rgba(249, 113, 117, 0.5)",
              "rgba(113, 249, 117, 0.5)",
              "rgba(249, 249, 117, 0.5)"
            ],
            borderWidth: "0",
          }]
        },

        options: {
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: true
              }
            }]
          }
        }
      });
      //เกรดเฉลี่ยรวมเทียบกับวิชาในภาค,ในคณะ,นอกคณะ 64
      var ctx = document.getElementById("singelBarChart1").getContext('2d');
      ctx.height = 150;
      var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: ['วิชาในภาค ', 'วิชาในคณะ ', 'วิชานอกคณะ '],
          datasets: [{
            data: <?php echo json_encode($data64); ?>,
            borderColor: ["rgba(117, 113, 249, 0.9)",
              "rgba(249, 113, 117, 0.9)",
              "rgba(113, 249, 117, 0.9)",
              "rgba(249, 249, 117, 0.9)"
            ],
            backgroundColor: ["rgba(117, 113, 249, 0.5)",
              "rgba(249, 113, 117, 0.5)",
              "rgba(113, 249, 117, 0.5)",
              "rgba(249, 249, 117, 0.5)"
            ],
            borderWidth: "0",
          }]
        },

        options: {
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: true
              }
            }]
          }
        }
      });

      //เกรดเฉลี่ยรวมเทียบกับวิชาในภาค,ในคณะ,นอกคณะ 63
      var ctx = document.getElementById("singelBarChart2").getContext('2d');
      ctx.height = 150;
      var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: ['วิชาในภาค ', 'วิชาในคณะ ', 'วิชานอกคณะ '],
          datasets: [{
            data: <?php echo json_encode($data63); ?>,
            borderColor: ["rgba(117, 113, 249, 0.9)",
              "rgba(249, 113, 117, 0.9)",
              "rgba(113, 249, 117, 0.9)",
              "rgba(249, 249, 117, 0.9)"
            ],
            backgroundColor: ["rgba(117, 113, 249, 0.5)",
              "rgba(249, 113, 117, 0.5)",
              "rgba(113, 249, 117, 0.5)",
              "rgba(249, 249, 117, 0.5)"
            ],
            borderWidth: "0",
          }]
        },

        options: {
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: true
              }
            }]
          }
        }
      });

      //เกรดเฉลี่ยรวมเทียบกับวิชาในภาค,ในคณะ,นอกคณะ 62
      var ctx = document.getElementById("singelBarChart3").getContext('2d');
      ctx.height = 150;
      var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: ['วิชาในภาค ', 'วิชาในคณะ ', 'วิชานอกคณะ '],
          datasets: [{
            data: <?php echo json_encode($data62); ?>,
            borderColor: ["rgba(117, 113, 249, 0.9)",
              "rgba(249, 113, 117, 0.9)",
              "rgba(113, 249, 117, 0.9)",
              "rgba(249, 249, 117, 0.9)"
            ],
            backgroundColor: ["rgba(117, 113, 249, 0.5)",
              "rgba(249, 113, 117, 0.5)",
              "rgba(113, 249, 117, 0.5)",
              "rgba(249, 249, 117, 0.5)"
            ],
            borderWidth: "0",
          }]
        },

        options: {
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: true
              }
            }]
          }
        }
      });
    </script>
</body>

</html>