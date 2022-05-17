<!DOCTYPE html>
<html>
<head>
    <title>Game Profile</title>
    <style>
        body {
            font-size: 20px;
        }
    </style>
</head>
<body>


<a href="/">Home</a><br>

<a href="/team/{{$GameStats->AwayTeam->Abbreviation}}/{{$GameStats->Season[0]->Name}}">{{$GameStats->AwayTeam->Name}}</a> {{$GameStats->AwayPts}} --
<a href="/team/{{$GameStats->HomeTeam->Abbreviation}}/{{$GameStats->Season[0]->Name}}">{{$GameStats->HomeTeam->Name}}</a> {{$GameStats->HomePts}} <br>
{{$GameStats->GameStatsDate}} <br>
Season: {{$GameStats->Season[0]->Name}} <br>
Ties: {{$GameStats->Ties}} <br>
Lead Changes: {{$GameStats->LeadChanges}} <br>
Attendance: {{$GameStats->Attendance}} <br>
Neutral Court: {{$GameStats->Neutral}} <br>
Exhibition: {{$GameStats->Exhibition}} <br>
NonLeague: {{$GameStats->NonLeague}} <br>


<br><br><br>

{{$GameStats->AwayTeam->Name}}<br>
-----------------------------------------------------------------

<table>
<tr>
    <th>#</th>
    <th>Player</th>
    <th>Starter</th>
    <th>MIN</th>
    <th>FG</th>
    <th>3PT</th>
    <th>FT</th>
    <th>REB</th>
    <th>OREB</th>
    <th>DREB</th>
    <th>PF</th>
    <th>AST</th>
    <th>TO</th>
    <th>BLK</th>
    <th>STL</th>
    <th>PTS</th>
</tr>
@foreach ($AwayPlayerStats as $AwayPlayer)
    <tr>
        <td>{{$AwayPlayer->Number}}</td>
        <td><a href="/player/{{$AwayPlayer->PlayerID}}">{{$AwayPlayer->Name}}</a></td>
        <td>@if($AwayPlayer->Starter == 1)*@endif</td>
        <td>{{$AwayPlayer->Minutes}}</td>
        <td>{{$AwayPlayer->FGMade}}/{{$AwayPlayer->FGAttempts}}</td>
        <td>{{$AwayPlayer->TPMade}}/{{$AwayPlayer->TPAttempts}}</td>
        <td>{{$AwayPlayer->FTMade}}/{{$AwayPlayer->FTAttempts}}</td>
        <td>{{$AwayPlayer->Rebounds}}</td>
        <td>{{$AwayPlayer->OffReb}}</td>
        <td>{{$AwayPlayer->DefReb}}</td>
        <td>{{$AwayPlayer->Fouls}}</td>
        <td>{{$AwayPlayer->Assists}}</td>
        <td>{{$AwayPlayer->Turnovers}}</td>
        <td>{{$AwayPlayer->Blocks}}</td>
        <td>{{$AwayPlayer->Steals}}</td>
        <td>{{$AwayPlayer->Points}}</td>
    </tr>
@endforeach
</table>

-----------------------------------------------------------------
<br><br><br>

{{$GameStats->HomeTeam->Name}}<br>
-----------------------------------------------------------------

<table>
    <tr>
        <th>#</th>
        <th>Player</th>
        <th>Starter</th>
        <th>MIN</th>
        <th>FG</th>
        <th>3PT</th>
        <th>FT</th>
        <th>REB</th>
        <th>OREB</th>
        <th>DREB</th>
        <th>PF</th>
        <th>AST</th>
        <th>TO</th>
        <th>BLK</th>
        <th>STL</th>
        <th>PTS</th>
    </tr>
    @foreach ($HomePlayerStats as $HomePlayer)
        <tr>
            <td>{{$HomePlayer->Number}}</td>
            <td><a href="/player/{{$HomePlayer->PlayerID}}">{{$HomePlayer->Name}}</a></td>
            <td>@if($HomePlayer->Starter == 1)*@endif</td>
            <td>{{$HomePlayer->Minutes}}</td>
            <td>{{$HomePlayer->FGMade}}/{{$HomePlayer->FGAttempts}}</td>
            <td>{{$HomePlayer->TPMade}}/{{$HomePlayer->TPAttempts}}</td>
            <td>{{$HomePlayer->FTMade}}/{{$HomePlayer->FTAttempts}}</td>
            <td>{{$HomePlayer->Rebounds}}</td>
            <td>{{$HomePlayer->OffReb}}</td>
            <td>{{$HomePlayer->DefReb}}</td>
            <td>{{$HomePlayer->Fouls}}</td>
            <td>{{$HomePlayer->Assists}}</td>
            <td>{{$HomePlayer->Turnovers}}</td>
            <td>{{$HomePlayer->Blocks}}</td>
            <td>{{$HomePlayer->Steals}}</td>
            <td>{{$HomePlayer->Points}}</td>
        </tr>
    @endforeach
</table>

-----------------------------------------------------------------
</body>
</html>

