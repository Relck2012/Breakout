$(document).ready(function(){
    var timer = 0;
    var delay = 200;
    var prevent = false;

    $("body").on("click", ".result", function() {
        var index = $(".result").index(this);
        timer = setTimeout(function() {
        if (!prevent) {
            //Get id, name, rate
            if($(".product").length){
                parent.viewForm('product', $(".product").eq(index).find(".id p").html());
            }
            else if($(".resource").length){
                console.log("Resource");
                parent.viewForm('resource', "" ,$(".resource").eq(index).find(".department_name p").html(), $(".resource").eq(index).find(".rate p").html());
            }
            else if($(".tool").length){
                console.log("Tool");
                parent.viewForm('tool', $(".tool").eq(index).find(".tool-id p").html());
            }
            else if($(".service").length){
                console.log("Service");
                parent.viewForm('service', $(".service").eq(index).find(".id p").html());
            }
        }
        prevent = false;
        }, delay);
    }).on("dblclick", ".result", function() {
        clearTimeout(timer);
        prevent = true;
        add(this);
    });
  });

function submitOnEnter(e, url = "../php/searchProduct.php"){
    var xhttp;
    var str = "";

    if(e.keyCode === 13){
        if(document.getElementById("product-search")){
            var id = encodeURIComponent(document.getElementById("id").value);
            var summary = encodeURIComponent(document.getElementById("summary").value);
            var manf = encodeURIComponent(document.getElementById("manf").value);
            var modelNum = encodeURIComponent(document.getElementById("model_num").value);
            str += "search=product&"
            if(id != ""){
                str += "id=" + id + "&";
            }
            if(summary != ""){
                str += "summary=" + summary + "&";
            }
            if(manf != ""){
                str += "manufacture=" + manf + "&";
            }
            if(modelNum != ""){
                str += "model_num=" + modelNum + "&";
            }
        }
        else if(document.getElementById("resource-search")){
            var name = encodeURIComponent(document.getElementById("department_name").value);
            var description = encodeURIComponent(document.getElementById("description").value);
            var rate = encodeURIComponent(document.getElementById("rate").value);
            str += "search=technician&"

            if(name != ""){
                str += "department_name=" + name + "&";
            }
            if(description != ""){
                str += "description=" + description + "&";
            }
            if(rate != ""){
                str += "rate=" + rate + "&";
            }
        }
        else if(document.getElementById("tool-search")){
            var id = encodeURIComponent(document.getElementById("tool_id").value);
            var name = encodeURIComponent(document.getElementById("tool_name").value);
            var description = encodeURIComponent(document.getElementById("tool_description").value);
            str += "search=tool&"

            if(id != ""){
                str += "id=" + id + "&";
            }
            if(name != ""){
                str += "tool_name=" + name + "&";
            }
            if(description != ""){
                str += "description=" + description + "&";
            }
        }
        else if(document.getElementById("service-search")){
            var id = encodeURIComponent(document.getElementById("id").value);
            var summary = encodeURIComponent(document.getElementById("summary").value);
            var description = encodeURIComponent(document.getElementById("description").value);
            var prodID = encodeURIComponent(document.getElementById("product_id").value);
            str += "search=service&"
            if(id != ""){
                str += "id=" + id + "&";
            }
            if(summary != ""){
                str += "summary=" + summary + "&";
            }
            if(description != ""){
                str += "description=" + description + "&";
            }
            if(prodID != ""){
                str += "product_id=" + prodID + "&";
            }
        }
        str = str.substring(0, str.length - 1); //Removes the last '&' from the string
        //console.log(str);
        if (str != "") {
            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    response = this.responseText;
                    console.log(response);
                    parent.searchResults = JSON.parse(response);
                    results = parent.searchResults;
                    //console.log(results);
                    $("#result-feilds").empty();
                    for(var i = 0; i < results.length; i++){
                        $("#result-feilds").append(getResultHtml(i));
                    }
                }
            };
            xhttp.open("POST", url, true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send(str);
        }
    }
}

