<?php
include '../html/header.html';
?>

<!-- <head>
<title>Compra</title>
    <script
        src="https://sandbox.paypal.com/sdk/js?client-id=ASn3NZdlgFzkACfvTkx7k1TDb6VCFQTnDbiOrxnf9p62C-TaoVFIPQYSX9YnihfnCxc_VMKkmL7cQkiq&amp;currency=MXN&amp;locale=es_MX&amp;components=buttons"
        data-uid-auto="uid_fhbvmixthzieuaiissdjhttpumbzdh"></script>
</head> -->

<head>
    <title>Compra</title>
    <link rel="preload" href="../css/styles-contact.css" as="style">
    <link href="../css/styles-contact.css" rel="stylesheet">

    <script
        src="https://sandbox.paypal.com/sdk/js?client-id=ASn3NZdlgFzkACfvTkx7k1TDb6VCFQTnDbiOrxnf9p62C-TaoVFIPQYSX9YnihfnCxc_VMKkmL7cQkiq&amp;currency=MXN&amp;locale=es_MX&amp;components=buttons"
        data-uid-auto="uid_fhbvmixthzieuaiissdjhttpumbzdh"></script>

</head>
<main>
    <form>
        <h2 class="title-contacto">Domicilio</h2>
        <div class="input-group">

            <label for="name">Direccion</label>
            <input type="text" name="direccion" id="">

            <label for="phone">Codigo Postal</label>
            <input type="text" name="cPostla" id="">

            <label for="phone">Estado</label>
            <input type="phone" name="estado" id="">

            <label for="message">Municipio</label>
            <input type="text" name="municipio" id="">
        </div>

        <h2 class=title-contacto>Datos Contacto</h3>
            <div class="input-group">
                <label for="name">Nombre y Apellido</label>
                <input type="text" name="nomApe" id="">

                <label for="phone">Telefono</label>
                <input type="text" name="telefono" id="">
            </div>

            <div id=paypal-button-container></div>

            <script>
                paypal.Buttons({
                    style: {
                        color: 'blue',
                        shape: 'pill',
                        label: 'pay'
                    },
                    createOrder: function (data, actions) {
                        return actions.order.create({
                            purchase_units: [{
                                amount: {
                                    value: 100//base de datos obteniendo el precio
                                }
                            }]
                        });
                    },

                    onApprove: function (data, actions) {
                        actions.order.capture().then(function (detalles) {
                            console.log(detalles);
                        });
                    },

                    onCancel: function (data) {
                        alert("Pago cancelado");
                        console.log(data);
                    }
                }).render('#paypal-button-container');
            </script>

    </form>
</main>