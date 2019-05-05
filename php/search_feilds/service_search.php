<?php
echo '
    <h3>Service Search</h3>
    <form id="service-search" action="" method="POST" onKeyPress="submitOnEnter(event, `php/searchProduct.php`)">
        <div id="search-feilds">
            <input placeholder="ID" id="id" value="">
            <input placeholder="Summary" id="summary" value="">
            <input placeholder="Description" id="description" value="">
            <input placeholder="Has Product" id="product_id" value="">
        </div>
        <div id="result-feilds">
            
        </div>
    </form>';
?>