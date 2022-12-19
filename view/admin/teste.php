<div id="print_button_container"></div>


<script src="https://www.google.com/cloudprint/client/cpgadget.js">
</script>
<script>
    window.onload = function() {
        var gadget = new cloudprint.Gadget();
        gadget.setPrintButton(
            cloudprint.Gadget.createDefaultPrintButton("print_button_container")); // div id to contain the button
        gadget.setPrintDocument("url", "My Document", "https://fluxdelivery.com.br");
    }
</script>
