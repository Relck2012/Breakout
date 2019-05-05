<?php
    require '../../../../connections/db_connection.php';
    $sql = 'SELECT * FROM technician WHERE department_name=\''.$_GET["name"].'\' AND rate=\''.$_GET["rate"].'\'';
    $result = $db_con->query($sql);
    $row = mysqli_fetch_assoc($result);
    echo '
        <head>
            <link rel="stylesheet" href="../../css/main.css">
        </head>
        <form id="form" style="height: 250px; width: 440px; display: inline-block;" action="../main.php" method="POST">
            <input type="hidden" name="table" value="technician"> 
            <input type="hidden" name="i_rate" value="'.$row["rate"].'">
            <div class="content-wrapper form-info-content" style="height: 100%;">
                <input type="text" name="summary" placeholder="Summary" autocomplete="off" value="'.$row["summary"].'" style="margin: 10px 0; width: 250px; display: block;">
                <textarea type="text" name="description" placeholder="Description" style="width: 250px; height: 200px; display: block;">'.$row["description"].'</textarea>
            </div> 
            <div class="content-wrapper form-info-content" style="height: 100%; position: relative" >
                <select type="text" name="department_name" style="display: block; margin: 10px 0px;">
                    <option value="'.$row["department_name"].'">'.$row["department_name"].'</option>
                </select>
                <div style="text-align: right;">
                    <input type="number" name="rate" placeholder="Rate" autocomplete="off" value="'.$row["rate"].'"style="width: 50px; margin: 0;">
                </div>
                <div style="position: absolute; bottom: 10px; right: 15px;">
                    <button type="submit" name="dbFunction"  value="update" style="width: 75px; float:right;">Update</button>
                    <button type="submit" name="dbFunction"  value="delete" style="width: 75px; float:right;">Delete</button>
                </div>
            </div> 
        </form>';

?>