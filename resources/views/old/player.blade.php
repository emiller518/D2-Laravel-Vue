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

<br><br><br>

<table>
    <tr>
        <th>Season</th>
        <th>Class</th>
        <th>Team</th>
        <th>Pos</th>
        <th>GP</th>
        <th>GS</th>
        <th>MIN</th>
        <th>PTS</th>
        <th>REB</th>
        <th>AST</th>
        <th>BLK</th>
        <th>STL</th>
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

    @foreach ($PlayerSeasonStats as $Season)
        <tr>
            <td>{{$Season->Season}}</td>
            <td>{{$Season->Year}}</td>
            <td><a href="/team/{{$Season->Abbreviation}}/{{$Season->Season}}">{{$Season->Team}}</a></td>
            <td>{{$Season->Position}}</td>
            <td>{{$Season->GP}}</td>
            <td>{{$Season->GS}}</td>
            <td>{{$Season->MIN}}</td>
            <td>{{$Season->PTS}}</td>
            <td>{{$Season->REB}}</td>
            <td>{{$Season->AST}}</td>
            <td>{{$Season->BLK}}</td>
            <td>{{$Season->STL}}</td>
            <td>{{$Season->FGM}}</td>
            <td>{{$Season->FGA}}</td>
            <td>{{$Season->TPM}}</td>
            <td>{{$Season->TPA}}</td>
            <td>{{$Season->TPPCT}}</td>
            <td>{{$Season->FTM}}</td>
            <td>{{$Season->FTA}}</td>
            <td>{{$Season->FTPCT}}</td>
        </tr>
    @endforeach
</table>

<br><br><br>

<table>
    <tr>
        <th>Season</th>
        <th>Class</th>
        <th>Team</th>
        <th>Pos</th>
        <th>GP</th>
        <th>GS</th>
        <th>MIN</th>
        <th>PTS</th>
        <th>REB</th>
        <th>AST</th>
        <th>BLK</th>
        <th>STL</th>
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
    @foreach ($PlayerSeasonStatsPer30 as $Season)
        <tr>
            <td>{{$Season->Season}}</td>
            <td>{{$Season->Year}}</td>
            <td><a href="/team/{{$Season->Abbreviation}}/{{$Season->Season}}">{{$Season->Team}}</a></td>
            <td>{{$Season->Position}}</td>
            <td>{{$Season->GP}}</td>
            <td>{{$Season->GS}}</td>
            <td>{{$Season->MIN}}</td>
            <td>{{$Season->PTS}}</td>
            <td>{{$Season->REB}}</td>
            <td>{{$Season->AST}}</td>
            <td>{{$Season->BLK}}</td>
            <td>{{$Season->STL}}</td>
            <td>{{$Season->FGM}}</td>
            <td>{{$Season->FGA}}</td>
            <td>{{$Season->TPM}}</td>
            <td>{{$Season->TPA}}</td>
            <td>{{$Season->TPPCT}}</td>
            <td>{{$Season->FTM}}</td>
            <td>{{$Season->FTA}}</td>
            <td>{{$Season->FTPCT}}</td>
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

    @foreach ($PlayerGameLog as $Game)
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

