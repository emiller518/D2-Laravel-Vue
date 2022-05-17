<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>
    <style>
        body {
            font-size: 20px;
        }
    </style>
</head>
<body>

<a href="/">Home</a><br>


<table>
    <tr>
        <th>Number</th>
        <th>Player</th>
        <th>Position</th>
        <th>Class</th>
        <th>Height</th>
        <th>Hometown</th>
        <th>Previous School</th>
    </tr>
    @foreach ($TeamRoster as $Player)
    <tr>
        <td>{{$Player->PlayerNum}}</td>
        <td><a href="/player/{{$Player->PlayerID}}">{{$Player->PlayerName}}</a></td>
        <td>{{$Player->Position}}</td>
        <td>{{$Player->Class}}</td>
        <td>{{$Player->Height}}</td>
        <td>{{$Player->Hometown}}</td>
        <td>{{$Player->PrevSchool}}</td>
    </tr>
    @endforeach
</table>

<br><br><br>

<table>
    <tr>
        <th>#</th>
        <th>Player</th>
        <th>Class</th>
        <th>GP</th>
        <th>GS</th>
        <th>MIN</th>
        <th>PTS</th>
        <th>REB</th>
        <th>AST</th>
        <th>BLK</th>
        <th>STL</th>
        <th>TO</th>
        <th>FGM</th>
        <th>FGA</th>
        <th>FG%</th>
        <th>3PM</th>
        <th>3PA</th>
        <th>3P%</th>
        <th>FTM</th>
        <th>FTA</th>
        <th>FT%</th>
    </tr>

    @foreach ($PlayerStatistics as $Player)
        <tr>
            <td>{{$Player->Number}}</td>
            <td><a href="/player/{{$Player->PlayerID}}">{{$Player->PlayerName}}</a></td>
            <td>{{$Player->Class}}</td>
            <td>{{$Player->GP}}</td>
            <td>{{$Player->GS}}</td>
            <td>{{$Player->MIN}}</td>
            <td>{{$Player->PTS}}</td>
            <td>{{$Player->REB}}</td>
            <td>{{$Player->AST}}</td>
            <td>{{$Player->BLK}}</td>
            <td>{{$Player->STL}}</td>
            <td>{{$Player->TRN}}</td>
            <td>{{$Player->FGM}}</td>
            <td>{{$Player->FGA}}</td>
            <td>{{$Player->FGPCT}}%</td>
            <td>{{$Player->TPM}}</td>
            <td>{{$Player->TPA}}</td>
            <td>{{$Player->TPPCT}}%</td>
            <td>{{$Player->FTM}}</td>
            <td>{{$Player->FTA}}</td>
            <td>{{$Player->FTPCT}}%</td>
        </tr>
    @endforeach
</table>

<br><br><br>

<table>
    <tr>
        <th>Date</th>
        <th>Opponent</th>
        <th>Result</th>
        <th>PTS</th>
        <th>REB</th>
        <th>AST</th>
        <th>BLK</th>
        <th>STL</th>
        <th>TO</th>
        <th>FGM</th>
        <th>FGA</th>
        <th>FG%</th>
        <th>3PM</th>
        <th>3PA</th>
        <th>3P%</th>
        <th>FTM</th>
        <th>FTA</th>
        <th>FT%</th>
    </tr>

    @foreach ($GameLog as $Game)
    <tr>
        <td>{{$Game->GameDate}}</td>
        <td>{{$Game->loc}}
            @if($Game->OpponentAbbr)
                <a href="/team/{{$Game->OpponentAbbr}}/{{$Game->SeasonName}}">{{$Game->Opponent}}</a>
            @else
                {{$Game->Opponent}}
            @endif
        </td>
        <td><a href="/game/{{$Game->GameID}}">{{$Game->Result}}</a></td>
        <td>{{$Game->PTS}}</td>
        <td>{{$Game->REB}}</td>
        <td>{{$Game->AST}}</td>
        <td>{{$Game->BLK}}</td>
        <td>{{$Game->STL}}</td>
        <td>{{$Game->TRN}}</td>
        <td>{{$Game->FGM}}</td>
        <td>{{$Game->FGA}}</td>
        <td>{{$Game->FGPCT}}%</td>
        <td>{{$Game->TPM}}</td>
        <td>{{$Game->TPA}}</td>
        <td>{{$Game->TPPCT}}%</td>
        <td>{{$Game->FTM}}</td>
        <td>{{$Game->FTA}}</td>
        <td>{{$Game->FTPCT}}%</td>
    </tr>
    @endforeach
</table>



</body>
</html>

