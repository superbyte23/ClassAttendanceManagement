<?php require 'include/header.php';
include 'include/config.php';
if (isset($_POST['addclass'])) {
        $student_id = $_POST['student_id'];

        $check_student = mysqli_query($conn,"SELECT * FROM `tbl_class_member` WHERE `class_id` = ".$_GET['id']." AND `student_id` = '$student_id' ");
        if (mysqli_num_rows($check_student)>0) {
            header("location: class.php?id=".$_GET['id']."&error");
        }else{
            $query = "INSERT INTO `tbl_class_member`(`class_id`, `student_id`) VALUES ('".$_GET['id']."','$student_id')";
            $result = mysqli_query($conn, $query);
            if ($result) {
                header("location: class.php?id=".$_GET['id']."&success");
            }else{
                header("location: class.php?id=".$_GET['id']."&error");
            }
        }

        
    }
$class = mysqli_query($conn, "SELECT * FROM `tbl_class` WHERE `class_id` =".$_GET['id']);
$res = mysqli_num_rows($class);
while ($row = mysqli_fetch_assoc($class)) {
    $class_name = $row['class_name'];
    $class_schedule = $row['class_schedule'];   
    $class_desc = $row['class_desc'];
    
}
?> 
    <body class="">
    <div class="page">
        <div class="page-main">
        <?php require 'include/topbar.php'; ?> 
            <div class="my-3 my-md-5">
                <div class="container">
                    <?php include 'class_menu.php'; ?>
                    <div class="row">
                        <div class="col-12 scrollable scrollable_x">
                            <table class="table table-dark table-striped table-sm">
<?php  

$header = "SELECT DISTINCT(`att_date`) FROM tbl_attendance WHERE `class_id` =".$_GET['id'];

    $result_header = mysqli_query($conn, $header); 
    if (mysqli_num_rows($result_header)>0) {
         echo '<thead id="main-head">';
         echo '<th>Student Name</th>';
         $num = 0;
        while ($hr = mysqli_fetch_assoc($result_header)) {
            $num++;
            echo '<th class="rotate">'.$hr['att_date'].'</th>';
            $sub1[] = "IF(SUM(COALESCE(tab1.Date".$num.", 0)) = 1, 'Present', 'Absent')  AS '".$hr['att_date']."'";
            $sub2[] = "( CASE WHEN `att_date` = '".$hr['att_date']."' THEN `att_status` END ) AS 'Date".$num."'";
            $theads[] = $hr['att_date'];
        }
         echo '</thead>';
    }
    
    $sql = "SELECT tab1.`student_name`, 
    ".implode(',', $sub1)."
    FROM ( 
    SELECT s.*, a.member_id, a.`att_date`, a.`att_status`, 
    ".implode(',', $sub2)."
    FROM tbl_attendance a 
    left join tbl_class_member cm ON a.member_id = cm.`member_id`
    LEFT JOIN tbl_student s ON cm.student_id = s.student_id 
    WHERE a.`class_id` = '".$_GET['id']."' ) tab1 
    GROUP BY tab1.`member_id` 
    ORDER BY tab1.student_grade,tab1.student_section,tab1.gender, tab1.student_name ASC";
    $result = mysqli_query($conn, $sql);
    echo '<tbody>';
    if (mysqli_num_rows($result)>0) {
       while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr id="stud">';
            echo '<td class="left">'.$row['student_name'].'</td>';
            foreach ($theads as $key => $head) {
                echo "<td>".$row[$head]."</td> ";
            }
            echo '<tr/>';
        }
    echo '</tbody>';
    }

    // echo $sql;
?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script>
        var val="Absent";
        $("td:contains('"+val+"')").css('background-color', 'red');
    </script>
    <style type="text/css">
        input[type='date']#date{
            height: inherit;
            max-height: inherit;
            width: 30%;
            float:right; 
            display: inline-block;
            margin-right: -20px;
        }
        button#shadow{
            height: inherit;
            max-height: inherit;
            float:right; 
            display: inline-block;
            margin-right: 10px;
        }
        tr#stud:hover{
            background-color: cornflowerblue;
        }
        .scrollable {
            overflow:scroll;
            height:500px;
        }
        .scrollable_x{
            width: 1175px;
            overflow-x: auto;
            white-space: nowrap;
        }

        /*#main-head th{
            height: 80px;
        }
        .rotate{
            /* FF3.5+ */
            -moz-transform: rotate(-90.0deg);
            /* Opera 10.5 */
            -o-transform: rotate(-90.0deg);
            /* Saf3.1+, Chrome */
            -webkit-transform: rotate(-90.0deg);
            /* IE6,IE7 */
            filter: progid: DXImageTransform.Microsoft.BasicImage(rotation=0.083);
            /* IE8 */
            -ms-filter: "progid:DXImageTransform.Microsoft.BasicImage(rotation=0.083)";
            /* Standard */
            transform: rotate(-90.0deg);
        } */
    </style>

    <!-- <table border="1">
        <thead id="main-head">
            <th class="rotate">12/12/2019</th>
        </thead>
        <tbody>
            <tr>
                <td>A</td>
            </tr>
            <tr>
                <td>A</td>
            </tr>
            <tr>
                <td>A</td>
            </tr>
            <tr>
                <td>A</td>
            </tr>
            <tr>
                <td>A</td>
            </tr>
            <tr>
                <td>A</td>
            </tr>
            <tr>
                <td>A</td>
            </tr>
            <tr>
                <td>A</td>
            </tr>
            <tr>
                <td>A</td>
            </tr>
            <tr>
                <td>A</td>
            </tr>
            <tr>
                <td>A</td>
            </tr>
            <tr>
                <td>A</td>
            </tr>
            <tr>
                <td>A</td>
            </tr>
            <tr>
                <td>A</td>
            </tr>
            <tr>
                <td>A</td>
            </tr>
            <tr>
                <td>A</td>
            </tr>
            <tr>
                <td>A</td>
            </tr>
            <tr>
                <td>A</td>
            </tr>
            <tr>
                <td>A</td>
            </tr>
            <tr>
                <td>A</td>
            </tr>
            <tr>
                <td>A</td>
            </tr>
            <tr>
                <td>A</td>
            </tr>
            <tr>
                <td>A</td>
            </tr>
            <tr>
                <td>A</td>
            </tr>
            <tr>
                <td>A</td>
            </tr>
            <tr>
                <td>A</td>
            </tr>

        </tbody>
    </table> -->
</body>
</html>
