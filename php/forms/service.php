<?php 
    require '../../../../connections/db_connection.php';
    $sqlService = 'SELECT * FROM service WHERE service_id="'.$_GET["id"].'"';
    $sqlProducts = 'SELECT * FROM product INNER JOIN product_list ON product.id=product_list.product_id WHERE service_id="'.$_GET["id"].'"';
    $sqlTools = 'SELECT * FROM tool INNER JOIN tools_list ON tool.id=tools_list.tool_id WHERE service_id="'.$_GET["id"].'"';
    $sqlInstallBy = 'SELECT * FROM technician INNER JOIN install_by ON technician.department_name=install_by.depart_name AND technician.rate=install_by.depart_rate WHERE service_id="'.$_GET["id"].'"';
    $sqlConfigBy = 'SELECT * FROM technician INNER JOIN config_by ON technician.department_name=config_by.depart_name AND technician.rate=config_by.depart_rate WHERE service_id="'.$_GET["id"].'"';

    $service = mysqli_fetch_assoc($db_con->query($sqlService));
    $products = mysqli_fetch_all($db_con->query($sqlProducts), MYSQLI_ASSOC);
    $tools = mysqli_fetch_all($db_con->query($sqlTools), MYSQLI_ASSOC);
    $installBy = mysqli_fetch_all($db_con->query($sqlInstallBy), MYSQLI_ASSOC);
    $configBy = mysqli_fetch_all($db_con->query($sqlConfigBy), MYSQLI_ASSOC);

    $html= '
            <html>
                <head>
                    <link rel="stylesheet" href="../../css/main.css">
                    <script src="../../js/main.js"></script>
                    <script src="../../js/form.js"></script>
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script> 
                </head>
                <body style="margin: 0;">
                    <form id="form" style="height: 300px; width: 795px; border: 1px solid black;" action="../main.php" onsubmit="index()" method="POST">
                        <input type="hidden" name="table" value="service">
                        <input type="hidden" name="id" value="'.$service['service_id'].'"> 
                        <div class="content-wrapper form-info-content" style="height: 100%; width: 45%;">
                            <input type="text" name="summary" placeholder="Summary" autocomplete="off" value="'.$service["summary"].'" style="margin: 10px 0; width: 100%; display: inline-block;">
                            <textarea type="text" name="description" placeholder="Description" style="margin: 0 0 5px 0; width: 100%; height: 85%; display: inline-block;">'.$service["description"].'</textarea>
                        </div> 
                        <div class="content-wrapper form-info-content" style="height: 100%; width: 392px; position: relative" >
                            <div class="create-services-list">
                                <div class="item" id="product-list">
                                    <p onclick="dropDown(`product-list`)">Products<span style="font-size: 12px;">   &#9660</span></p>
                                    <ul id="products">
                                        <li id="product" class="add" onclick="changeSearch(`../../forms/product-search.html`, `products`)">Add Product</li>';
                                        $i = 0;
                                        foreach($products as $key){
                                            $html.= '<li oncontextmenu="remove(this);">
                                                        <input type="hidden" name="product_id" value="'.$key["product_id"].'">
                                                        <div class="details" oncontextmenu="return false;">
                                                            <span class="summary">'.$key["summary"].'</span>
                                                            <span class="qt"><input value="'.$key["quantity"].'" name="product_quantity" style="height: inherit; margin-bottom: 5px;"></span>
                                                            <span class="cost">'.$key["buy_for"].'</span>
                                                        </div>
                                                    </li>';
                                            $i++;
                                        }
                                    $html .= '
                                    </ul>
                                </div>
                                <div class="item" id="resource-list">
                                    <p onclick="dropDown(`resource-list`)">Resources<span style="font-size: 12px;">   &#9660</span></p>
                                    <ul id="resource-install">
                                        <li id="resource" class="add" onclick="changeSearch(`../../forms/resource_search.html`, `resource-install`)">Add Install Resource</li>';
                                        $i = 0;
                                        foreach($installBy as $key){
                                            $html.= '<li oncontextmenu="remove(this);">
                                                        <input type="hidden" name="install_name" value="'.$key["depart_name"].'">
                                                        <input type="hidden" name="install_rate" value="'.$key["depart_rate"].'">
                                                        <div class="details" oncontextmenu="return false;">
                                                            <span class="summary">'.$key["summary"].'</span>
                                                            <span class="qt"><input value="'.$key["quantity"].'" name="install_quantity" style="height: inherit; margin-bottom: 5px;"></span>
                                                            <span class="rate">'.$key["rate"].'</span>
                                                        </div>
                                                    </li>';
                                            $i++;
                                        }
                                    $html.='
                                    </ul>
                                    <ul id="resource-config">
                                        <li id="resource" class="add" onclick="changeSearch(`../../forms/resource_search.html`, `resource-config`)">Add Config Resource</li>';
                                        $i = 0;
                                        foreach($configBy as $key){
                                            $html.= '<li oncontextmenu="remove(this);">
                                                        <input type="hidden" name="config_name" value="'.$key["depart_name"].'">
                                                        <input type="hidden" name="config_rate" value="'.$key["depart_rate"].'">
                                                        <div class="details" oncontextmenu="return false;">
                                                            <span class="summary">'.$key["summary"].'</span>
                                                            <span class="qt"><input value="'.$key["quantity"].'" name="config_quantity" style="height: inherit; margin-bottom: 5px;"></span>
                                                            <span class="rate">'.$key["rate"].'</span>
                                                        </div>
                                                    </li>';
                                            $i++;
                                        }
                                    $html.='
                                    </ul>
                                </div>
                                <div class="item" id="tool-list">
                                    <p onclick="dropDown(`tool-list`)">Tools<span style="font-size: 12px;">   &#9660</span></p>
                                    <ul id="tools">
                                        <li id="tool" class="add" onclick="changeSearch(`../../forms/tool_search.html`, `tools`)">Add Tool</li>';
                                        $i = 0;
                                        foreach($tools as $key){
                                            $html.= '<li oncontextmenu="remove(this);">
                                                        <input type="hidden" name="tool_id" value="'.$key["tool_id"].'">
                                                        <div class="details" oncontextmenu="return false;">
                                                            <span class="tool-name" style="width: 80%">'.$key["name"].'</span>
                                                            <span class="qt"><input value="'.$key["quantity"].'" name="tool_quantity" style="height: inherit; margin-bottom: 5px;"></span>
                                                        </div>
                                                    </li>';
                                            $i++;
                                        }
                                    $html.='
                                    </ul>
                                </div>
                            </div>
                            <div style="position: absolute; bottom: 10px; right: 35px;">
                                <button type="submit" name="dbFunction"  value="update" style="width: 75px; float:right;">Update</button>
                                <button type="submit" name="dbFunction"  value="delete" style="width: 75px; float:right;">Delete</button>
                            </div>
                        </div> 
                    </form>
                    <iframe id="search" src="../../forms/product-search.html" frameborder="0">
        
                    </iframe>
                </body>
            </html>';
    
    echo $html;
?>