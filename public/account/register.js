
let firstName = document.getElementById("account_firstName");
let lastName = document.getElementById("account_lastName");
let email = document.getElementById("account_email");
let submit = document.getElementById("submit");
let password = document.getElementById("account_password");
let confirmPassowrd = document.getElementById("account_confirmPassword");


let introduction = document.getElementById("account_introduction");
let bio = document.getElementById("account_bio");
let address = document.querySelector("#account_address");
let tel = document.querySelector("#account_phone");


let form = document.querySelector("form");

let birth=document.getElementById('account_birthday');

//M.AutoInit();
// document.addEventListener('DOMContentLoaded', function() {
//   var elems = document.querySelectorAll('select');
//   var instances = M.FormSelect.init(elems, {});
// });


document.addEventListener('DOMContentLoaded', function() {
  let region=document.getElementById('account_region');
  var instancesRegion = M.FormSelect.init(region, {});
  
  var elemsSelect = document.querySelector('#account_country');
  var instancesSelect = M.FormSelect.init(elemsSelect, {});

//  var elemsSelect = document.querySelector('#account_address');
//  var instancesSelect = M.FormSelect.init(elemsSelect, {});

 let elems;
 let instances;
   elems = document.querySelector('.datepicker');
   instances = M.Datepicker.init(elems, {});
   instances.setDate(new Date());

});

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



