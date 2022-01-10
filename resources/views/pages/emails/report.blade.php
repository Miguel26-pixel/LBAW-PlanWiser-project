<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
    </head>
    <body>
        <a href="/"><img src="{{ asset('/images/planwiserlogo.png') }}" style="width: 200px;"/></a>
        <h1>Report</h1>
        <br>
        <h3>User: {{$user->username}}</h3>
        <br>
        <h3>Type: {{$report->report_type}}</h3>
        <br>
        <?php
        if ($report->report_type == "USER") {
            echo '<h3>User Reported: '.$user_reported->username.'</h3>';
        }
        ?>
        <h3>Report:</h3>
        <h3>{{$report->text}}</h3>
    </body>
</html>
