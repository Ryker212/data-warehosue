<?php
require("php/connect_db.php");

//GPAX
$sql_gpax = "SELECT `student`.`gender`,AVG(`gpax`) as `avggrade` 
FROM `grade-summary` as `gs` Inner JOIN `student` ON `gs`.`sid`=`student`.`sid` 
group by `gender`;";
$gpax = $conn->query($sql_gpax);
$data_gpax = array();
foreach ($gpax as $ad) {
  array_push($data_gpax, $ad['avggrade']);
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
          <h4 class="card-title">เกรดเฉลี่ยรวมของเพศหญิงและชาย</h4>
          <canvas id="singelBarChart" width="500" height="250"></canvas>
        </div>
        <p>หญิง: <?php echo "GPAX " . $data_gpax[0]  ?></p>
        <p>ชาย: <?php echo "GPAX " . $data_gpax[1]  ?></p>
      </div>
    </div>


    <script>


      var ctx = document.getElementById("singelBarChart").getContext('2d');
      ctx.height = 150;
      var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: ['หญิง', 'ชาย'],
          datasets: [{
            data: <?php echo json_encode($data_gpax); ?>,
            borderColor: ["rgba(117, 113, 249, 0.9)",
              "rgba(249, 113, 117, 0.9)"
            ],
            backgroundColor: ["rgba(117, 113, 249, 0.5)",
              "rgba(249, 113, 117, 0.5)"
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