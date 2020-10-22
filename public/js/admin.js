let userId;

function setUserForModeration(event,id){
    userId = id;
}

function banUser(event){
    event.preventDefault();

    let passwordElement = document.querySelector("#passwordCheckBan");
    let password = passwordElement.value;

    if(userId != undefined && userId != null){
        sendAjaxRequest('post', '/user/'+userId+'/ban', {password: password}, moderationResponse);
    }
} 

function unbanUser(event){
    event.preventDefault();

    let passwordElement = document.querySelector("#passwordCheckUnban");
    let password = passwordElement.value;

    if(userId != undefined && userId != null){
        sendAjaxRequest('post', 'user/'+userId+'/unban', {password: password}, moderationResponse);
    }
} 

function moderationResponse(){
    if(this.status == 200){
        if(document.querySelector(".admin_users_table") != undefined){
            sendAjaxRequest('get', 'users', {}, echoUsers);
        }
        else{
            let filter = document.querySelector(".modal-backdrop");
            
            let body = document.querySelector("body");
            body.removeChild(filter);
        }
    }
    else{
        let banError = document.querySelector("#banError");
        let unbanError = document.querySelector("#unbanError");
        banError.innerHTML = "Error: " +  this.responseText;
        unbanError.innerHTML = "Error: " +  this.responseText;
    }
}

function echoUsers(){
    if(this.status == 200){
        let content = document.querySelector("#content");
        content.innerHTML = this.responseText;

        let filter = document.querySelector(".modal-backdrop");
        
        let body = document.querySelector("body");
        body.removeChild(filter);
    }
    else{
        let banError = document.querySelector("#banError");
        let unbanError = document.querySelector("#unbanError");
        banError.innerHTML = "Error: unable to refresh user list";
        unbanError.innerHTML = "Error: unable to refresh user list";
    }
}
