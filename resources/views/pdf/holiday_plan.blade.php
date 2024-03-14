<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Awesome Holiday Plan</title>
    <style>
        body {
            background-color: #f8f9fa;
            color: #343a40;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            text-align: center;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            max-width: 600px;
            padding: 20px;
        }

        h1 {
            color: #dc3545;
            margin-bottom: 30px;
        }

        p {
            margin-bottom: 15px;
        }

        /* Additional styling for components */
        .card {
            border: 1px solid #dee2e6;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        /* Google Icons styling */
        .material-icons {
            font-size: 24px;
            vertical-align: middle;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>{{ $holidayPlan->title }}</h1>
        <div class="card">
            <div class="card-body">
                <p class="card-text"><strong>Created by:</strong> {{ $holidayPlan->user->name }}</p>
                <p class="card-text"><strong>Description:</strong> {{ $holidayPlan->description }}</p>
                <p class="card-text"><strong>Date:</strong> {{ $holidayPlan->date }}</p>
                <p class="card-text"><strong>Location:</strong> {{ $holidayPlan->location }}</p>
                @if ($holidayPlan->participantsGroups->isNotEmpty())
                    <p><strong>Participants:</strong></p>
                    <ul>
                        @foreach ($holidayPlan->participantsGroups as $participantGroup)
                            <li>{{ $participantGroup->participant->name }}</li>
                        @endforeach
                    </ul>
                @else
                    <p>No participants. You can add if you want</p>
                @endif
                <p class="card-text">This holiday plan was organized using the <strong>laraHolidaysAPI</strong> app.</p>
            </div>
        </div>
    </div>
</body>

</html>
