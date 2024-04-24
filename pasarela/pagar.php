<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://www.paypal.com/sdk/js?client-id=ASVy-56_L3Sqvf_vKh1i3mGuDwOzAIRtidvNeBYGI-uRTt2b1yXMoK5tRqX61vtugEjdynvJRJfIOjZl&currency=USD"></script>
</head>
<body>
    <div id="paypal-button-container"></div>

    <script>
        paypal.Buttons({
            style:{
                color: 'blue',
                shape: 'pill',
                label: 'pay'
            },
            createOrder: function(data, actions){
                return actions.order.create({
                    purchase_units: [{
                        amount:{
                            value: 10000
                        }
                    }]
                });
            },
            //en la funcion que esta dentro de la variable detalles, va a arrojar todo lo que pase en el pago
            onApprove: function(data, actions) {
                actions.order.capture().then(function (detalles){
                    console.log(detalles);
                    window.location.href="../index.php";
                });
            },
            //la funcion se va a disparar cuando el usuario cancele el pago
            onCancel: function(data) {
                alert("Pago cancelado");
                console.log(data);
            }
        }).render('#paypal-button-container');
    </script>
</body>
</html>
