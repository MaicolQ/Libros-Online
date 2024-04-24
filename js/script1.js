function procesarOpcion() {
    var opcionGratis = document.getElementById("opcionGratis");
    var opcionDePago = document.getElementById("opcionDePago");
    var precioInput = document.getElementById("precioInput");

    console.log("Procesando opción...");
  
    if (opcionGratis.checked) {
        console.log("Opción gratis seleccionada.");
      // No hacer nada
      // Ocultar el input de precio si se seleccionó la opción gratis
      precioInput.style.display = "none";
    } else if (opcionDePago.checked) {
        console.log("Opción de pago seleccionada.");
      precioInput.style.display = "block";
    } else {
        console.log("Ninguna opción seleccionada.");
      alert("Por favor, selecciona una opción.");
    }
  }