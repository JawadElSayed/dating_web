
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