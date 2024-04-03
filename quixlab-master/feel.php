<?php
require("php/connect_db.php");
//จำนวนคน
$sql_admission = "SELECT `s`.`accession-no`,COUNT(`s`.`sid`)as sum FROM student as s 
    GROUP by `s`.`accession-no`";
$admission = $conn->query($sql_admission);
$data = array();
$sum = 0;
$sliceColors =  [
  "rgba(117, 113, 249, 0.9)",
  "rgba(249, 113, 117, 0.9)",
  "rgba(113, 249, 117, 0.9)",
  "rgba(249, 249, 117, 0.9)"
];
foreach ($admission as $ad) {
  array_push($data, $ad['sum']);
  $sum = $sum + $ad['sum'];
}
//GPAX
$sql_gpax = "SELECT `s`.`accession-no`as ad,ROUND(SUM(g.`gpax-avg`) / COUNT(g.`sid`), 3) AS avg_gpax FROM `grade`as g INNER JOIN (SELECT g.sid as sid,max(g.tid) as max_tid FROM grade as g GROUP by g.sid)as max ON g.tid = max.max_tid AND g.sid = max.sid 
INNER JOIN student as s ON s.sid = g.sid GROUP by `s`.`accession-no`;";
$gpax = $conn->query($sql_gpax);
$data_gpax = array();
foreach ($gpax as $ad) {
  array_push($data_gpax, $ad['avg_gpax']);
}

