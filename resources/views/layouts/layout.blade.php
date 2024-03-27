<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel='ico' type='image/x-icon' href="{{asset('img/favicon.ico')}}">
    <link rel="preload" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <title>Encuesta Satisfacción | Capacitaciones </title>
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <script href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" rel="stylesheet"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/htmx.org@1.7.0/dist/htmx.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function onSubmit(token) {
            validateReCaptcha(token);
        }

        function validateReCaptcha(token) {
            const formData = new FormData(document.getElementById("encuesta-form"));
            formData.append("g-recaptcha-response", token);

            fetch("https://utilities.regionloreto.gob.pe/api/feeback/capacitacion", {
                method: "POST",
                body: formData
            })
            .then(response => {
                if (response.status === 422) {
                    return response.json().then(errorData => {
                        Swal.fire({
                            title: "Error",
                            text: errorData.message || "Ocurrió un error al procesar la solicitud.",
                            icon: "error"
                        });
                        throw new Error('Error en la solicitud.');
                    });
                } else if (!response.ok) {
                    Swal.fire({
                        title: "Error",
                        text: "Ocurrió un error al procesar la solicitud.",
                        icon: "error"
                    });
                    throw new Error('Error en la solicitud.');
                }
                return response.json();
            })
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire({
                        title: "Éxito",
                        text: data.message,
                        icon: "success"
                    });
                } else {
                    Swal.fire({
                        title: "Error",
                        text: data.message || "Ocurrió un error al procesar la solicitud.",
                        icon: "error"
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    title: "Error",
                    text: error.message || "Ocurrió un error al procesar la solicitud.",
                    icon: "error"
                });
            });
        }
    </script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
  <body>
  @yield('body')
  </body>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("submitBtn").addEventListener("click", function(event) {
            event.preventDefault(); 
            grecaptcha.execute();
        });
    });
  </script>
</html>