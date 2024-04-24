const formRegister = document.querySelector(".form-register");
const inputUser = document.querySelector(".form-register input[type='text']");
const inputEmail = document.querySelector(".form-register input[type='email']");
const inputPass = document.querySelector(".form-register input[type='password']");
const alertaError = document.querySelector(".alerta-error")
const alertaExito = document.querySelector(".alerta-exito")

//expresiones Regulares son patrones que nos permiten validar los campos
const userNameRegex = /^[a-zA-Z0-9\_\-]{4,16}$/;
export const emailRegex = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/;
export const passwordRegex = /^.{4,12}$/;

//almacenar valores booleanos
export const estadoValidacionCampos = {
    userName: false,
    userEmail: false,
    userPassword: false,
};

document.addEventListener("DOMContentLoaded", () => {
    formRegister.addEventListener("submit", e => {
        e.preventDefault();//evita que se envie el formulario y a que la pagina se recargue
        enviarFormulario(formRegister, alertaError, alertaExito)
    });

    inputUser.addEventListener("input", () => {
        validarCampo(userNameRegex, inputUser, "El usuario tiene que ser de 4 a 16 digitos y solo puede contener, letras y guion bajo.")
    })

    inputEmail.addEventListener("input", () => {
        validarCampo(emailRegex, inputEmail, "El correo solo puede contener letras, nùmeros, puntos, guiones y guion bajo.")
    })

    inputPass.addEventListener("input", () => {
        validarCampo(passwordRegex, inputPass, "La contraseña debe de ser de 4 a 12 digitos.")

    })
})
//valida el campo si es falso o verdadero, es decir segun el limite de cararcteres que permite sera falso o verdadero
export function validarCampo(regularExpresion, campo, mensaje){
    const validarCampo = regularExpresion.test(campo.value);
  if (validarCampo) {
    eliminarAlerta(campo.parentElement.parentElement)
    estadoValidacionCampos[campo.name] = true;//validamos campos a verdadero
    campo.parentElement.classList.remove("error");//remueve el borde de error de nuestro label
    return;
  }
  estadoValidacionCampos[campo.name] = false;
    mostrarAlerta(campo.parentElement.parentElement,mensaje)
    campo.parentElement.classList.add("error");
  }

function mostrarAlerta(referencia, mensaje) {
    eliminarAlerta(referencia)//eliminamos los duplicados de las alertas
    const alertaDiv = document.createElement("div");
    alertaDiv.classList.add("alerta");
    alertaDiv.textContent = mensaje;
    referencia.appendChild(alertaDiv)//agregar un elemento dentro de otro elemento
}

function eliminarAlerta(referencia) {
    const alerta = referencia.querySelector(".alerta");//busca un alerta desde el inicio hasta el final
    
    if (alerta) alerta.remove()
}




export function enviarFormulario(form, alertaError, alertaExito,) {
    //valida el envio del formulario
    if(estadoValidacionCampos.userName && estadoValidacionCampos.userEmail && estadoValidacionCampos.userPassword){
        alertaExito.classList.add("alertaExito");//si todos los campo son correctos agregamos alerta exito pero quitamos la alerta error
        alertaError.classList.remove("alertaError");
        form.reset()
        //despues de 3 segundos se desaparecera la alerta
        setTimeout(() => {
            alertaExito.classList.remove("alertaExito");
        }, 3000);
        return;
    }
    alertaExito.classList.remove("alertaExito");//en caso de sean los campos incorrectos quitamos la alerta exto y agregamos la alrta error
    alertaError.classList.add("alertaError");
    setTimeout(() => {
        alertaError.classList.remove("alertaError");
    }, 3000);
}
