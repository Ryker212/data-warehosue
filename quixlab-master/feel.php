<?php
require("php/connect_db.php");
$sql_admission = "SELECT `s`.`accession-no`,COUNT(`s`.`sid`)as sum FROM student as s 
    GROUP by `s`.`accession-no`";
$admission = $conn->query($sql_admission);
$data = array();
$sum = 0;
$sliceColors = ["#D70206", "#002BFF", "#1FFF00", "#FF9E00"];
foreach ($admission as $ad) {
  array_push($data, $ad['sum']);
  $sum = $sum + $ad['sum'];
}
?>



<!DOCTYPE html>
<html>

<head>
  <style>
    body {
      margin-left: 200px;
      background: #5d9ab2 url("img_tree.png") no-repeat top left;
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

    .color-legend {
      list-style-type: none;
      padding: 0;
      display: flex;
      align-items: center;
    }

    .legend-color1 {
      width: 10px;
      height: 10px;
      margin-right: 3px;
      border-radius: 8px;
      border: 10px solid #D70206;
      /* เพิ่มเส้นขอบสีเทาสำหรับความเป็นระเบียบ */
    }

    .legend-color2 {
      width: 10px;
      height: 10px;
      margin-right: 3px;
      border-radius: 8px;
      border: 10px solid #002BFF;
      /* เพิ่มเส้นขอบสีเทาสำหรับความเป็นระเบียบ */
    }

    .legend-color3 {
      width: 10px;
      height: 10px;
      margin-right: 3px;
      border-radius: 8px;
      border: 10px solid #1FFF00;
      /* เพิ่มเส้นขอบสีเทาสำหรับความเป็นระเบียบ */
    }

    .legend-color4 {
      width: 10px;
      height: 10px;
      margin-right: 3px;
      border-radius: 8px;
      border: 10px solid #FF9E00;
      /* เพิ่มเส้นขอบสีเทาสำหรับความเป็นระเบียบ */
    }
  </style>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-sparklines/2.1.2/jquery.sparkline.min.js"></script>
</head>

<body>
  <div class="center_div">
    <h4>สักส่วนนิสิตที่เข้าศึกษาในแต่ละรอบทั้งหมด</h4>
    <div id="sparkline1" style="display:inline-block;"></div>
    <ul class="color-legend">
      <li><span class='legend-color1'></span>รอบ 1</li>
      <li><span class='legend-color2'></span>รอบ 2</li>
      <li><span class='legend-color3'></span>รอบ 3</li>
      <li><span class='legend-color4'></span>รอบ 4</li>
    </ul>
    <p>รอบ 1: <?php echo "จำนวน " . $data[0] . " คน (" . round(($data[0] / $sum) * 100) . "%)" ?></p>
    <p>รอบ 2: <?php echo "จำนวน " . $data[1] . " คน (" . round(($data[1] / $sum) * 100) . "%)" ?></p>
    <p>รอบ 3: <?php echo "จำนวน " . $data[2] . " คน (" . round(($data[2] / $sum) * 100) . "%)" ?></p>
    <p>รอบ 4: <?php echo "จำนวน " . $data[3] . " คน (" . round(($data[3] / $sum) * 100) . "%)" ?></p>
    <p>รวม: <?php echo  "จำนวน ".$sum." คน"  ?></p>
  </div>


  <script>
    $(document).ready(function() {
      // ใช้ข้อมูล PHP ในการกำหนดข้อมูลสำหรับกราฟ Pie Chart
      $("#sparkline1").sparkline(<?php echo json_encode($data); ?>, {
        type: "pie",
        height: "200",
        resize: true,
        sliceColors: <?php echo json_encode($sliceColors); ?>,
      });
      $("#sparkline2").sparkline(<?php echo json_encode($data); ?>, {
        type: "pie",
        height: "200",
        resize: true,
        sliceColors: <?php echo json_encode($sliceColors); ?>,
      });
    });
  </script>
</body>

</html>