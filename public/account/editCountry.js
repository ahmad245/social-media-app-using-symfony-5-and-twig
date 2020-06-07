// get the country data from the plugin
var countryData = window.intlTelInputGlobals.getCountryData(),
  input = document.querySelector("#setting_phone"),
 // addressDropdown = document.querySelector("#account_address");
  addressDropdown = document.querySelector("#setting_country");


// init plugin
var iti = window.intlTelInput(input, {
  utilsScript: "../../build/js/utils.js?1585994360633" // just for formatting/placeholders etc
});


addressDropdown.addEventListener('change', function() {
 
  iti.setCountry(this.value);
});