//จำนวน64
$sql_admission64 = "SELECT `s`.`accession-no`,COUNT(`s`.`sid`)as sum FROM student as s 
WHERE `s`.`start-year` = 64
GROUP by `s`.`accession-no`";
$admission64 = $conn->query($sql_admission64);
$data64 = array();
$sum64 = 0;
$sliceColors =  [
  "rgba(117, 113, 249, 0.9)",
  "rgba(249, 113, 117, 0.9)",
  "rgba(113, 249, 117, 0.9)",
  "rgba(249, 249, 117, 0.9)"
];
foreach ($admission64 as $ad) {
  array_push($data64, $ad['sum']);
  $sum64 = $sum64 + $ad['sum'];
}
//GPAX64
$sql_gpax64 = "SELECT `s`.`accession-no`as ad,ROUND(SUM(g.`gpax-avg`) / COUNT(g.`sid`), 3) AS avg_gpax FROM `grade`as g INNER JOIN (SELECT g.sid as sid,max(g.tid) as max_tid FROM grade as g GROUP by g.sid)as max ON g.tid = max.max_tid AND g.sid = max.sid 
INNER JOIN student as s ON s.sid = g.sid 
WHERE `s`.`start-year` = 64
GROUP by `s`.`accession-no`";
$gpax = $conn->query($sql_gpax64);
$data_gpax64 = array();
foreach ($gpax as $ad) {
  array_push($data_gpax64, $ad['avg_gpax']);
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
          <h4 class="card-title">สักส่วนนิสิตที่เข้าศึกษาในแต่ละรอบทั้งหมด</h4>
          <canvas id="pieChart" width="50" height="25"></canvas>
        </div>
        <p>รอบ 1: <?php echo "จำนวน " . $data[0] . " คน (" . round(($data[0] / $sum) * 100) . "%)" ?></p>
        <p>รอบ 2: <?php echo "จำนวน " . $data[1] . " คน (" . round(($data[1] / $sum) * 100) . "%)" ?></p>
        <p>รอบ 3: <?php echo "จำนวน " . $data[2] . " คน (" . round(($data[2] / $sum) * 100) . "%)" ?></p>
        <p>รอบ 4: <?php echo "จำนวน " . $data[3] . " คน (" . round(($data[3] / $sum) * 100) . "%)" ?></p>
        <p>รวม: <?php echo  "จำนวน " . $sum . " คน"  ?></p>
      </div>
      <div class="center_div">
        <div class="card-body">
          <h4 class="card-title">เกรดเฉลี่ยรวมของแต่ละรอบของนิสิตทั้งหมด</h4>
          <canvas id="singelBarChart" width="500" height="250"></canvas>
        </div>
        <p>รอบ 1: <?php echo "GPAX " . $data_gpax[0]  ?></p>
        <p>รอบ 2: <?php echo "GPAX " . $data_gpax[1]  ?></p>
        <p>รอบ 3: <?php echo "GPAX " . $data_gpax[2]  ?></p>
        <p>รอบ 4: <?php echo "GPAX " . $data_gpax[3]  ?></p>
      </div>
    </div>
    <div class="right">
      <div class="center_div">
        <div class="card-body">
          <h4 class="card-title">สักส่วนนิสิตที่เข้าศึกษาในแต่ละรอบ ปี64</h4>
          <canvas id="pieChart64" width="50" height="25"></canvas>
        </div>
        <p>รอบ 1: <?php echo "จำนวน " . $data64[0] . " คน (" . round(($data64[0] / $sum64) * 100) . "%)" ?></p>
        <p>รอบ 2: <?php echo "จำนวน " . $data64[1] . " คน (" . round(($data64[1] / $sum64) * 100) . "%)" ?></p>
        <p>รอบ 3: <?php echo "จำนวน " . $data64[2] . " คน (" . round(($data64[2] / $sum64) * 100) . "%)" ?></p>
        <p>รวม: <?php echo  "จำนวน " . $sum64 . " คน"  ?></p>
      </div>
      <div class="center_div">
        <div class="card-body">
          <h4 class="card-title">เกรดเฉลี่ยรวมของแต่ละรอบของนิสิต ปี64</h4>
          <canvas id="singelBarChart64" width="500" height="250"></canvas>
        </div>
        <p>รอบ 1: <?php echo "GPAX " . $data_gpax64[0]  ?></p>
        <p>รอบ 2: <?php echo "GPAX " . $data_gpax64[1]  ?></p>
        <p>รอบ 3: <?php echo "GPAX " . $data_gpax64[2]  ?></p>
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
                "rgba(249, 249, 117, 0.9)"
              ],
              hoverBackgroundColor: ["rgba(117, 113, 249, 0.9)",
                "rgba(249, 113, 117, 0.9)",
                "rgba(113, 249, 117, 0.9)",
                "rgba(249, 249, 117, 0.9)"
              ]

            }],
            labels: [
              'รอบ 1',
              'รอบ 2',
              'รอบ 3',
              'รอบ 4'
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
          labels: ['รอบ 1', 'รอบ 2', 'รอบ 3', 'รอบ 4'],
          datasets: [{
            data: <?php echo json_encode($data_gpax); ?>,
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


      //64
      $(document).ready(function() {
        // ใช้ข้อมูล PHP ในการกำหนดข้อมูลสำหรับกราฟ Pie Chart
        var ctx = document.getElementById("pieChart64").getContext('2d');
        ctx.height = 150;
        var myChart = new Chart(ctx, {
          type: 'pie',
          data: {
            datasets: [{
              data: <?php echo json_encode($data64); ?>,
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
              'รอบ 1',
              'รอบ 2',
              'รอบ 3',
            ]
          },
          options: {
            responsive: true
          }
        });
      });

      var ctx = document.getElementById("singelBarChart64").getContext('2d');
      ctx.height = 150;
      var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: ['รอบ 1', 'รอบ 2', 'รอบ 3'],
          datasets: [{
            data: <?php echo json_encode($data_gpax64); ?>,
            borderColor: ["rgba(117, 113, 249, 0.9)",
              "rgba(249, 113, 117, 0.9)",
              "rgba(113, 249, 117, 0.9)",
            ],
            backgroundColor: ["rgba(117, 113, 249, 0.5)",
              "rgba(249, 113, 117, 0.5)",
              "rgba(113, 249, 117, 0.5)",
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