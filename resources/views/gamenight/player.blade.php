<h2>{{$overview['Username']}}</h2>
<h4>{{$overview['Name']}}</h4>

<br><br><br>

<div>
    Game Nights: {{$overview['GameNights']}} <br>
    Games Played: {{$overview['GamesPlayed']}} <br>
    Matches Played: {{$overview['MatchesPlayed']}} <br>
</div>

<br><br><br>

<div>
    Solo Wins: {{$overview['SoloWins']}}<br>
    Team Wins: 0 <br>
    Kills: {{$overview['Kills']}}<br>
    Deaths: {{$overview['Deaths']}}<br>
    Assists: {{$overview['Assists']}}<br>
    K/D: {{round($overview['Kills']/$overview['Deaths'],2)}}
</div>

<br><br><br>

<table>
    <tr>
        <th>MatchID</th>
        <th>Date</th>
        <th>Game</th>
        <th>Map</th>
        <th>Game Type</th>
        <th>Team Type</th>
        <th>Stats</th>
    </tr>
@foreach($matches as $match)
        <tr>
            <td>{{$match['MatchID']}}</td>
            <td>{{$match['MatchDate']}}</td>
            <td>{{$match['GameName']}}</td>
            <td>{{$match['Map']}}</td>
            <td>{{$match['GameTypeName']}}</td>
            <td>{{$match['TeamType']}}</td>
            <td>{{$match['Stats']}}</td>
        </tr>
@endforeach
</table>


<br> <br> <br>


<table>
    <tr>
        <th>Game</th>
        <th>Accolade</th>
        <th>Times Received</th>
    </tr>
    @foreach ($accolades as $accolade)
        <tr>
            <td>{{$accolade['GameName']}}</td>
            <td>{{$accolade['AccoladeName']}} <img src="{{asset('/imgs/gamenight/' . $accolade['Icon']) }}" alt="{{$accolade['AccoladeName']}}" height="35" width="35"></td>
            <td>{{$accolade['TimesReceived']}}</td>
        </tr>
    @endforeach
</table>
