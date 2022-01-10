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
        <h1>Report Answer</h1>
        <br>
        <h3>Dear {{$user->username}}, relative to the following {{$report->report_type}} report: </h3>
        <h5><i>{{$report->text}}</i></h5>
        <br>
        <h3>Answer:</h3>
        <h5>{{$answer}}</h5>
        <br>
        <h5>Thanks for planing with PlanWiser</h5>
    </body>
</html>
