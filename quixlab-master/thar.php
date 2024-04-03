<<<<<<< HEAD
<?php
require("php/connect_db.php");
//จำนวนคน
$sql_admission = "SELECT `group-name` as name, COUNT(*) as sum FROM `grade-summary` NATURAL JOIN `subject-group` GROUP BY `group-name` ORDER BY `group-name` ASC";
$admission = $conn->query($sql_admission);
$data = array();
$sum = 0;
$sliceColors =  [
  "rgba(117, 113, 249, 0.9)",
  "rgba(249, 113, 117, 0.9)",
  "rgba(113, 249, 117, 0.9)"
];
foreach ($admission as $ad) {
  array_push($data, $ad['sum']);
  $sum = $sum + $ad['sum'];
}
//GPAX
$sql_gpax = "SELECT   `group-name`,s.gid, 
round(SUM(CASE WHEN gs.`grade-alias` NOT IN ('W', 'P', 'NP') THEN gs.`grade-number` * s.`total-credits` ELSE 0 END) / SUM(CASE WHEN gs.`grade-alias` NOT IN ('W', 'P', 'NP') THEN s.`total-credits` ELSE 0 END),2) AS avg_gpax

FROM `grade-sub` as gs NATURAL JOIN subject as s NATURAL JOIN `subject-group` GROUP BY `group-name`ORDER BY avg_gpax DESC;";
$gpax = $conn->query($sql_gpax);
$data_gpax = array();
foreach ($gpax as $ad) {
  array_push($data_gpax, $ad['avg_gpax']);
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
      position: absolute;
      left: -100px;
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
          <h4 class="card-title">สัดส่วนนิสิตที่ลงทะเบียนเรียนในแต่ละหมวดหมู่รายวิชา ปี60-64</h4>
          <canvas id="pieChart" width="50" height="25"></canvas>
        </div>
        <p>หมวดการฝึกงาน: <?php echo "จำนวน " . $data[0] . " คน (" . round(($data[0] / $sum) * 100) . "%)" ?></p>
        <p>หมวดวิชาศึกษาทั่วไป: <?php echo "จำนวน " . $data[1] . " คน (" . round(($data[1] / $sum) * 100) . "%)" ?></p>
        <p>หมวดวิชาเฉพาะ: <?php echo "จำนวน " . $data[2] . " คน (" . round(($data[2] / $sum) * 100) . "%)" ?></p>
        <p>รวม: <?php echo  "จำนวน " . $sum . " คน"  ?></p>
      </div>
    </div>
    <div class="right">
      <div class="center_div ">
        <div class="card-body">
          <h4 class="card-title">เกรดเฉลี่ยรวมของนิสิตทั้งหมดในแต่ละหมวดหมู่รายวิชา ปี60-64</h4>
          <canvas id="singelBarChart" width="500" height="250"></canvas>
        </div>
        <p>หมวดการฝึกงาน: <?php echo "GPAX " . $data_gpax[0]  ?></p>
        <p>หมวดวิชาศึกษาทั่วไป: <?php echo "GPAX " . $data_gpax[1]  ?></p>
        <p>หมวดวิชาเฉพาะ: <?php echo "GPAX " . $data_gpax[2]  ?></p>
      </div>
    </div>

  </div>



  <script>
    $(document).ready(function() {
      // ใช้ข้อมูล PHP ในการกำหนดข้อมูลสำหรับกราฟ Pie Chart
      var ctx = document.getElementById("pieChart").getContext('2d');
      ctx.height = 150;
      var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
          datasets: [{
            data: <?php echo json_encode($data); ?>,
            backgroundColor: ["rgba(117, 113, 249, 0.9)",
              "rgba(249, 113, 117, 0.9)",
              "rgba(113, 249, 117, 0.9)",
            ],
            hoverBackgroundColor: ["rgba(117, 113, 249, 0.9)",
              "rgba(249, 113, 117, 0.9)",
              "rgba(113, 249, 117, 0.9)",
            ]

          }],
          labels: [
            'หมวดการฝึกงาน',
            'หมวดวิชาศึกษาทั่วไป',
            'หมวดวิชาเฉพาะ'
          ]
        },
        options: {
          responsive: true
        }
      });
    });





    var ctx = document.getElementById("singelBarChart").getContext('2d');
    ctx.height = 150;
    var myChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['หมวดการฝึกงาน', 'หมวดวิชาศึกษาทั่วไป', 'หมวดวิชาเฉพาะ'],
        datasets: [{
          data: <?php echo json_encode($data_gpax); ?>,
          borderColor: ["rgba(117, 113, 249, 0.9)",
            "rgba(249, 113, 117, 0.9)",
            "rgba(113, 249, 117, 0.9)"
          ],
          backgroundColor: ["rgba(117, 113, 249, 0.5)",
            "rgba(249, 113, 117, 0.5)",
            "rgba(113, 249, 117, 0.5)"
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

=======
<!DOCTYPE html>
<html>
<head>
<style>
body {
  margin-left: 200px;
  background: #5d9ab2 url("img_tree.png") no-repeat top left;
}

.center_div {
  border: 1px solid gray;
  margin-left: auto;
  margin-right: auto;
  width: 90%;
  background-color: #d0f0f6;
  text-align: left;
  padding: 8px;
}
</style>
</head>
<body>

<div class="center_div">
  <h1>Hello World!</h1>
  <p>This example contains some advanced CSS methods you may not have learned yet. But, we will explain these methods in a later chapter in the tutorial.</p>
</div>

</body>
>>>>>>> 0f699099dd99b4046a0eacc8e4d965e7b9f20ecd
</html>