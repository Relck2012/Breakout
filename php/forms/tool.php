<?php 
    require '../../../../connections/db_connection.php';
    $sql = 'SELECT * FROM tool WHERE id="'.$_GET["id"].'"';
    $result = $db_con->query($sql);
    $row = mysqli_fetch_assoc($result);
    echo '
        <head>
            <link rel="stylesheet" href="../../css/main.css">
        </head>
        <form id="form" style="height: 280px; width: 250px; display: block; margin-right: 15px;" action="../main.php" method="POST">
            <input type="hidden" name="id" value="'.$row['id'].'"> 
            <input type="hidden" name="table" value="tool">  
            <div class="content-wrapper form-info-content" style="display: block;">
                <input type="text" name="name" placeholder="Name" autocomplete="off" value="'.$row["name"].'" style="margin: 10px 0; width: 100%; display: block;">
                <textarea type="text" name="description" placeholder="Description" style="width: 100%; margin: 10px 0; height: 200px; display: block;">'.$row["description"].'</textarea>
                <button type="submit" name="dbFunction"  value="update" style="width: 75px; float:right;">Update</button>
                <button type="submit" name="dbFunction"  value="delete" style="width: 75px; float:right;">Delete</button>
            </div>
        </form>';
?>