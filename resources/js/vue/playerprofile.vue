<template>
    <div>

        <div id="player-header">
            <h1>{{playerProfile['Name']}}</h1>
            <img v-bind:src="imgpath + playerProfile['img']" width="160" >
            <p>#{{playerProfile['Number']}} -- {{playerProfile['Height']}} {{playerProfile['Position']}} <br />
            {{playerProfile['TeamName']}}</p>

        </div>

        <h3>Player Stats</h3>
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

                <tr v-for="season in playerSeasonStats">
                    <td>{{season['Season']}}</td>
                    <td>{{season['Year']}}</td>
                    <td><a v-bind:href="/team/ + season['Abbreviation'] + '/' + season['Season']">{{season['Team']}}</a></td>
                    <td>{{season['Position']}}</td>
                    <td>{{season['GP']}}</td>
                    <td>{{season['GS']}}</td>
                    <td>{{season['MIN']}}</td>
                    <td>{{season['PTS']}}</td>
                    <td>{{season['REB']}}</td>
                    <td>{{season['AST']}}</td>
                    <td>{{season['BLK']}}</td>
                    <td>{{season['STL']}}</td>
                    <td>{{season['FGM']}}</td>
                    <td>{{season['FGA']}}</td>
                    <td>{{season['FGPCT']}}</td>
                    <td>{{season['TPM']}}</td>
                    <td>{{season['TPA']}}</td>
                    <td>{{season['TPPCT']}}</td>
                    <td>{{season['FTM']}}</td>
                    <td>{{season['FTA']}}</td>
                    <td>{{season['FTPCT']}}</td>
                </tr>
            </table>

        <h3>Player Stats (Per 30 Minutes)</h3>
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

                <tr v-for="season in playerSeasonStatsPer30">
                    <td>{{season['Season']}}</td>
                    <td>{{season['Year']}}</td>
                    <td><a v-bind:href="/team/ + season['Abbreviation'] + '/' + season['Season']">{{season['Team']}}</a></td>
                    <td>{{season['Position']}}</td>
                    <td>{{season['GP']}}</td>
                    <td>{{season['GS']}}</td>
                    <td>{{season['MIN']}}</td>
                    <td>{{season['PTS']}}</td>
                    <td>{{season['REB']}}</td>
                    <td>{{season['AST']}}</td>
                    <td>{{season['BLK']}}</td>
                    <td>{{season['STL']}}</td>
                    <td>{{season['FGM']}}</td>
                    <td>{{season['FGA']}}</td>
                    <td>{{season['FGPCT']}}</td>
                    <td>{{season['TPM']}}</td>
                    <td>{{season['TPA']}}</td>
                    <td>{{season['TPPCT']}}</td>
                    <td>{{season['FTM']}}</td>
                    <td>{{season['FTA']}}</td>
                    <td>{{season['FTPCT']}}</td>
                </tr>
            </table>


        <h3>Game Logs</h3>

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

            <tr v-for="game in gameLogs">
                <td>{{game['GameDate']}}</td>
                <td v-if="game['OpponentAbbr']"><a v-bind:href="/team/ + game['OpponentAbbr'] + '/' + game['SeasonName']">{{game['loc']}} {{game['Opponent']}}</a></td>
                <td v-else>{{game['Opponent']}}</td>
                <td><a v-bind:href="/game/ + game['GameID']">{{game['Result']}}</a></td>
                <td>{{game['PTS']}}</td>
                <td>{{game['REB']}}</td>
                <td>{{game['AST']}}</td>
                <td>{{game['BLK']}}</td>
                <td>{{game['STL']}}</td>
                <td>{{game['TRN']}}</td>
                <td>{{game['FGM']}}</td>
                <td>{{game['FGA']}}</td>
                <td>{{game['FGPCT']}}%</td>
                <td>{{game['TPM']}}</td>
                <td>{{game['TPA']}}</td>
                <td>{{game['TPPCT']}}%</td>
                <td>{{game['FTM']}}</td>
                <td>{{game['FTA']}}</td>
                <td>{{game['FTPCT']}}%</td>
            </tr>
        </table>

    </div>
</template>



<script>
    import axios from 'axios';

    export default {
        props:['pid'],

        data: function() {
            return {
                gameLogs:[],
                playerSeasonStatsPer30:[],
                playerSeasonStats:[],
                playerProfile:[],
                imgpath: '/imgs/'
            }
        },

        created() {
            this.getResults();
        },

        methods: {
            getResults() {
                axios.get('/api/player/'+ this.pid).then(resp => {
                    this.gameLogs = resp.data['gameLogs'];
                    this.playerSeasonStatsPer30 = resp.data['playerSeasonStatsPer30']
                    this.playerSeasonStats = resp.data['playerSeasonStats']
                    this.playerProfile = resp.data['playerProfile'][0]
                });
            }
        }


    }
</script>
