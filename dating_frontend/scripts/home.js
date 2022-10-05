
// variables
const id = localStorage.getItem("id");
const token = localStorage.getItem("token");
const users_bar = document.getElementById("users_bar");



const getHome = async (token) => {
    const users = await dating_web.users(token);
    let all_users = "";

    for (let user of users.users){
        let distance = user.distance.toFixed(2);
        all_users += adduser(user.profile_img, user.username, user.gender,distance);
    }
    // console.log(all_users);
    users_bar.innerHTML = all_users;
}

const adduser = (profile, username, gender, distance) => {
    const user = `<div class="one_user">
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

getHome(token);
