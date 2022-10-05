
// variables
const id = localStorage.getItem("id");
const token = localStorage.getItem("token");
const users_bar = document.getElementById("users_bar");
const messages_inbox = document.getElementById("messages");
const send_btn = document.getElementById("send_btn");
const messege_text = document.getElementById("message_input");





// get interested in users
const getHome = async (token) => {
    const users = await dating_web.users(token);
    let all_users = "";

    for (let user of users.users){
        let distance = user.distance.toFixed(2);
        all_users += adduser(user.id, user.profile_img, user.username, user.gender,distance);
    }
    users_bar.innerHTML = all_users;
    const list = document.querySelectorAll(".one_user")

    let resever = "";
    for (let user of list){
        user.addEventListener("click", async () =>{
            const data = {
                "id" : user.id,
            }
            messages(data, token)
            resever = user.id;
        });
    }

    send_btn.addEventListener("click", async () => {
        if (messege_text.value != ""){
            const data = {
                "resever" : resever,
                "message" : messege_text.value
            }
            await dating_web.send(data, token);
            messege_text.value = "";
        }
    });
    
}

// get messages 
const messages = async (data, token) => {
    const inbox = await dating_web.messages(data, token);
    let all_messages = "";

    for (let message of inbox.messages){
        if (message.sender_id == id){
            all_messages += getchat("sender", message.message);
        }
        else{
            all_messages += getchat("resever", message.message);
        }
    }
    messages_inbox.innerHTML = all_messages;
}

// add user to left bar
const adduser = (id, profile, username, gender, distance) => {
    const user = `<div id="${id}" class="one_user">
                    <div>
                        <img class="user_img" src="${profile}" alt="proflie">
                    </div>
                    <div class="user_info">
                        <h2>${username}</h2>
                        <h3>${gender}</h3>
                        <p>${distance}Km</p>
                    </div>
                </div>`;
    return user;
}

// get chat
const getchat = (sender, message) => {
    const chat = `<div class="${sender}">
                        <p>${message}</p>
                    </div>`;
    return chat;
}

const sendMessage = async (sender, resever, message) => {

}

// console.log(token);
getHome(token);

// messages(test,token);