@foreach($players as $player)
    <div>
        <a href="/gamenight/players/{{$player['PlayerID']}}">{{$player['Username']}}</a> -- {{$player['Name']}}
    </div>
@endforeach


