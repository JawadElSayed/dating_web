
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

// login
login_btn.addEventListener("click" , () => {
    dating_web.load_login(login_username.value, login_password.value);    
})
