//aca le damos el cambio de formularios
const btnSignIn = document.getElementById("sign-in");
      btnSignUp = document.getElementById("sign-up");
      containerFormRegister = document.querySelector(".register");
      containerFormLogin = document.querySelector(".login");

//aca lo que hacemos es un cambio de formulario, el que este arriba baje y el otro
btnSignIn.addEventListener("click", e => {
    containerFormRegister.classList.add("hide");
    containerFormLogin.classList.remove("hide");//removemos el otro formulario para que aparezca el otro
})     

btnSignUp.addEventListener("click", e => {
    containerFormLogin.classList.add("hide");
    containerFormRegister.classList.remove("hide");//borra la clase hide
})     