// let form = document.querySelecter('form');

// form.addEventListener('submit', (e) => {
//   e.preventDefault();
//   return false;
// });

document.getElementById('confirm').onkeyup = function() {
    var password = $("#password").val();
    var confirm_password = $("#confirm").val();
    if (password != confirm_password) {
        $("#confirm").css('border-color', "red");
    } else {
        $("#confirm").css('border-color', "green");
    }
}