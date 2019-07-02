function logout() {
    fetch(config.url.logout)
        .then(function (response) {
            return response.json();
        })
        .then(function (myJson) {
            if(myJson.message === "true"){
                location.href=config.url.baseURL;
                console.log("ok");
            }
        })
        .catch(function (e) {
            alert(e.message);
        })
}