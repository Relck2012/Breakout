<?php
echo '
    <h3>Product Search</h3>
    <form id="product-search" action="" method="POST" onKeyPress="submitOnEnter(event, `php/searchProduct.php`)">
        <div id="search-feilds">
            <input placeholder="ID" id="id" size="10" value="">
            <input placeholder="Summary" id="summary" size="54" value="">
            <input placeholder="Manufacturer" id="manf" value="">
            <input placeholder="Model Number" id="model_num" class="last" value="">
        </div>
        <div id="result-feilds">
            
        </div>
    </form>';
?>