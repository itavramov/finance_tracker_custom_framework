function fillAccounts() {
    fetch(config.url.allAccounts)
        .then(function (response) {
            return response.json();
        })
        .then(function (myJson) {
            document.getElementById("accounts_main").innerHTML = "";
            var acc_main = document.getElementById("accounts_main");
            label = document.createElement("H3");
            label.innerText = "All accounts";
            acc_main.appendChild(label);
            var ict_unit = [];
            var efficiency = [];
            var coloR = [];

            var dynamicColors = function() {
                var r = Math.floor(Math.random() * 255);
                var g = Math.floor(Math.random() * 255);
                var b = Math.floor(Math.random() * 255);
                return "rgb(" + r + "," + g + "," + b + ")";
            };

            for (var i=0; i < myJson.length; i++){
                ict_unit.push("ICT Unit " + myJson[i].ict_unit);
                efficiency.push(myJson[i].efficiency);
                coloR.push(dynamicColors());
                var info_box = document.createElement('div');
                info_box.className = "info-box";
                var span_info = document.createElement("span");
                span_info.className = "info-box-icon";
                span_info.style.backgroundColor = coloR[i];
                var span_i = document.createElement("i");
                span_i.className = "fa fa-money";
                var box_content = document.createElement("div");
                box_content.className = "info-box-content";
                var span_box_text = document.createElement("span");
                span_box_text.className = "info-box-text";
                span_box_text.innerText = myJson[i]["acc_name"];
                var span_box_number= document.createElement("span");
                span_box_number.className = "info-box-number";
                span_box_number.innerText = myJson[i]["balance"];
                var span_currency = document.createElement("span");
                span_currency.innerText = myJson[i]["currency"];
                var hidden_input = document.createElement('input');
                hidden_input.setAttribute("type","hidden");
                // hidden_input.value = myJson[i].acc_id;
                // hidden_input.id    = myJson[i].acc_id;
                if(myJson[i]["balance"] > 0){
                    span_box_number.style.color = "rgb(40, 203, 124)";
                }
                else{
                    span_box_number.style.color = "rgb(231, 76, 60)";
                }

                var hiddenField = document.getElementById('magicField');

                var check = myJson[i].acc_id;
                var delete_btn = document.createElement("i");
                delete_btn.className = "fa fa-trash";
                delete_btn.style.cssFloat = "right";
                delete_btn.style.marginRight = "15px";
                delete_btn.setAttribute('data-toggle','modal');
                delete_btn.addEventListener('click',function (check){
                    return function () {
                        $('#deleteAcc').modal('show');
                        document.getElementById('magicField').value = check;
                    }
                }(check));
                var edit_btn = document.createElement("i");
                edit_btn.setAttribute("data-toggle", "modal");
                edit_btn.addEventListener('click',function (check){
                    return function () {
                        $('#editAccount').modal('show');
                        document.getElementById('magicField').value = check;
                        document.getElementById("editAccBtn").setAttribute("data-dismiss", "modal");
                        showAccountInfo();
                    }
                }(check));
                edit_btn.className = "fa fa-pencil";
                edit_btn.style.cssFloat = "right";


                acc_main.appendChild(info_box);
                info_box.appendChild(span_info);
                info_box.appendChild(hidden_input);
                span_info.appendChild(span_i);
                info_box.appendChild(box_content);
                box_content.appendChild(span_box_text);
                box_content.appendChild(span_box_number);
                box_content.appendChild(span_currency);
                box_content.appendChild(edit_btn);
                box_content.appendChild(delete_btn);
            }
        })
        .catch(function (e) {
            alert(e.message);
        })
}