function addToBreakout(element){
    var index = $(".result").index(element);
    if(document.getElementById("product-search")){
        if(parent.$("#" + insert + " li").length < 2){
            parent.$("#" + insert).append(`<div>Summary<span class="qt" style="height: inherit; margin-right: 1px;">Qt</span><span class="cost" style="height: inherit; margin-right: 1px; border: none; ">Cost</span></div>`);
        }
        product_ids.push([searchResults[index].id]);
        parent.$("#" + insert).append(`<li oncontextmenu="remove(this);">
                                                <input type="hidden" name="product_id" value="` + searchResults[index].id + `">
                                                <div class="details" oncontextmenu="return false;">
                                                    <span class="summary">` + searchResults[index].summary + `</span>
                                                    <span class="qt"><input value="" name="product_quantity" style="height: inherit; margin-bottom: 5px;"></span>
                                                    <span class="cost">` + searchResults[index].buy_for + `</span>
                                                </div>
                                              </li>`);
    }
    else if(document.getElementById("resource-search")){
        if(parent.$("#" + parent.insert + " li").length < 2){
            parent.$("#" + parent.insert).append(`<div>Department<span class="qt" style="height: inherit; margin-right: 1px;">Qt</span><span class="cost" style="height: inherit; margin-right: 1px; border: none; ">Rate</span></div>`);
        }
        if(parent.insert == 'resource-install'){
            parent.install_resources.push([parent.searchResults[index].department_name, parent.searchResults[index].rate]);
            console.log(parent.install_resources);
            parent.$("#" + parent.insert).append(`<li oncontextmenu="remove(this);">
                                                <input type="hidden" name="install_name" value="` + parent.searchResults[index].department_name + `">
                                                <input type="hidden" name="install_rate" value="` + parent.searchResults[index].rate + `">
                                                <div class="details" oncontextmenu="return false;">
                                                    <span class="summary">` + parent.searchResults[index].department_name + `</span>
                                                    <span class="qt"><input value="" name="install_quantity" style="height: inherit; margin-bottom: 5px;"></span>
                                                    <span class="rate">` + parent.searchResults[index].rate + `</span>
                                                </div>
                                              </li>`);
        }
        else{
            parent.config_resources.push([parent.searchResults[index].department_name, parent.searchResults[index].rate]);
            parent.$("#" + parent.insert).append(`<li oncontextmenu="remove(this);">
                                                <input type="hidden" name="config_name" value="` + parent.searchResults[index].department_name + `">
                                                <input type="hidden" name="config_rate" value="` + parent.searchResults[index].rate + `">
                                                <div class="details" oncontextmenu="return false;">
                                                    <span class="summary">` + parent.searchResults[index].department_name + `</span>
                                                    <span class="qt"><input value="" name="config_quantity" style="height: inherit; margin-bottom: 5px;"></span>
                                                    <span class="rate">` + parent.searchResults[index].rate + `</span>
                                                </div>
                                              </li>`);
        }
        
    }
    else if(document.getElementById("tool-search")){
        if(parent.$("#" + parent.insert + " li").length < 2){
            parent.$("#" + parent.insert).append(`<div>Name<span class="qt" style="height: inherit; margin-right: 1px;">Qt</span><span class="cost" style="height: inherit; margin-right: 1px; border: none; "></span></div>`);
        }
        parent.tool_ids.push([parent.searchResults[index].id]);
        parent.$("#" + parent.insert).append(`<li oncontextmenu="remove(this);">
                                                <input type="hidden" name="tool_id" value="` + parent.searchResults[index].id + `">
                                                <div class="details" oncontextmenu="return false;">
                                                    <span class="tool-name" style="width: 80%">` + parent.searchResults[index].name + `</span>
                                                    <span class="qt"><input value="" name="tool_quantity" style="height: inherit; margin-bottom: 5px;"></span>
                                                </div>
                                              </li>`);
    }
}

