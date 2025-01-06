<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <img src="{{ $message->embed(asset('images/aestheticlogo.png')) }}" alt="Aesthetic Logo" class="h-12" width="120px"> 
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-12">
                <p>Dear {{ $data->FULLNAME }},</p>
                <p>We’re happy to inform you that your buyer account with Aesthetic has been successfully activated and is now ready to use.</p>
                <p>You can log in anytime to access our services. If you encounter any issues or have questions, feel free to contact us at contact@aestheticwebsite.com</p>
                <p>Thank you for choosing Aesthetic. We’re excited to have you with us!</p>

                <p>
                    Best regards,<br>
                    Aesthetic admin
                </p>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
  </body>
</html>