const NameValid = (object, event) => {
    const {
      small,
      value
    } = init(event);
    if (isEmpty(value)) {
      createMessage(small, object.message);
      isValid[object.isvalid] = false;
      addStyleElement(small, event.target);
     
      return false;
    } else {
      small.innerText = "";
      removeStyleElements(event.target);
      isValid[object.isvalid] = true;
      return true;
    }
  }
  
  
  
  const emailValid = (object, event) => {
    const {
      small,
      value
    } = init(event);
    if (isEmpty(value)) {
      createMessage(small, object.message);
      isValid[object.isvalid] = false;
      addStyleElement(small, event.target);
      
      return false;
    } else if (object.messageEmaile) {
      if (!isValidEmail(event.target.value)) {
        createMessage(small, object.messageEmaile);
        isValid[object.isvalid] = false;
        addStyleElement(small, event.target);
        
        return false;
      } else {
        small.innerText = "";
        isValid[object.isvalid] = true;
        removeStyleElements(event.target);
       
        return true;
      }
    } else {
      small.innerText = "";
      isValid[object.isvalid] = true;
      removeStyleElements(event.target);
     
      return true;
    }
  }
  const passwordValid = (object, event) => {
    const {
      small,
      value
    } = init(event);
    if (isEmpty(value)) {
      createMessage(small, object.message);
      isValid[object.isvalid] = false;
      addStyleElement(small, event.target);
      
      return false;
    } else if (!chechLength(value, 6, 20)) {
      createMessage(small, object.minMessage);
      isValid[object.isvalid] = false;
      addStyleElement(small, event.target);
      
      return false;
    } else if (!CheckPassword(value)) {
      
      createMessage(small, object.passMessage);
      isValid[object.isvalid] = false;
      addStyleElement(small, event.target);
      
      return false;
    } else {
      small.innerText = "";
      isValid[object.isvalid] = true;
      removeStyleElements(event.target);
     
      return true;
    }
  }
  const confirmPassowrdValid = (object, event) => {
    const {
      small,
      value
    } = init(event);
    if (isEmpty(value)) {
      createMessage(small, object.message);
      addStyleElement(small, event.target);
      isValid[object.isvalid] = false;
      return false;
    }else if(!chechPasswordMatch(value,password.value)){
      createMessage(small, object.matchMessage);
      addStyleElement(small, event.target);
      isValid[object.isvalid] = false;
      return false;
    } 
    else {
      small.innerText = "";
      isValid[object.isvalid] = true;
      removeStyleElements(event.target);
     
      return true;
    }
  }
  
  //////////////////////// input event
  firstName.addEventListener(
    "input",
    NameValid.bind(null, {
      message: "this first name is required",
      isvalid: 'firstNameIsValid',
      min: 1,
      max: 20
    })
  );
  lastName.addEventListener(
    "input",
    NameValid.bind(null, {
      message: "this last  name is required",
      isvalid: 'lastNameIsValid',
      min: 1,
      max: 20
    })
  );
  
  email.addEventListener(
    "input",
    emailValid.bind(null, {
      message: "this email is required",
      messageEmaile: "this is not valid email",
      isvalid: 'emailIsValid'
    })
  );
  password.addEventListener(
    "input",
    passwordValid.bind(null, {
      message: "this password is required",
      isvalid: 'passwordIsValid',
      min: 6,
      max: 20,
      minMessage: 'must have at least 1',
      maxMessage: 'must have at most 20 ',
      passMessage: 'Input Password and Submit [6 to 20 characters which contain at least one numeric digit, one uppercase and one lowercase letter]'
    })
  );
  confirmPassowrd.addEventListener(
    "input",
    confirmPassowrdValid.bind(null, {
      message: "this confirmPassowrd is required",
      isvalid: 'confirmPassowrdIsvalid',
      matchMessage:'must be match password'
    })
  );
  
  /////////////////////focusout EVENT
  firstName.addEventListener(
    "focusout",
    NameValid.bind(null, {
      message: "this first name is required",
      isvalid: 'firstNameIsValid'
    })
  );
  lastName.addEventListener(
    "focusout",
    NameValid.bind(null, {
      message: "this last  name is required",
      isvalid: 'lastNameIsValid'
    })
  );
  email.addEventListener(
    "focusout",
    emailValid.bind(null, {
      message: "this email is required",
      messageEmaile: "this is not valid email",
      isvalid: 'emailIsValid'
    })
  );
  password.addEventListener(
    "focusout",
    passwordValid.bind(null, {
      message: "this password is required",
      isvalid: 'passwordIsValid',
      min: 6,
      max: 20,
      minMessage: 'must have at least 1',
      maxMessage: 'must have at most 20 ',
      passMessage: 'Input Password and Submit [6 to 20 characters which contain at least one numeric digit, one uppercase and one lowercase letter]'
    })
  );
  confirmPassowrd.addEventListener(
    "focusout",
    confirmPassowrdValid.bind(null, {
      message: "this confirmPassowrd is required",
      isvalid: 'confirmPassowrdIsvalid'
    })
  );
  
  triggerFormRegister();
  triggerFormfocusoutRegister();
  
  
  ///////////////////From SUBMIT
 
  isValidForm();

  // submit.addEventListener('click',(event)=>{
   
  //   event.preventDefault();
  //   // var elem = document.querySelector('.datepicker'); 
  //   //  elem.value=new Date(elem.velue);
  //   instances.setDate(new Date());
  //   console.log(birth.value);
  //   birth.value=new Date(birth.value);
  //   console.log(typeof birth.value);
    
     
  // })

  const createIcon=(text,prefix=true)=>{
    let i=document.createElement('i');
    i.classList.add('material-icons');
    
    if (prefix) {
      i.classList.add('prefix');
    }
   
    i.innerText=text;
    return i;
  }

  const addIcons=()=>{
    firstName.insertAdjacentElement('beforebegin',createIcon('account_circle'));
    lastName.insertAdjacentElement('beforebegin',createIcon('account_circle'));
    email.insertAdjacentElement('beforebegin',createIcon('email'));
    password.insertAdjacentElement('beforebegin',createIcon('remove_red_eye'));
    confirmPassowrd.insertAdjacentElement('beforebegin',createIcon('remove_red_eye'));
    birth.insertAdjacentElement('beforebegin',createIcon('date_range'));
  
    introduction.insertAdjacentElement('beforebegin',createIcon('announcement'));
    bio.insertAdjacentElement('beforebegin',createIcon('event_note'));
    address.parentElement.insertAdjacentElement('beforebegin',createIcon('location_city'));
    tel.parentElement.insertAdjacentElement('beforebegin',createIcon('phone',false));
  }
  addIcons();