<?php
require("php/connect_db.php");
//จำนวนคน
$sql_admission = "SELECT a.semester,  ROUND(SUM(g.`gpa-avg`) / COUNT(g.`sid`), 3) AS gpa
FROM `grade` AS g 
INNER JOIN `academic-semeter` AS a ON g.tid = a.tid
GROUP BY a.semester";
$admission = $conn->query($sql_admission);
$data = array();
$sum = 0;
$sliceColors =  [
  "rgba(249, 113, 117, 0.9)",
  "rgba(113, 249, 117, 0.9)",
  "rgba(249, 249, 117, 0.9)"
];
foreach ($admission as $ad) {
  array_push($data, $ad['gpa']);
}
//GPAX
$sql_gpax = "SELECT a.semester,  ROUND(SUM(g.`gpa-avg`) / COUNT(g.`sid`), 3) AS gpa
FROM `grade` AS g 
INNER JOIN `academic-semeter` AS a ON g.tid = a.tid
GROUP BY a.semester";
$gpax = $conn->query($sql_gpax);
$data_gpax = array();
foreach ($gpax as $ad) {
  array_push($data_gpax, $ad['gpa']);
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
$sql_gpax64 = "SELECT a.semester,  ROUND(SUM(g.`gpa-avg`) / COUNT(g.`sid`), 3) AS gpa
FROM `grade` AS g 
INNER JOIN `academic-semeter` AS a ON g.tid = a.tid
WHERE a.`academic-year` = 64
GROUP BY a.semester";
$gpax = $conn->query($sql_gpax64);
$data_gpax64 = array();
foreach ($gpax as $ad) {
  array_push($data_gpax64, $ad['gpa']);
}

//GPAX63
$sql_gpax63 = "SELECT a.semester,  ROUND(SUM(g.`gpa-avg`) / COUNT(g.`sid`), 3) AS gpa
FROM `grade` AS g 
INNER JOIN `academic-semeter` AS a ON g.tid = a.tid
WHERE a.`academic-year` = 63
GROUP BY a.semester";
$gpax = $conn->query($sql_gpax63);
$data_gpax63 = array();
foreach ($gpax as $ad) {
  array_push($data_gpax63, $ad['gpa']);
}

//GPAX62
$sql_gpax62 = "SELECT a.semester,  ROUND(SUM(g.`gpa-avg`) / COUNT(g.`sid`), 3) AS gpa
FROM `grade` AS g 
INNER JOIN `academic-semeter` AS a ON g.tid = a.tid
WHERE a.`academic-year` = 62
GROUP BY a.semester";
$gpax = $conn->query($sql_gpax62);
$data_gpax62 = array();
foreach ($gpax as $ad) {
  array_push($data_gpax62, $ad['gpa']);
}

//GPAX61
$sql_gpax61 = "SELECT a.semester,  ROUND(SUM(g.`gpa-avg`) / COUNT(g.`sid`), 3) AS gpa
FROM `grade` AS g 
INNER JOIN `academic-semeter` AS a ON g.tid = a.tid
WHERE a.`academic-year` = 61
GROUP BY a.semester";
$gpax = $conn->query($sql_gpax61);
$data_gpax61 = array();
foreach ($gpax as $ad) {
  array_push($data_gpax61, $ad['gpa']);
}

//GPAX60
$sql_gpax60 = "SELECT a.semester,  ROUND(SUM(g.`gpa-avg`) / COUNT(g.`sid`), 3) AS gpa
FROM `grade` AS g 
INNER JOIN `academic-semeter` AS a ON g.tid = a.tid
WHERE a.`academic-year` = 60
GROUP BY a.semester";
$gpax = $conn->query($sql_gpax60);
$data_gpax60 = array();
foreach ($gpax as $ad) {
  array_push($data_gpax60, $ad['gpa']);
}


?>


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
          <h4 class="card-title">เกรดเฉลี่ยรวมของแต่ภาคของนิสิตทั้งหมด</h4>
          <canvas id="singelBarChart" width="500" height="250"></canvas>
        </div>
        <p>ภาคฤดูร้อน: <?php echo "GPAX " . $data_gpax[0]  ?></p>
        <p>ภาคต้น: <?php echo "GPAX " . $data_gpax[1]  ?></p>
        <p>ภาคปลาย: <?php echo "GPAX " . $data_gpax[2]  ?></p>
        <p>ภาคการศึกษาที่เรียนแล้วได้เกรดดีคือ ภาคฤดูร้อน: <?php echo "GPAX " . $data_gpax[0]  ?></p>
      </div>

      <div class="center_div">
        <div class="card-body">
          <h4 class="card-title">เกรดเฉลี่ยรวมของแต่ละภาคของนิสิต ปี63</h4>
          <canvas id="singelBarChart63" width="500" height="250"></canvas>
        </div>
        <p>ภาคฤดูร้อน: <?php echo "GPAX " . $data_gpax63[0]  ?></p>
        <p>ภาคต้น: <?php echo "GPAX " . $data_gpax63[1]  ?></p>
        <p>ภาคปลาย: <?php echo "GPAX " . $data_gpax63[2]  ?></p>
        <p>ภาคการศึกษาที่เรียนแล้วได้เกรดดีคือ ภาคฤดูร้อน: <?php echo "GPAX " . $data_gpax63[0]  ?></p>
      </div>
      <div class="center_div">
        <div class="card-body">
          <h4 class="card-title">เกรดเฉลี่ยรวมของแต่ละภาคของนิสิต ปี61</h4>
          <canvas id="singelBarChart61" width="500" height="250"></canvas>
        </div>
        <p>ภาคฤดูร้อน: <?php echo "GPAX " . $data_gpax61[0]  ?></p>
        <p>ภาคต้น: <?php echo "GPAX " . $data_gpax61[1]  ?></p>
        <p>ภาคปลาย: <?php echo "GPAX " . $data_gpax61[2]  ?></p>
        <p>ภาคการศึกษาที่เรียนแล้วได้เกรดดีคือ ภาคฤดูร้อน: <?php echo "GPAX " . $data_gpax61[0]  ?></p>
      </div>
      
    </div>
    <div class="right">
      <div class="center_div">
        <div class="card-body">
          <h4 class="card-title">เกรดเฉลี่ยรวมของแต่ละภาคของนิสิต ปี64</h4>
          <canvas id="singelBarChart64" width="500" height="250"></canvas>
        </div>
        <p>ภาคฤดูร้อน: <?php echo "GPAX " . $data_gpax64[0]  ?></p>
        <p>ภาคต้น: <?php echo "GPAX " . $data_gpax64[1]  ?></p>
        <p>ภาคปลาย: <?php echo "GPAX " . $data_gpax64[2]  ?></p>
        <p>ภาคการศึกษาที่เรียนแล้วได้เกรดดีคือ ภาคฤดูร้อน: <?php echo "GPAX " . $data_gpax64[0]  ?></p>
      </div>
      <div class="center_div">
        <div class="card-body">
          <h4 class="card-title">เกรดเฉลี่ยรวมของแต่ละภาคของนิสิต ปี62</h4>
          <canvas id="singelBarChart62" width="500" height="250"></canvas>
        </div>
        <p>ภาคฤดูร้อน: <?php echo "GPAX " . $data_gpax62[0]  ?></p>
        <p>ภาคต้น: <?php echo "GPAX " . $data_gpax62[1]  ?></p>
        <p>ภาคปลาย: <?php echo "GPAX " . $data_gpax62[2]  ?></p>
        <p>ภาคการศึกษาที่เรียนแล้วได้เกรดดีคือ ภาคปลาย: <?php echo "GPAX " . $data_gpax62[0]  ?></p>
      </div>
      <div class="center_div">
        <div class="card-body">
          <h4 class="card-title">เกรดเฉลี่ยรวมของแต่ละภาคของนิสิต ปี60</h4>
          <canvas id="singelBarChart60" width="500" height="250"></canvas>
        </div>
        <p>ภาคต้น: <?php echo "GPAX " . $data_gpax60[0]  ?></p>
        <p>ภาคปลาย: <?php echo "GPAX " . $data_gpax60[1]  ?></p>
        <p>ภาคการศึกษาที่เรียนแล้วได้เกรดดีคือ ภาคปลาย: <?php echo "GPAX " . $data_gpax60[1]  ?></p>
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
              backgroundColor: [
                "rgba(249, 113, 117, 0.9)",
                "rgba(113, 249, 117, 0.9)",
                "rgba(249, 249, 117, 0.9)"
              ],
              hoverBackgroundColor: [
                "rgba(249, 113, 117, 0.9)",
                "rgba(113, 249, 117, 0.9)",
                "rgba(249, 249, 117, 0.9)"
              ]

            }],
            labels: [
              'รอบ 1',
              'รอบ 2',
              'รอบ 3'
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
          labels: ['ภาคฤดูร้อน', 'ภาคต้น', 'ภาคปลาย'],
          datasets: [{
            data: <?php echo json_encode($data_gpax); ?>,
            borderColor: [
              "rgba(249, 113, 117, 0.9)",
              "rgba(113, 249, 117, 0.9)",
              "rgba(249, 249, 117, 0.9)"
            ],
            backgroundColor: [
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
            labels: ['ภาคฤดูร้อน', 'ภาคต้น', 'ภาคปลาย']
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
          labels: ['ภาคฤดูร้อน', 'ภาคต้น', 'ภาคปลาย'],
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

      var ctx = document.getElementById("singelBarChart63").getContext('2d');
      ctx.height = 150;
      var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: ['ภาคฤดูร้อน', 'ภาคต้น', 'ภาคปลาย'],
          datasets: [{
            data: <?php echo json_encode($data_gpax63); ?>,
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

      var ctx = document.getElementById("singelBarChart62").getContext('2d');
      ctx.height = 150;
      var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: ['ภาคฤดูร้อน', 'ภาคต้น', 'ภาคปลาย'],
          datasets: [{
            data: <?php echo json_encode($data_gpax62); ?>,
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

      var ctx = document.getElementById("singelBarChart61").getContext('2d');
      ctx.height = 150;
      var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: ['ภาคฤดูร้อน', 'ภาคต้น', 'ภาคปลาย'],
          datasets: [{
            data: <?php echo json_encode($data_gpax61); ?>,
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

      var ctx = document.getElementById("singelBarChart60").getContext('2d');
      ctx.height = 150;
      var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: [ 'ภาคต้น', 'ภาคปลาย'],
          datasets: [{
            data: <?php echo json_encode($data_gpax60); ?>,
            borderColor: [
              "rgba(249, 113, 117, 0.9)",
              "rgba(113, 249, 117, 0.9)",
            ],
            backgroundColor: [
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