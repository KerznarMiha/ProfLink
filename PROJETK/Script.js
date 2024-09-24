var modal = document.getElementById("login-modal");
var registerModal = document.getElementById("registerModal");
var btn = document.getElementById("login-btn");
var span = document.getElementsByClassName("close");
var registerLink = document.getElementById("registerLink");
var loginLink = document.getElementById("loginLink");

btn.onclick = function() {
    modal.style.display = "block"; 
}

registerLink.onclick = function() {
    modal.style.display = "none";  
    registerModal.style.display = "block"; 
}

loginLink.onclick = function() {
    registerModal.style.display = "none";  
    modal.style.display = "block";  
}

for (let i = 0; i < span.length; i++) {
    span[i].onclick = function() {
        modal.style.display = "none";  
        registerModal.style.display = "none";
    }
}

window.onclick = function(event) {
    if (event.target == modal || event.target == registerModal) {
        modal.style.display = "none"; 
        registerModal.style.display = "none";
    }
}
