<?php 
    require '../../../../connections/db_connection.php';
    $sql = 'SELECT * FROM product WHERE id="'.$_GET["id"].'"';
    $result = $db_con->query($sql);
    $row = mysqli_fetch_assoc($result);
    //echo bin2hex($row['description']);
    echo '
            <html>
            <head>
                <link rel="stylesheet" href="../../css/main.css">
            </head>
            <body>
            <form id="form" style="height: 250px; width: 465px; display: inline-block" action="../main.php" method="POST">
                <input type="hidden" name="table" value="product">
                <input type="hidden" name="id" value="'.$row['id'].'">  
                <div class="content-wrapper form-info-content" style="height: 100%;">
                    <input type="text" name="summary" placeholder="Summary" autocomplete="off" value="'.$row["summary"].'" style="margin: 10px 0; width: 250px; display: block;">
                    <textarea type="text" name="description" placeholder="Description" style="width: 250px; height: 200px; display: block;">'.$row["description"].'</textarea>
                </div> 
                <div class="content-wrapper form-info-content" style="height: 100%; position: relative" >
                    <input type="text" name="manufacture" placeholder="Manufacture" autocomplete="off" value="'.$row["manufacture"].'" style="display: block">
                    <input type="text" name="model_num" placeholder="Model #" autocomplete="off" value="'.$row["model_num"].'" style="display: block">
                    <div style="text-align: right;">
                        <input type="number" step="0.01" name="item_cost" placeholder="Cost" autocomplete="off" value="'.$row["buy_for"].'" style="width: 50px; margin: 0;">
                        <input type="number" step="0.01" name="item_sell" placeholder="Sell" autocomplete="off" value="'.$row["sell_for"].'" style="width: 50px; margin: 0;">
                    </div>
                    <div style="position: absolute; bottom: 10px; right: 15px;">
                        <button type="submit" name="dbFunction"  value="update" style="width: 75px; float:right;">Update</button>
                        <button type="submit" name="dbFunction"  value="delete" style="width: 75px; float:right;">Delete</button>
                    </div>
                </div> 
            </body>
            </form>
            </html>'
?>