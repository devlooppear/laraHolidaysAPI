<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Holiday Plan Created</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-color: #f8f9fa;
            color: #343a40;
        }

        .container {
            max-width: 600px;
            margin: 1em auto;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #dc3545;
            color: #ffffff;
            border-radius: 15px 15px 0 0;
            padding: 15px;
        }

        .card-body {
            padding: 20px;
        }

        h1 {
            color: #ebebeb;
            margin: 10px 20px;
        }

        p {
            margin-bottom: 20px;
        }

        a.btn {
            display: inline-block;
            margin: 8px 0px;
            padding: 10px 20px;
            background-color: #343a40;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-header text-center">
                <h1>Holiday Plan Created</h1>
            </div>
            <div class="card-body">
                <p>Your holiday plan has been created successfully. Click the button below to generate a PDF with
                    holiday information.</p>

                <a href="{{ route('generate-pdf', ['id' => $holidayPlan->id]) }}" class="btn">Generate PDF</a>

                <p>Enjoy your the holiday hahah</p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