function add(element){
    var index = $(".result").index(element);
    if(document.getElementById("product-search")){
        if(parent.$("#" + parent.insert + " li").length < 2){
            parent.$("#" + parent.insert).append(`<div>Summary<span class="qt" style="height: inherit; margin-right: 1px;">Qt</span><span class="cost" style="height: inherit; margin-right: 1px; border: none; ">Cost</span></div>`);
        }
        parent.product_ids.push([parent.searchResults[index].id]);
        parent.$("#" + parent.insert).append(`<li oncontextmenu="remove(this);">
                                                <input type="hidden" name="product_id" value="` + parent.searchResults[index].id + `">
                                                <div class="details" oncontextmenu="return false;">
                                                    <span class="summary">` + parent.searchResults[index].summary + `</span>
                                                    <span class="qt"><input value="" name="product_quantity" style="height: inherit; margin-bottom: 5px;"></span>
                                                    <span class="cost">` + parent.searchResults[index].buy_for + `</span>
                                                </div>
                                              </li>`);
    }
    else if(document.getElementById("resource-search")){
        if(parent.$("#" + parent.insert + " li").length < 2){
            parent.$("#" + parent.insert).append(`<div>Department<span class="qt" style="height: inherit; margin-right: 1px;">Qt</span><span class="cost" style="height: inherit; margin-right: 1px; border: none; ">Rate</span></div>`);
        }
        if(parent.insert == 'resource-install'){
            parent.install_resources.push([parent.searchResults[index].department_name, parent.searchResults[index].rate]);
            console.log(parent.install_resources);
            parent.$("#" + parent.insert).append(`<li oncontextmenu="remove(this);">
                                                <input type="hidden" name="install_name" value="` + parent.searchResults[index].department_name + `">
                                                <input type="hidden" name="install_rate" value="` + parent.searchResults[index].rate + `">
                                                <div class="details" oncontextmenu="return false;">
                                                    <span class="summary">` + parent.searchResults[index].department_name + `</span>
                                                    <span class="qt"><input value="" name="install_quantity" style="height: inherit; margin-bottom: 5px;"></span>
                                                    <span class="rate">` + parent.searchResults[index].rate + `</span>
                                                </div>
                                              </li>`);
        }
        else{
            parent.config_resources.push([parent.searchResults[index].department_name, parent.searchResults[index].rate]);
            parent.$("#" + parent.insert).append(`<li oncontextmenu="remove(this);">
                                                <input type="hidden" name="config_name" value="` + parent.searchResults[index].department_name + `">
                                                <input type="hidden" name="config_rate" value="` + parent.searchResults[index].rate + `">
                                                <div class="details" oncontextmenu="return false;">
                                                    <span class="summary">` + parent.searchResults[index].department_name + `</span>
                                                    <span class="qt"><input value="" name="config_quantity" style="height: inherit; margin-bottom: 5px;"></span>
                                                    <span class="rate">` + parent.searchResults[index].rate + `</span>
                                                </div>
                                              </li>`);
        }
        
    }
    else if(document.getElementById("tool-search")){
        if(parent.$("#" + parent.insert + " li").length < 2){
            parent.$("#" + parent.insert).append(`<div>Name<span class="qt" style="height: inherit; margin-right: 1px;">Qt</span><span class="cost" style="height: inherit; margin-right: 1px; border: none; "></span></div>`);
        }
        parent.tool_ids.push([parent.searchResults[index].id]);
        parent.$("#" + parent.insert).append(`<li oncontextmenu="remove(this);">
                                                <input type="hidden" name="tool_id" value="` + parent.searchResults[index].id + `">
                                                <div class="details" oncontextmenu="return false;">
                                                    <span class="tool-name" style="width: 80%">` + parent.searchResults[index].name + `</span>
                                                    <span class="qt"><input value="" name="tool_quantity" style="height: inherit; margin-bottom: 5px;"></span>
                                                </div>
                                              </li>`);
    }
}

function getResultHtml(i){
    var html;
    if(document.getElementById("product-search")){
        html = `<div class='result product'>
                    <div class='id'><p>` + parent.searchResults[i].id + `</p></div>
                    <div class='summary'><p>` + parent.searchResults[i].summary + `</p></div>
                    <div class='manf'><p>` + parent.searchResults[i].manufacture + `</p></div>
                    <div class='model'><p>` + parent.searchResults[i].model_num + `</p></div>
                </div>`;
    }
    else if(document.getElementById("resource-search")){
        html = `<div class='result resource'>
                    <div class='department_name'><p>` + parent.searchResults[i].department_name + `</p></div>
                    <div class='description'><p>` + parent.searchResults[i].description + `</p></div>
                    <div class='rate'><p>` + parent.searchResults[i].rate + `</p></div>
                </div>`;
    }
    else if(document.getElementById("tool-search")){
        html = `<div class='result tool'>
                    <div class='tool-id'><p style="margin: auto;">` + parent.searchResults[i].id + `</p></div>
                    <div class='tool-name'><p style="margin: auto;">` + parent.searchResults[i].name + `</p></div>
                    <div class='tool-description'><p style="margin: auto 5px;">` + parent.searchResults[i].description + `</p></div>
                </div>`;
    }
    else if(document.getElementById("service-search")){
        html = `<div class='result service'>
                    <div class='id'><p>` + parent.searchResults[i].service_id + `</p></div>
                    <div class='summary'><p>` + parent.searchResults[i].summary + `</p></div>
                    <div class='description'><p>` + parent.searchResults[i].description + `</p></div>
                </div>`;
    }

    return html;
}