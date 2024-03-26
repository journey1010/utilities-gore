<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel='icon' type='image/x-icon' href="{{asset('img/favicon.ico')}}"">
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

            fetch("https://utilities.gob.pe/api/feeback/capacitacion", {
                method: "POST",
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                  Swal.fire({
                    title: "Error",
                    text: response.data.message,
                    icon: "error"
                  });
                }
                return response.json();
            })
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire({
                      title: "Exito",
                      text: data.message
                      icon: "success"
                    });
                } else {
                  Swal.fire({
                      title: "Exito",
                      text: data.message
                      icon: "success"
                  });
                }
            })
            .catch(error => {
              Swal.fire({
                      title: "Exito",
                      text: error
                      icon: "success"
              });
            });
        }
        document.getElementById("submitBtn").addEventListener("click", function() {
            grecaptcha.execute();
        });

    </script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
  <body>
  @yield('body')
  </body>
</html>