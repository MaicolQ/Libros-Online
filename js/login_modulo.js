import { validarCampo, emailRegex, passwordRegex, estadoValidacionCampos, enviarFormulario } from "./register.js";

const formLogin = document.querySelector(".form-login");
const inputUser = document.querySelector(".form-login input[type='text']");
const inputEmail = document.querySelector(".form-login input[type='email']");
const inputPass = document.querySelector(".form-login input[type='password']");
const alertaErrorLogin = document.querySelector(".form-login .alerta-error")
const alertaExitoLogin = document.querySelector(".form-login .alerta-exito")

document.addEventListener("DOMContentLoaded", () => {
    formLogin.addEventListener("submit", e => {
        estadoValidacionCampos.userName = true;
        e.preventDefault();//evita que se envie el formulario y a que la pagina se recargue
        enviarFormulario(formLogin, alertaErrorLogin, alertaExitoLogin)
    });

    inputEmail.addEventListener("input", () => {
        validarCampo(emailRegex, inputEmail, "El correo solo puede contener letras, nùmeros, puntos, guiones y guion bajo.")
    })

    inputPass.addEventListener("input", () => {
        validarCampo(passwordRegex, inputPass, "La contraseña debe de ser de 4 a 12 digitos.")

    })
})