function addAccount() {
    var acc_name = document.getElementById('acc_name').value;
    var acc_type = document.getElementById('acc_type').value;
    var balance = document.getElementById('balance').value;
    var acc_currency = document.getElementById('acc_currency').value;

    fetch(config.url.accountRegistration,{
        method: "POST",
        headers: {'Content-type': 'application/x-www-form-urlencoded'},
        body: "acc_name=" + acc_name + "&acc_type=" + acc_type + "&balance=" + balance + "&acc_currency=" + acc_currency
    })
        .then(handleErrors)
        .then(function (myJson) {
            console.log(myJson);
            if(myJson.response === true){
                alert("You successfuly added an account!");
                fillAccounts();
                fillAvgAccounts();
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

function fillRecordsAccounts(){
    fetch(config.url.allAccounts)
        .then(function (response) {
            return response.json();
        })
        .then(function (myJson) {
            var cat_select = document.getElementById('accSelect');
            cat_select.innerHTML = "";
            cat_select.innerHTML = "<option selected value=\"none\">Choose...</option>";
            for (var i=0; i < myJson.length; i++){
                var option = document.createElement('option');
                option.value = myJson[i]["acc_id"];
                option.text = myJson[i]["acc_name"];
                cat_select.options.add(option,1);
            }
        })
        .catch(function (e) {
            alert(e.message);
        })
}

function fillAvgAccounts(){
    fetch(config.url.allAccounts)
        .then(function (response) {
            return response.json();
        })
        .then(function (myJson) {
            var cat_select_avg = document.getElementById('accSelectAvg');
            cat_select_avg.innerHTML = "";
            cat_select_avg.innerHTML = "<option selected value=\"0\">All</option>";
            for (var i=0; i < myJson.length; i++){
                var option = document.createElement('option');
                option.value = myJson[i]["acc_id"];
                option.text = myJson[i]["acc_name"];
                cat_select_avg.options.add(option,1);
            }
        })
        .catch(function (e) {
            alert(e.message);
        })
}

function fillCashFlowAccounts(){
    fetch(config.url.allAccounts)
        .then(function (response) {
            return response.json();
        })
        .then(function (myJson) {
            var cat_select_avg = document.getElementById('accSelectCashFlow');
            cat_select_avg.innerHTML = "";
            cat_select_avg.innerHTML = "<option selected value=\"0\">All</option>";
            for (var i=0; i < myJson.length; i++){
                var option = document.createElement('option');
                option.value = myJson[i]["acc_id"];
                option.text = myJson[i]["acc_name"];
                cat_select_avg.options.add(option,1);
            }
        })
        .catch(function (e) {
            alert(e.message);
        })
}

function fillTrendAccounts(){
    fetch(config.url.allAccounts)
        .then(function (response) {
            return response.json();
        })
        .then(function (myJson) {
            var cat_select_avg = document.getElementById('accSelectTrend');
            cat_select_avg.innerHTML = "";
            cat_select_avg.innerHTML = "<option selected value=\"0\">All</option>";
            for (var i=0; i < myJson.length; i++){
                var option = document.createElement('option');
                option.value = myJson[i]["acc_id"];
                option.text = myJson[i]["acc_name"];
                cat_select_avg.options.add(option,1);
            }
        })
        .catch(function (e) {
            alert(e.message);
        })
}

function fillDonutAccounts(){
    fetch(config.url.allAccounts)
        .then(function (response) {
            return response.json();
        })
        .then(function (myJson) {
            var cat_select_avg = document.getElementById('accSelectDonut');
            cat_select_avg.innerHTML = "";
            cat_select_avg.innerHTML = "<option selected value=\"0\">All</option>";
            for (var i=0; i < myJson.length; i++){
                var option = document.createElement('option');
                option.value = myJson[i]["acc_id"];
                option.text = myJson[i]["acc_name"];
                cat_select_avg.options.add(option,1);
            }
        })
        .catch(function (e) {
            alert(e.message);
        })
}

function editAccount() {
    var acc_id       = document.getElementById('magicField').value;
    var acc_name     = document.getElementById('new_acc_name').value;
    var acc_type     = document.getElementById('new_acc_type').value;
    var acc_currency = document.getElementById('new_acc_currency').value;
    var balance      = document.getElementById('new_balance').value;

    fetch(config.url.accountEdit,{
        method: "POST",
        headers: {'Content-type': 'application/x-www-form-urlencoded'},
        body:"acc_id=" + acc_id + "&acc_name=" + acc_name + "&acc_type=" + acc_type +
          "&acc_currency=" + acc_currency + "&balance=" + balance
    })
        .then(handleErrors)
        .then(function (myJson) {
            if (myJson.response === true){
                fillAccounts();
                alert("You just edited account!");
            }else {
                alert("Please try again!");
            }
        })
        .catch(function (e) {
            alert("The problem is " + e.message);
        })
}

function deleteAccount() {
    var deleteConf   = document.getElementById("deleteConf");
    var acc_id       = document.getElementById('magicField').value;

    if (deleteConf.value === "DELETE"){
        fetch(config.url.accountDelete,{
            method: "POST",
            headers: {'Content-type': 'application/x-www-form-urlencoded'},
            body: "acc_id=" + acc_id
        })
            .then(handleErrors)
            .then(function (myJson) {
                if (myJson.response === true){
                    document.getElementById("deleteConf").value = "";
                    alert("You just deleted an account!");
                    fillAccounts();
                }else {
                    alert("Please try again!");
                }
            })
            .catch(function (e) {
                location.href="./404.html";
            });
    }else {
        alert("Please type DELETE correctly!");
    }
}

function resetAccInputs() {
    document.getElementById("acc_name").value = "";
    document.getElementById("acc_type").selectedIndex = "none";
    document.getElementById("acc_currency").selectedIndex = "none";
    document.getElementById("balance").value = "";
}

function showAccountInfo() {
    var acc_id         = document.getElementById('magicField').value;
    var newAccName     = document.getElementById("new_acc_name");
    var newAccType     = document.getElementById("new_acc_type");
    var newAccCurrency = document.getElementById("new_acc_currency");
    var newBalance     = document.getElementById("new_balance");

    fetch(config.url.accountInfo,{
        method: "POST",
        headers: {'Content-type': 'application/x-www-form-urlencoded'},
        body:"acc_id=" + acc_id
    })
        .then(handleErrors)
        .then(function (myJson) {
            newAccName.value          = myJson.acc_name;
            newAccType.value          = myJson.acc_type;
            newAccCurrency.value      = myJson.currency;
            newBalance.value          = myJson.balance;
        })
        .catch(function (e) {
            location.href="./404.html";
        })
}