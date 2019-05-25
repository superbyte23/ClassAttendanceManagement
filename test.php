<?php  

include 'include/config.php';
$header = "SELECT DISTINCT(`att_date`) FROM tbl_attendance WHERE `class_id` =".$_GET['id'];

    $result_header = mysqli_query($conn, $header); 
    if (mysqli_num_rows($result_header)>0) {
         //echo '<thead>';
        //echo '<th>Student Name</th>';
         $num = 0;
        while ($hr = mysqli_fetch_assoc($result_header)) {
            $num++;
            //echo '<th>'.$hr['att_date'].'</th>';
            $sub1[] = "IF(SUM(COALESCE(tab1.Date".$num.", 0)) = 1, 'Present', 'Absent')  AS '".$hr['att_date']."'";
            $sub2[] = "( CASE WHEN `att_date` = '".$hr['att_date']."' THEN `att_status` END ) AS 'Date".$num."'";
            $theads[] = $hr['att_date'];
        }
         //echo '</thead>';
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
    // $result = mysqli_query($conn, $sql);
    // echo '<tbody>';
    // if (mysqli_num_rows($result)>0) {
    //    while ($row = mysqli_fetch_assoc($result)) {
    //         echo '<tr id="stud">';
    //         echo '<td class="left">'.$row['student_name'].'</td>';
    //         foreach ($theads as $key => $head) {
    //             echo "<td>".$row[$head]."</td> ";
    //         }
    //         echo '<tr/>';
    //     }
    // echo '</tbody>';
    // }

    echo $sql;
?>