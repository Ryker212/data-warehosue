<?php
require("php/connect_db.php");
//จำนวนคน
$sql_start = "SELECT `s`.`start-year`,COUNT(`s`.`sid`)as sum FROM student as s 
    GROUP by `s`.`start-year`";
$start = $conn->query($sql_start);
$data = array();
$sum = 0;
$sliceColors =  [
  "rgba(117, 113, 249, 0.9)",
  "rgba(249, 113, 117, 0.9)",
  "rgba(113, 249, 117, 0.9)",
  "rgba(249, 249, 117, 0.9)",
  "rgba(153, 102, 255, 0.2)"
];
foreach ($start as $ad) {
  array_push($data, $ad['sum']);
  $sum = $sum + $ad['sum'];
}
//GPAX
$sql_gpax = "SELECT `academic-year`, AVG(`gpax`) AS `average_gpax`
FROM (
    SELECT `gs`.`sid`, `gs`.`tid`, `gs`.`gpax`, `asy`.`academic-year`
    FROM `grade-summary` `gs`
    INNER JOIN `academic-semeter` `asy` ON `gs`.`tid` = `asy`.`tid`
) AS `subquery`
WHERE `academic-year` IN (60, 61, 62, 63, 64)
GROUP BY `academic-year`";
$gpax = $conn->query($sql_gpax);
$data_gpax = array();
foreach ($gpax as $ad) {
  array_push($data_gpax, $ad['average_gpax']);
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
          <h4 class="card-title">จำนวนนิสิตที่เข้าศึกษาในแต่ละปีการศึกษา</h4>
          <canvas id="pieChart" width="50" height="25"></canvas>
        </div>
        <p>ปี 2560: <?php echo "จำนวน " . $data[0] . " คน (" . round(($data[0] / $sum) * 100) . "%)" ?></p>
        <p>ปี 2561: <?php echo "จำนวน " . $data[1] . " คน (" . round(($data[1] / $sum) * 100) . "%)" ?></p>
        <p>ปี 2562: <?php echo "จำนวน " . $data[2] . " คน (" . round(($data[2] / $sum) * 100) . "%)" ?></p>
        <p>ปี 2563: <?php echo "จำนวน " . $data[3] . " คน (" . round(($data[3] / $sum) * 100) . "%)" ?></p>
        <p>ปี 2564: <?php echo "จำนวน " . $data[4] . " คน (" . round(($data[3] / $sum) * 100) . "%)" ?></p>
        <p>รวม: <?php echo  "จำนวน " . $sum . " คน"  ?></p>
      </div>
      <div class="center_div">
        <div class="card-body">
          <h4 class="card-title">เกรดเฉลี่ยรวมของแต่ละปีการศึกษาของนิสิตทั้งหมด</h4>
          <canvas id="singelBarChart" width="500" height="250"></canvas>
        </div>
        <p>ปี 2560: <?php echo "GPAX " . $data_gpax[0]  ?></p>
        <p>ปี 2561: <?php echo "GPAX " . $data_gpax[1]  ?></p>
        <p>ปี 2562: <?php echo "GPAX " . $data_gpax[2]  ?></p>
        <p>ปี 2563: <?php echo "GPAX " . $data_gpax[3]  ?></p>
        <p>ปี 2564: <?php echo "GPAX " . $data_gpax[4]  ?></p>
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
                "rgba(249, 249, 117, 0.9)",
                "rgba(153, 102, 255, 0.2)"
              ],
              hoverBackgroundColor: ["rgba(117, 113, 249, 0.9)",
                "rgba(249, 113, 117, 0.9)",
                "rgba(113, 249, 117, 0.9)",
                "rgba(249, 249, 117, 0.9)",
                "rgba(153, 102, 255, 1)"
              ]

            }],
            labels: [
              'ปี 2560',
              'ปี 2561',
              'ปี 2562',
              'ปี 2563',
              'ปี 2564'
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
          labels: ['ปี 2560', 'ปี 2561', 'ปี 2562', 'ปี 2563' , 'ปี 2564'],
          datasets: [{
            data: <?php echo json_encode($data_gpax); ?>,
            borderColor: ["rgba(117, 113, 249, 0.9)",
              "rgba(249, 113, 117, 0.9)",
              "rgba(113, 249, 117, 0.9)",
              "rgba(249, 249, 117, 0.9)",
              "rgba(153, 102, 255, 0.2)"
            ],
            backgroundColor: ["rgba(117, 113, 249, 0.5)",
              "rgba(249, 113, 117, 0.5)",
              "rgba(113, 249, 117, 0.5)",
              "rgba(249, 249, 117, 0.5)",
              "rgba(153, 102, 255, 1)"
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