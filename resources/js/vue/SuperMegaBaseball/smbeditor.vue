<template>

    <div>
        <select v-model="selectedLeague" v-on:change="changeLeague">
<!--            NEED FEEDBACK: Is naming it value['name'] like this best practice? Do I edit the query or change the for loop?-->
            <option v-for="(league) in leagues">{{league['name']}}</option>
        </select>

        <select v-model="selectedTeam" v-on:change="changeTeam">
            <option v-for="team in teams">{{team['teamName']}}</option>
        </select>

        <select>
            <option>Options</option>
        </select>
    </div>

    <table>
        <tr>
            <th v-for="(items, keys) in players[0]">{{keys}}</th>
        </tr>
        <tr v-for="(items) in players">
            <td v-for="(item, key) in items">
                <input v-on:change="event => newPendingChange(event, key, items['playerId'])" :value="item">
            </td>
        </tr>
    </table>

    <button @click="submitChanges" class="transition duration-200 text-xs font-medium focus:outline-none rounded py-1 px-3 mx-2">
        Save
    </button>


</template>
<script>
import ApiService from "./services/api/api";

export default {
    props: {
        'options': {
            required: true
        },
    },
    created() {
        this.apiService = ApiService.make();

        // NEED FEEDBACK: Can I chain these together in the separate methods I created to update League & Team ?
        this.apiService.getLeagues().then(
            response => {this.leagues = response['data'];
            this.selectedLeague = response['data'][0]['name'];
            this.apiService.getTeams(this.selectedLeague).then(
                response => {this.teams = response['data'];
                this.selectedTeam = response['data'][0]['teamName'];
                this.apiService.getPlayers(this.selectedTeam).then(
                    response => {this.players = response['data'];}
                    )
                    }
                )
            }
        );

        console.log(this.options);
    },

    data: function() {
        return {
            apiService: null,
            changeLog: [],
            leagues: [],
            selectedLeague: null,
            teams: [],
            selectedTeam: null,
            players: {},

            //NEED FEEDBACK: Is there a different file or something I could put this? Kind of an unnecessary wall of text here
            queryAttributes: {
                            gender: {id: 0, script: 'Visualization', optionKey: '0', Category: 'Main', Show: false, Max: 1, MaxF: null, MaxM: null},
                            playerId: {id: 1, script: null, optionKey: 'baseballplayerlocalid', Category: 'AlwaysOn', Show: true, Max: null, MaxF: null, MaxM: null},
                            throws: {id: 4, script: 'Visualization', optionKey: '4', Category: 'Main', Show: false, Max: 1, MaxF: null, MaxM: null},
                            bats: {id: 5, script: 'Visualization', optionKey: '5', Category: 'Main', Show: false, Max: 2, MaxF: null, MaxM: null},
                            personality: {id: 8, script: 'Visualization', optionKey: '8', Category: 'Main', Show: false, Max: 6, MaxF: null, MaxM: null},
                            head: {id: 12, script: 'Visualization', optionKey: '12', Category: 'Head', Show: false, Max: 13, MaxF: 6, MaxM: null},
                            eyebrows: {id: 14, script: 'Visualization', optionKey: '14', Category: 'Head', Show: false, Max: 3, MaxF: 3, MaxM: 2},
                            hair: {id: 15, script: 'Visualization', optionKey: '15', Category: 'Head', Show: false, Max: 18, MaxF: 9, MaxM: null},
                            facialHair: {id: 16, script: 'Visualization', optionKey: '16', Category: 'Head', Show: false, Max: 28, MaxF: 0, MaxM: null},
                            eyeBlack: {id: 17, script: 'Visualization', optionKey: '17', Category: 'Head', Show: false, Max: 12, MaxF: null, MaxM: null},
                            helmetTar: {id: 18, script: 'Visualization', optionKey: '18', Category: 'Gear', Show: false, Max: 1, MaxF: null, MaxM: null},
                            eyeWear: {id: 19, script: 'Visualization', optionKey: '19', Category: 'Head', Show: false, Max: 15, MaxF: null, MaxM: null},
                            number: {id: 20, script: 'Visualization', optionKey: '20', Category: 'Main', Show: false, Max: 100, MaxF: null, MaxM: null},
                            physique: {id: 22, script: 'Visualization', optionKey: '22', Category: 'Main', Show: false, Max: 4, MaxF: 1, MaxM: null},
                            elbowGuard: {id: 25, script: 'Visualization', optionKey: '25', Category: 'Gear', Show: false, Max: 1, MaxF: null, MaxM: null},
                            ankleGuard: {id: 26, script: 'Visualization', optionKey: '26', Category: 'Gear', Show: false, Max: 1, MaxF: null, MaxM: null},
                            undershirt: {id: 27, script: 'Visualization', optionKey: '27', Category: 'Body', Show: false, Max: 4, MaxF: null, MaxM: null},
                            leftTattoo: {id: 28, script: 'Visualization', optionKey: '28', Category: 'Body', Show: false, Max: 14, MaxF: null, MaxM: null},
                            rightTattoo: {id: 29, script: 'Visualization', optionKey: '29', Category: 'Body', Show: false, Max: 14, MaxF: null, MaxM: null},
                            leftSleeve: {id: 30, script: 'Visualization', optionKey: '30', Category: 'Body', Show: false, Max: 9, MaxF: null, MaxM: null},
                            rightSleeve: {id: 31, script: 'Visualization', optionKey: '31', Category: 'Body', Show: false, Max: 9, MaxF: null, MaxM: null},
                            pants: {id: 32, script: 'Visualization', optionKey: '32', Category: 'Body', Show: false, Max: 3, MaxF: null, MaxM: null},
                            wristband: {id: 36, script: 'Visualization', optionKey: '36', Category: 'Body', Show: false, Max: 3, MaxF: null, MaxM: null},
                            battingGlove: {id: 39, script: 'Visualization', optionKey: '39', Category: 'Gear', Show: false, Max: 6, MaxF: null, MaxM: null},
                            cleats: {id: 40, script: 'Visualization', optionKey: '40', Category: 'Body', Show: false, Max: 7, MaxF: null, MaxM: null},
                            wristTape: {id: 41, script: 'Visualization', optionKey: '41', Category: 'Body', Show: false, Max: 8, MaxF: null, MaxM: null},
                            windup: {id: 48, script: 'Visualization', optionKey: '48', Category: 'Swagger', Show: false, Max: 4, MaxF: null, MaxM: null},
                            armAngle: {id: 49, script: 'Visualization', optionKey: '49', Category: 'Swagger', Show: false, Max: 3, MaxF: null, MaxM: null},
                            battingRoutine: {id: 50, script: 'Visualization', optionKey: '50', Category: 'Swagger', Show: false, Max: 14, MaxF: null, MaxM: null},
                            battingStance: {id: 51, script: 'Visualization', optionKey: '51', Category: 'Swagger', Show: false, Max: 17, MaxF: null, MaxM: null},
                            walkUpSong: {id: 52, script: 'Visualization', optionKey: '52', Category: 'Swagger', Show: false, Max: 104, MaxF: null, MaxM: null},
                            portrait: {id: 53, script: 'Visualization', optionKey: '53', Category: 'null', Show: false, Max: 67, MaxF: null, MaxM: null},
                            primaryPosition: {id: 54, script: 'Visualization', optionKey: '54', Category: 'Main', Show: false, Max: 13, MaxF: null, MaxM: null},
                            secondaryPosF: {id: 55, script: 'Visualization', optionKey: '55', Category: 'Main', Show: false, Max: 13, MaxF: null, MaxM: null},
                            secondaryPosP: {id: 57, script: 'Visualization', optionKey: '57', Category: 'Main', Show: false, Max: 4, MaxF: null, MaxM: null},
                            pFourSeam: {id: 58, script: 'Visualization', optionKey: '58', Category: 'Pitches', Show: false, Max: 1, MaxF: null, MaxM: null},
                            pTwoSeam: {id: 59, script: 'Visualization', optionKey: '59', Category: 'Pitches', Show: false, Max: 1, MaxF: null, MaxM: null},
                            pScrewBall: {id: 60, script: 'Visualization', optionKey: '60', Category: 'Pitches', Show: false, Max: 1, MaxF: null, MaxM: null},
                            pChangeUp: {id: 61, script: 'Visualization', optionKey: '61', Category: 'Pitches', Show: false, Max: 1, MaxF: null, MaxM: null},
                            pForkBall: {id: 62, script: 'Visualization', optionKey: '62', Category: 'Pitches', Show: false, Max: 1, MaxF: null, MaxM: null},
                            pCurveBall: {id: 63, script: 'Visualization', optionKey: '63', Category: 'Pitches', Show: false, Max: 1, MaxF: null, MaxM: null},
                            pSlider: {id: 64, script: 'Visualization', optionKey: '64', Category: 'Pitches', Show: false, Max: 1, MaxF: null, MaxM: null},
                            pCutFastBall: {id: 65, script: 'Visualization', optionKey: '65', Category: 'Pitches', Show: false, Max: 1, MaxF: null, MaxM: null},
                            first: {id: 66, script: 'Visualization', optionKey: '66', Category: 'AlwaysOn', Show: true, Max: 10, MaxF: null, MaxM: null},
                            last: {id: 67, script: 'Visualization', optionKey: '67', Category: 'AlwaysOn', Show: true, Max: 10, MaxF: null, MaxM: null},
                            batStyle: {id: 92, script: 'Visualization', optionKey: '92', Category: 'Gear', Show: false, Max: 5, MaxF: null, MaxM: null},
                            batGrip: {id: 93, script: 'Visualization', optionKey: '93', Category: 'Gear', Show: false, Max: 3, MaxF: null, MaxM: null},
                            helmetStyle: {id: 104, script: 'Visualization', optionKey: '104', Category: 'Gear', Show: false, Max: 3, MaxF: null, MaxM: null},
                            power: {id: 105, script: 'Statistics', optionKey: 'power', Category: 'Stats', Show: true, Max: 99, MaxF: null, MaxM: null},
                            contact: {id: 106, script: 'Statistics', optionKey: 'contact', Category: 'Stats', Show: true, Max: 99, MaxF: null, MaxM: null},
                            speed: {id: 107, script: 'Statistics', optionKey: 'speed', Category: 'Stats', Show: true, Max: 99, MaxF: null, MaxM: null},
                            fielding: {id: 108, script: 'Statistics', optionKey: 'fielding', Category: 'Stats', Show: true, Max: 99, MaxF: null, MaxM: null},
                            arm: {id: 109, script: 'Statistics', optionKey: 'arm', Category: 'Stats', Show: true, Max: 99, MaxF: null, MaxM: null},
                            velocity: {id: 110, script: 'Statistics', optionKey: 'velocity', Category: 'Stats', Show: true, Max: 99, MaxF: null, MaxM: null},
                            junk: {id: 111, script: 'Statistics', optionKey: 'junk', Category: 'Stats', Show: true, Max: 99, MaxF: null, MaxM: null},
                            accuracy: {id: 112, script: 'Statistics', optionKey: 'accuracy', Category: 'Stats', Show: true, Max: 99, MaxF: null, MaxM: null},
                            age: {id: 113, script: 'Statistics', optionKey: 'age', Category: 'Stats', Show: true, Max: 50, MaxF: null, MaxM: null},
          }
        }
    },

    methods: {
        updateStats(playerId, optionKey, optionValue) {
            this.apiService.updateStats(playerId, optionKey, optionValue);
        },

        updateVisuals(playerId, optionKey, optionValue) {
            this.apiService.updateVisuals(playerId, optionKey, optionValue);
        },

        newPendingChange(event, key, playerId){
            let script = this.queryAttributes[key]['script']
            let optionKey = this.queryAttributes[key]['optionKey']
            let optionValue = event.target.value;

            let changeDict = {'script': script,
                              'playerID': playerId,
                              'optionKey': optionKey,
                              'optionValue': optionValue};

            this.changeLog.push(changeDict);
        },

        submitChanges(){
            for (let i = 0; i < this.changeLog.length; i++) {

                // Select the update script based on the column type, then clear the queue
                let script = this.changeLog[i]['script'];
                let playerId = this.changeLog[i]['playerID'];
                let optionKey = this.changeLog[i]['optionKey'];
                let optionValue = this.changeLog[i]['optionValue'];

                if (script === 'Visualization'){
                    this.updateVisuals(playerId, optionKey, optionValue)
                }
                else if (script === 'Statistics'){
                    this.updateStats(playerId, optionKey, optionValue)
                }
            }
            this.changeLog = [];
        },

        changeLeague(){
            this.apiService.getTeams(this.selectedLeague).then(
                        response => {this.teams = response['data'];
                            this.selectedTeam = response['data'][0]['teamName'];
                            this.apiService.getPlayers(this.selectedTeam).then(
                                response => {this.players = response['data'];}
                            )
                        }
                    )
        },

        changeTeam(){
            this.apiService.getPlayers(this.selectedTeam).then(
                response => {this.players = response['data'];}
            )
        }

    }
}

</script>

