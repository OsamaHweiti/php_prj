// Toggle password visibility
const userPasswordEl = document.querySelector("#password");
const togglePasswordEl = document.querySelector("#togglePassword");
const passwordConf = document.querySelector("#confirmpassword");
togglePasswordEl.addEventListener("click", function () {
  if (this.checked === true) {
    userPasswordEl.setAttribute("type", "text");
    passwordConf.setAttribute("type", "text");
  } else {
    userPasswordEl.setAttribute("type", "password");
    passwordConf.setAttribute("type", "password");
  }

});
function validate(event){
  event.preventDefault();

  const firstName = form.elements['firstName'].value;
  const lastName = form.elements['lastName'].value;
  const birthDate = form.elements['birthDate'].value;
  const email = form.elements['email'].value;
  const password = form.elements['password'].value;
  const confirmPassword = form.elements['confirmPassword'].value;
  const mobileNumber = form.elements['mobileNumber'].value;
  const position=form.elements['position'].value;

  // 1. Check if the name has just letters.
  const nameRegex = /^[A-Za-z]+$/;
  if (!nameRegex.test(firstName) || !nameRegex.test(lastName)) {
	
	return false;
  }

  // 2. Determine the birth date input and check for it in the right way
  // (You can add date validation here if required).

  // 3. Check the email structure by regular expression and use error handling
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!emailRegex.test(email)) {
	
	return false;
  }

  // 5. Password validation
  if (password !== confirmPassword) {
	return false;
  }

  const passwordRegex = /^(?=.*[A-Z])(?=.*[0-9]{2,})(?=.*[!@#$%^&*])[A-Za-z0-9!@#$%^&*]{8,32}$/;
  if (!passwordRegex.test(password)) {
	
	return false;
  }
  let mobileregx = /^\s*(?:\+?(\d{1,3}))?[-. (]*(\d{3})[-. )]*(\d{3})[-. ]*(\d{4})(?: *x(\d+))?\s*$/
  if (!mobileregx.test(mobileNumber)){
    return false;
  }
  

  // 6. Mobile number validation
  // (The pattern attribute on the input element will handle this validation)

  // If all validations pass, you can proceed with the form submission here.
  // For example, you can use AJAX to submit the form data to your server.

 // Store the user data in localStorage

  
 form.reset();
  
window.location.href = "./Login.html";}


logoutbtn.addEventListener('click', (e)=>{
  e.preventDefault();

})