<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<script src="{{ mix('js/app.js') }}"></script>
<script src="/resources/js/validation.js"></script>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Javascript</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
</head>


<body class="antialiased bg-gray-200">
<p>delete me</p>


<div class="flex justify-between">Todo app</div>

<div id="addtask" class="bg-green-500 mx-auto my-20 max-w-screen-md">

    <h1 class="text-center pt-6 font-bold text-3xl">Create Task</h1>

    <div class="grid grid-cols-1 place-items-center p-6" id="input">

        <form id="myForm">
            <div class="p-2">
                <label>Task:</label>
                <input type="text" id="taskNameInput" name="taskNameInput">

            </div>

            <div class="p-2">
                <label>Type:</label>
                <select name="type" id="type">
                    <option value="Personal">Personal</option>
                    <option value="Work">Work</option>
                </select>
            </div>

            <div class="p-2">
                <label>Estimated Hours:</label>
                <input type="number" id="estimatedHoursInput" min="0" step="1"/>
            </div>
        </form>
    </div>


    <div class="task-buttons flex" id="create-buttons">
        <input class="mr-2 bg-amber-200 rounded p-3 hover:bg-amber-400 m-3" type="button" value="+ Add Sub-Task" onclick="addSubTask()">
        <input class="mr-2 bg-amber-200 rounded p-3 hover:bg-amber-400 m-3" type="button" value="Clear" onclick="clearTaskInput()">
        <input class="mr-2 bg-amber-200 rounded p-3 hover:bg-amber-400 m-3" type="button" value="Submit" onclick="submitTask()">
    </div>

</div>


<div id="displayTasks" class="container mx-auto max-w-screen-2xl bg-blue-500"></div>

</body>
</html>





<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
</svg>

<div id="svgtest"></div>




<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewbox="0 0 24 24" stroke="currentColor" stroke-width="2">
    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
</svg>

<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
</svg>

<!--
1 - jQuery setup for form validation
2 -
-->





<p>jquery validation test</p>

<div class="container">
    <h2>Registration</h2>
    <form action="" name="registration">

        <label for="firstname">First Name</label>
        <input type="text" name="firstname" id="firstname" placeholder="John"/>

        <label for="lastname">Last Name</label>
        <input type="text" name="lastname" id="lastname" placeholder="Doe"/>

        <label for="email">Email</label>
        <input type="email" name="email" id="email" placeholder="john@doe.com"/>

        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;"/>

        <button type="submit">Register</button>

    </form>
</div>


<div id="example"></div>
<script src="{{mix('js/app.js')}}"></script>
<script src="/resources/js/validation.js"></script>


@extends('layouts.app')

@section('content')
    <example></example>
@endsection
