function openForm(form){
    if(form == 'createProduct'){
        console.log('Create Product');
        var ifrm = document.createElement('iframe');
        ifrm.src = "forms/new-product.html";
        ifrm.setAttribute('id', 'form');
        ifrm.setAttribute('scrolling','no');
        ifrm.setAttribute('onload','setIframeHeight()');
        ifrm.setAttribute('frameborder', '0');
        document.getElementById('forground').classList.toggle('active');
        document.getElementById('pop-up-wrapper').appendChild(ifrm);
    }
    if(form == 'createService'){
        console.log('Create Service');
        var ifrm = document.createElement('iframe');
        ifrm.src = "forms/new-service.html";
        ifrm.setAttribute('id', 'form');
        ifrm.setAttribute('scrolling','no');
        ifrm.setAttribute('onload','setIframeHeight()');
        ifrm.setAttribute('frameborder', '0');
        document.getElementById('forground').classList.toggle('active');
        document.getElementById('pop-up-wrapper').appendChild(ifrm);
    }
    if(form == 'createTool'){
        console.log('Create Tool');
        var ifrm = document.createElement('iframe');
        ifrm.src = "forms/new-tool.html";
        ifrm.setAttribute('id', 'form');
        ifrm.setAttribute('scrolling','no');
        ifrm.setAttribute('onload','setIframeHeight()');
        ifrm.setAttribute('frameborder', '0');
        document.getElementById('forground').classList.toggle('active');
        document.getElementById('pop-up-wrapper').appendChild(ifrm);
    }
    if(form == 'createRate'){
        console.log('Create Rate');
        var ifrm = document.createElement('iframe');
        ifrm.src = "forms/new-rate.html";
        ifrm.setAttribute('id', 'form');
        ifrm.setAttribute('scrolling','no');
        ifrm.setAttribute('onload','setIframeHeight()');
        ifrm.setAttribute('frameborder', '0');
        document.getElementById('forground').classList.toggle('active');
        document.getElementById('pop-up-wrapper').appendChild(ifrm);
    }
    else{
        var ifrm = document.createElement('iframe');
        ifrm.src = "forms/"+ form +".html";
        ifrm.setAttribute('id', 'form');
        ifrm.setAttribute('scrolling','no');
        ifrm.setAttribute('onload','setIframeHeight()');
        ifrm.setAttribute('frameborder', '0');
        document.getElementById('forground').classList.toggle('active');
        document.getElementById('pop-up-wrapper').appendChild(ifrm);
    }
}

function closeForm(){
    console.log("Closed");
    document.getElementById("form").outerHTML = "";
    document.getElementById('forground').classList.toggle('active');
}

function viewForm(form = "", id = "", name= "", rate = ""){
    var ifrm = document.createElement('iframe');
    ifrm.src = "php/forms/"+ form +".php?id=" + id + "&name=" + name + "&rate=" + rate;
    ifrm.setAttribute('id', 'form');
    ifrm.setAttribute('scrolling','no');
    ifrm.setAttribute('onload','setIframeHeight()');
    ifrm.setAttribute('frameborder', '0');
    document.getElementById('forground').classList.toggle('active');
    document.getElementById('pop-up-wrapper').appendChild(ifrm);
}

function dropDown(id){
    var elem = document.getElementById(id);
    elem.classList.toggle('active');
}

//For setting the height of the popup iframe
function getDocHeight(doc) {
    doc = doc || document;
    var form = doc.getElementById('form');
    var search = doc.getElementById('search');
    if(form != null){
        var height = (form.offsetHeight -1);
    }
    if(search != null){
        height += (search.offsetHeight - 1);
    }
    return height;
}

function getDocWidth(doc){
    doc = doc || document;
    var form = doc.getElementById('form');
    var search = doc.ifrm;
    if(form != null){
        var width = (form.offsetWidth -1);
    }
    return width;
}

function setIframeHeight() {
    var ifrm = document.getElementById("form");
    var doc = (ifrm.contentWindow);
    if(doc.document){
        doc = doc.document;
    }
    
    ifrm.width = getDocWidth(doc) + "px";
    ifrm.height = getDocHeight(doc) + "px";
}

function search(event, searchfeild, insertAt){
    insert = insertAt;
    if(event.button == 0){
        var xhttp;
        xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    //console.log(this.responseText);
                    $("#search-box").empty();
                    $('#search-box').append(this.responseText);
                }
            };
            xhttp.open("GET", "php/search_feilds/"+ searchfeild +".php", true);
            xhttp.send();
    }
}