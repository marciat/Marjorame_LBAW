'use strict'

function addEventListeners() {
    document.querySelector("#Tab_Sign_in").addEventListener('click', Sign_in_tab_event)
    document.querySelector("#tab_Sign_in").addEventListener('click', Sign_in_tab_event)
    document.querySelector("#tab_Register").addEventListener('click', big_register_event)
    document.querySelector("#Tab_Register").addEventListener('click', big_register_event)
}

function Sign_in_tab_event(event) {
    document.querySelector("#RegisterUsername").remove()
    document.querySelector(".form-signin .row").remove()
    document.querySelector("#registerEmail").remove()
    document.querySelector("#registerDate").remove()
    document.querySelector("#registerPassword").remove()
    document.querySelector("#registerPassword1").remove()
    document.querySelector(".form-signin p").remove()
    document.querySelector("#Register").remove()
    document.querySelector("#register_with_Google").remove()

    let signInputEmail = document.createElement("input")
    signInputEmail.type = "text"
    signInputEmail.setAttribute("id", "SignInputEmail")
    signInputEmail.className = "form-control";
    signInputEmail.placeholder = "Email or Username"
    signInputEmail.required = true
    document.querySelector(".form-signin").appendChild(signInputEmail)

    let SignInputPassword = document.createElement("input")
    SignInputPassword.type = "password"
    SignInputPassword.setAttribute("id", "SignInputPassword")
    SignInputPassword.className = "form-control";
    SignInputPassword.placeholder = "Password"
    SignInputPassword.required = true
    document.querySelector(".form-signin").appendChild(SignInputPassword)

    let forgot_password = document.createElement("p")
    forgot_password.setAttribute("id", "forgot_password")
    forgot_password.innerHTML = "Forgot your password?"
    document.querySelector(".form-signin").appendChild(forgot_password)

    let sign_in = document.createElement("button")
    sign_in.setAttribute("id", "Sign_in")
    sign_in.className = "sign_btn"
    sign_in.type = "submit"
    sign_in.innerHTML = "Sign In"
    document.querySelector(".form-signin").appendChild(sign_in)

    let sign_in_Google = document.createElement("button")
    sign_in_Google.setAttribute("id", "Sign_in_Google")
    sign_in_Google.className = "btn btn-lg btn-primary btn-block"
    sign_in_Google.type = "submit"
    sign_in_Google.innerHTML = "Sign In with Google"
    document.querySelector(".form-signin").appendChild(sign_in_Google)

    event.preventDefault()
}

function big_register_event(event) {
    document.querySelector("#SignInputEmail").remove()
    document.querySelector("#SignInputPassword").remove()
    document.querySelector("#forgot_password").remove()

    document.querySelector("#Sign_in").remove()
    document.querySelector("#Sign_in_Google").remove()

    let RegisterUsername = document.createElement("input")
    RegisterUsername.type = "text"
    RegisterUsername.setAttribute("id", "RegisterUsername")
    RegisterUsername.className = "form-control";
    RegisterUsername.placeholder = "Username"
    RegisterUsername.required = true
    document.querySelector(".form-signin").appendChild(RegisterUsername)

    let fRow = document.createElement("div")
    fRow.className = "col-md-6"
    let sRow = document.createElement("div")
    sRow.className = "col-md-6"

    let inputFName = document.createElement("input")
    inputFName.type = "text"
    inputFName.setAttribute("id", "inputFName")
    inputFName.className = "form-control";
    inputFName.placeholder = "First Name"
    inputFName.required = true
    fRow.appendChild(inputFName)

    let inputLName = document.createElement("input")
    inputLName.type = "text"
    inputLName.setAttribute("id", "inputLName")
    inputLName.className = "form-control";
    inputLName.placeholder = "Last Name"
    inputLName.required = true
    sRow.appendChild(inputLName)

    let row = document.createElement("div")
    row.className = "row"
    row.appendChild(fRow)
    row.appendChild(sRow)

    document.querySelector(".form-signin").appendChild(row)

    let registerEmail = document.createElement("input")
    registerEmail.type = "email"
    registerEmail.setAttribute("id", "registerEmail")
    registerEmail.className = "form-control";
    registerEmail.placeholder = "Email"
    registerEmail.required = true
    document.querySelector(".form-signin").appendChild(registerEmail)

    let registerDate = document.createElement("input")
    registerDate.type = "date"
    registerDate.setAttribute("id", "registerDate")
    registerDate.className = "form-control";
    registerDate.placeholder = "Date of Birth"
    registerDate.required = true
    document.querySelector(".form-signin").appendChild(registerDate)

    let registerPassword = document.createElement("input")
    registerPassword.type = "password"
    registerPassword.setAttribute("id", "registerPassword")
    registerPassword.className = "form-control";
    registerPassword.placeholder = "Password"
    registerPassword.required = true
    document.querySelector(".form-signin").appendChild(registerPassword)

    let registerPassword1 = document.createElement("input")
    registerPassword1.type = "password"
    registerPassword1.setAttribute("id", "registerPassword1")
    registerPassword1.className = "form-control";
    registerPassword1.placeholder = "Confirm Password"
    registerPassword1.required = true
    document.querySelector(".form-signin").appendChild(registerPassword1)

    let terms = document.createElement("input")
    terms.label = "I have read and accept the terms of service, and confirm I am at least 16 years of age"
    terms.type = "checkbox"
    terms.setAttribute("id", "acceptTerms")
    terms.className = "form-control";
    registerPassword1.required = true

    let checkbox = document.createElement("input")
    checkbox.className = "form-check-input"
    checkbox.type = "checkbox" 
    checkbox.id = "terms_checkbox"
    checkbox.required = true

    terms.appendChild(checkbox)
    document.querySelector(".form-signin").appendChild(terms)

    let Register = document.createElement("button")
    Register.setAttribute("id", "Register")
    Register.className = "sign_btn"
    Register.type = "submit"
    Register.innerHTML = "Register"
    document.querySelector(".form-signin").appendChild(Register)

    let register_with_Google = document.createElement("button")
    register_with_Google.setAttribute("id", "register_with_Google")
    register_with_Google.className = "btn btn-lg btn-primary btn-block"
    register_with_Google.type = "submit"
    register_with_Google.innerHTML = "Register with Google"
    document.querySelector(".form-signin").appendChild(register_with_Google)

    event.preventDefault()
}

addEventListeners()