window.addEventListener("load", function() {

    /*User registration form validation*/
    var regForm     = document.querySelector("#register-user");
    var username    = regForm.querySelector("#username");
    var email       = regForm.querySelector("#email");
    var password1   = regForm.querySelector("#password1");
    var password2   = regForm.querySelector("#password2");
    var regSubmit   = regForm.querySelector("#register-submit");
    var inputElements = [username, email, password1, password2];

    /*Event listener for click on submit button*/
    regSubmit.addEventListener("click", function(e){
        /*Go through each element in form and check for value length*/
        inputElements.forEach(function(el){
            checkLength(el);
        });
        /*if length is 0 then add these input fields to empty array and append a css class*/
        empty.forEach(function(el){
            el.classList.add("required");
        });
        /*if length is not 0 then add these input fields to filled array and append a css class*/
        filled.forEach(function(el){
           el.classList.add("filled");
        });
        if(empty.length !== 0) {
            e.preventDefault();
        }
    });
});

var empty  = [];
var filled = [];

var checkLength = function(field) {
    return field.value.length === 0 ? empty.push(field) : filled.push(field);
};