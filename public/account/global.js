


let firstName = document.getElementById("firstName");
let lastName = document.getElementById("lastName");
let email = document.getElementById("email");
let submit = document.getElementById("submit");
let password = document.getElementById("password");
let confirmPassowrd = document.getElementById("confirmPassowrd");
let form = document.querySelector("form");
// M.AutoInit();
// document.addEventListener('DOMContentLoaded', function() {
//   var elems = document.querySelectorAll('.datepicker');
//   var instances = M.Datepicker.init(elems, {});
// });
// document.addEventListener('DOMContentLoaded', function() {
//   var elems = document.querySelectorAll('select');
//   var instances = M.FormSelect.init(elems, {});
// });
let isValid = {
  
  firstNameIsValid: firstName ? false : true,
  lastNameIsValid: lastName ? false : true,
  confirmPassowrdIsvalid: confirmPassowrd ? false : true,
  // phoneIsValid:pho,
  emailIsValid: false,
  passwordIsValid: false,

}

// let isValidRegister={
//     firstNameIsValid: false,
//   lastNameIsValid: false,
// emailIsValid: false,
// passwordIsValid: false,
//   confirmPassowrdIsvalid: false,
//   phoneIsValid:false
// }

