<html>

<head>
    <title>View Student Records</title>
</head>

<body>
<table border = 1>
    <tr>
        <td>ID</td>
        <td>Name</td>
    </tr>
    @foreach ($users as $user)
        <tr>
            <td>{{ $user->ClassID }}</td>
            <td>{{ $user->ClassName }}</td>
        </tr>
    @endforeach
</table>
</body>
</html>
