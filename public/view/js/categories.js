function addCategory(){
    var cat_name = document.getElementById('categoryName').value;
    var cat_type = document.getElementById('categoryType').value;

    fetch(config.url.categoryRegistration,{
        method: "POST",
        headers: {'Content-type': 'application/x-www-form-urlencoded'},
        body: "cat_name=" + cat_name + "&cat_type=" + cat_type
    })
        .then(handleErrors)
        .then(function (myJson) {
            if(myJson.response === true){
                alert("You successfuly added a category!");
            }
            else{
                alert("Something went wrong!");
            }
        })
        .catch(function (e) {
            alert(e.message);
            //location.href="./404.html";
        })
}

function fillRecordsCategories(){
    fetch(config.url.allCategories)
        .then(function (response) {
            return response.json();
        })
        .then(function (myJson) {
            var cat_select = document.getElementById('categorySelect');
            cat_select.innerHTML = "";
            cat_select.innerHTML = "<option selected value=\"none\">Choose...</option>";
            for (var i=0; i < myJson.length; i++){
                var option = document.createElement('option');
                option.value = myJson[i]["category_id"];
                option.text = myJson[i]["category_name"];
                cat_select.options.add(option,1);
            }
        })
        .catch(function (e) {
            alert(e.message);
        })
}

function fillBudgetsCategories(){
    fetch(config.url.allCategories)
        .then(function (response) {
            return response.json();
        })
        .then(function (myJson) {
            var cat_select = document.getElementById('categorySelectBudget');
            cat_select.innerHTML = "";
            cat_select.innerHTML = "<option selected value=\"none\">Choose...</option>";
            for (var i=0; i < myJson.length; i++){
                if(myJson[i]["category_type"] === "expense"){
                    var option = document.createElement('option');
                    option.value = myJson[i]["category_id"];
                    option.text = myJson[i]["category_name"];
                    cat_select.options.add(option,1);
                }

            }
        })
        .catch(function (e) {
            alert(e.message);
        })
}

function resetCategoriesInputs(){
    document.getElementById("categoryName").value="";
    document.getElementById("categoryType").selectedIndex = "none";
}