


let firstName = document.getElementById("firstName");
let lastName = document.getElementById("lastName");
let email = document.getElementById("email");
let submit = document.getElementById("submit");
let password = document.getElementById("password");
let confirmPassowrd = document.getElementById("confirmPassowrd");
let form = document.querySelector("form");

let isValid = {
  
  firstNameIsValid: firstName ? false : true,
  lastNameIsValid: lastName ? false : true,
  confirmPassowrdIsvalid: confirmPassowrd ? false : true,
  // phoneIsValid:pho,
  emailIsValid: false,
  passwordIsValid: false,

}

