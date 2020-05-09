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
      removeStyleElements(event.target);
      isValid[object.isvalid] = true;
      return true;
    }
  } else {
    small.innerText = "";
    removeStyleElements(event.target);
    isValid[object.isvalid] = true;
    return true;
  }
}
const passwordValid = (object, event) => {
 
  const {
    small,
    value
  } = init(event);
  if (!CheckPassword(value)) {
    createMessage(small, object.passMessage);
    isValid[object.isvalid] = false;
    addStyleElement(small, event.target);
   
    console.log(isValid);
    return false;
  } else {
    small.innerText = "";
    isValid[object.isvalid] = true;
    removeStyleElements(event.target);
   
    return true;
  }
}
  
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
      passMessage: ' Password  must contain at least one numeric digit, one uppercase and one lowercase letter'
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
      passMessage: ' Password  must contain at least one numeric digit, one uppercase and one lowercase letter'
    })
  );

  // form.addEventListener('submit', (event) => {
 
  
  // })
  triggerForm();
  triggerFormfocusout()
  isValidForm();


  