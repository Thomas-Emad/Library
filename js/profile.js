const input = document.querySelectorAll("form div input");
const label = document.querySelectorAll('label');
for (let i = 1; i < input.length; i++) {
  input[i].onclick = function ()  {
    label[i].classList.add("label_top");
  }
  if (input[i].value.length > 0) {
    label[i].classList.add("label_top");
  }
}

/* show password */
const inputPassword = document.querySelector('#password_label');
const showPassword = document.querySelector('#show');
let status = false;
showPassword.onclick = function () {
  if (status == false) {
    inputPassword.type = 'text';
    status = true;
  } else {
    inputPassword.type = 'password';
    status = false;
  }
}
