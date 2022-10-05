
// animation sign up modal
var modal = document.getElementById("sign_up_modal");
var btn = document.getElementById("CreateAccount");
var x_btn = document.getElementsByClassName("close")[0];

//open the modal
btn.onclick = function() {
  modal.style.display = "block";
}

// close the modal on (X)
x_btn.onclick = function() {
  modal.style.display = "none";
}

// close the modal on clicking outside
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}

// variables
const login_username = document.getElementById("login_username");
const login_password = document.getElementById("login_password");
const login_btn = document.getElementById("login_btn");
const signup_name = document.getElementById("signup_name");
const signup_username = document.getElementById("signup_username");
const signup_gender = document.getElementById("signup_gender");
const signup_interested_in = document.getElementById("signup_interested_in");
const signup_location = document.getElementById("location");
const signup_password = document.getElementById("signup_password");
const signup_btn = document.getElementById("signup_btn");
const error = document.getElementById("error");
let Latitude = "";
let Longitude = "";

// login
login_btn.addEventListener("click" , () => {
    dating_web.load_login(login_username.value, login_password.value);    
})

// get location
signup_location.addEventListener("click", () => {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(getcoords);
  } else { 
    error.innerHTML = "Geolocation is not supported by this browser.";
  }

})

function getcoords(position) {
    Latitude= position.coords.latitude; 
    Longitude = position.coords.longitude;
}

// signup
signup_btn.addEventListener("click" , () => {
    const data =  {
        "name" : signup_name.value,
        "username" : signup_username.value,
        "gender" : signup_gender.value,
        "interested_in" : signup_interested_in.value,
        "Latitude" : Latitude.toString(),
        "Longitude" : Longitude.toString(),
        "password" : signup_password.value
    };
    console.log(data);
    dating_web.signup(data);    
})
