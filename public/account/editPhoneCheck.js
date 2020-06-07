var input = document.querySelector("#setting_phone"),
  errorMsg = document.querySelector("#error-msg"),
  validMsg = document.querySelector("#valid-msg");

// here, the index maps to the error code returned from getValidationError - see readme
var errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];

// initialise plugin
var iti = window.intlTelInput(input, {
  utilsScript: "../../build/js/utils.js?1562189064761"
});

var reset = function() {
  input.classList.remove("error");
  errorMsg.innerHTML = "";
  errorMsg.classList.add("hide");
  validMsg.classList.add("hide");
  
  
};

const phoneValid=()=>{

    reset();
    if (input.value.trim()) {
      if (iti.isValidNumber()) {
        validMsg.classList.remove("hide");
        isValid['phoneIsValid']=true;
        isValidForm();
 
   
        
      } else {
        input.classList.add("error");
        var errorCode = iti.getValidationError();
        errorMsg.innerHTML = errorMap[errorCode];
        errorMsg.classList.remove("hide");
        isValid['phoneIsValid']=false;
       
        isValidForm();
       
      }
    }
  }

// on blur: validate
input.addEventListener('input',phoneValid);
input.addEventListener('blur',phoneValid);

// on keyup / change flag: reset
input.addEventListener('change', reset);
input.addEventListener('keyup', reset);

