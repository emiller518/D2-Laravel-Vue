<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel Vue CRUD Application</title>
    <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">
</head>

<body>

{{--    @extends('layouts.app')--}}
{{--    @section('content')--}}
{{--        <example-component></example-component>--}}
{{--    @endsection--}}

    <div id="q">
        <mysection pid="{{$id}}"></mysection>
    </div>


</body>

<script src="{{mix('js/app.js')}}"></script>

</html>
