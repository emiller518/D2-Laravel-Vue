<template>
    <div>
        <h3>Player Stats</h3>
            <table>
                <tr>
                    <th>Season</th>
                    <th>Record</th>
                    <th>Points Leader</th>
                    <th>Rebounds Leader</th>
                    <th>Assists Leader</th>
                </tr>

                <tr v-for="season in playerSeasonStats">
                    <td>{{teamOverview['SeasonName']}}</td>
                    <td>{{teamOverview['Wins']}}-{{teamOverview['Losses']}} ({{teamOverview['ConfWins']}}-{{teamOverview['ConfLoss']}})</td>
<!--                    <td><a v-bind:href="/team/ + season['Abbreviation'] + '/' + season['Season']">{{season['Team']}}</a></td>-->
                    <td>{{teamOverview['Position']}}</td>
                    <td>{{teamOverview['GP']}}</td>
                    <td>{{teamOverview['GS']}}</td>
                </tr>
            </table>

    </div>
</template>



<script>
    import axios from 'axios';

    export default {
        props:['teamAbbreviation'],

        data: function() {
            return {
                teamOverview:[]
            }
        },

        created() {
            this.getResults();
        },

        methods: {
            getResults() {
                axios.get('/api/team/'+ this.teamAbbreviation).then(resp => {
                    this.teamOverview = resp.data['overview'];
                });

            }
        }
    }
</script>
