<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel Vue CRUD Application</title>
    <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">
</head>



<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    Restricted Admin page!
                </div>
            </div>
        </div>
    </div>

    <smbeditor :options="{{$players}}"></smbeditor>

</x-app-layout>



</html>
