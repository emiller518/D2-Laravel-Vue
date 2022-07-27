<template>

    <div>
        <select v-model="selectedLeague" v-on:change="changeLeague">
<!--            NEED FEEDBACK: Is naming it value['name'] like this best practice? Do I edit the query or change the for loop?-->
            <option v-for="(league) in leagues">{{league['name']}}</option>
        </select>

        <select v-model="selectedTeam" v-on:change="changeTeam">
            <option v-for="team in teams">{{team['teamName']}}</option>
        </select>

        <select v-on:change="event => showHideColumns(event)">
            <option v-for="option in optionTypes">{{option}}</option>
        </select>
    </div>

    <table>

        <tr>
            <th v-for="(items, keys) in players[0]">
                <b v-if="queryAttributes[keys]['Show']">{{keys}}</b>
            </th>
        </tr>

        <tr v-for="(items) in players">

            <td v-for="(item, key) in items">

<!--                NEED FEEDBACK: Is a chain of different inputs / selects based on different logic the best way to go about this? -->
                <input v-if="queryAttributes[key]['Show'] && queryAttributes[key]['type'] !== 'dropdown' && queryAttributes[key]['type'] !== 'dropdownPosition' "
                       v-on:change="event => newPendingChange(event, key, items['playerId'])"
                       :disabled="!queryAttributes[key]['script'] || item===null"
                       :value="item">

                <select v-if="showDropdown(key, item)" :disabled="item===null">
                    <option v-for="(dropdownOption, dropdownKey) in queryAttributes[key]['dropdownOptions']" :value="dropdownKey" v-bind:selected="item==dropdownKey">
                        {{dropdownOption}}
                    </option>
                </select>

                <select v-if="showNewDropdown(key, item)" :disabled="item===null">
                    <option v-for="(dropdownOption, dropdownKey) in queryAttributes[key]['dropdownOptions'][items['positionType']]"
                            :value="dropdownKey"
                            :selected="item==dropdownKey">
                        {{dropdownOption}}
                    </option>
                </select>

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
            optionTypes: ['Stats', 'Main', 'Head', 'Body', 'Gear', 'Swagger', 'Pitches'],
            testing: null,

            //NEED FEEDBACK: Is there a different file or something I could put this? Kind of an unnecessary wall of text here
            //NEED FEEDBACK: For some reason when I'm trying to match the keys to the dropdown options, the types aren't compatible. Even if I put the keys in quotes it's still number type. Why? See: Line 36, used == for === for comparison
            queryAttributes: {
                            gender: {id: 0, script: 'Visualization', optionKey: '0', Category: 'Main', Show: false, Max: 1, MaxF: null, MaxM: null, type: 'dropdown', dropdownOptions: {0: 'Male', 1: 'Female'}},
                            playerId: {id: 1, script: null, optionKey: 'baseballplayerlocalid', Category: 'AlwaysOn', Show: true, Max: null, MaxF: null, MaxM: null, type: 'int'},
                            lineup: {id: 2, script: null, optionKey: 'lineup', Category: 'AlwaysOn', Show: true, Max: null, MaxF: null, MaxM: null, type: 'int'},
                            throws: {id: 4, script: 'Visualization', optionKey: '4', Category: 'Main', Show: false, Max: 1, MaxF: null, MaxM: null, type: 'dropdown', dropdownOptions: {'0': 'Left', '1': 'Right'}},
                            bats: {id: 5, script: 'Visualization', optionKey: '5', Category: 'Main', Show: false, Max: 2, MaxF: null, MaxM: null, type: 'dropdown', dropdownOptions: {'0': 'Left', '1': 'Right', '2': 'Switch'}},
                            personality: {id: 8, script: 'Visualization', optionKey: '8', Category: 'Main', Show: false, Max: 6, MaxF: null, MaxM: null, type: 'dropdown', dropdownOptions: {'0': 'Competitive', '1': 'Jolly', '2': 'Droopy', '3': 'Tough', '4': 'Egotistical', '5': 'Relaxed', '6': 'Timid'}},
                            head: {id: 12, script: 'Visualization', optionKey: '12', Category: 'Head', Show: false, Max: 13, MaxF: 6, MaxM: null, type: 'imglist'},
                            eyebrows: {id: 14, script: 'Visualization', optionKey: '14', Category: 'Head', Show: false, Max: 3, MaxF: 3, MaxM: 2, type: 'imglist'},
                            hair: {id: 15, script: 'Visualization', optionKey: '15', Category: 'Head', Show: false, Max: 18, MaxF: 9, MaxM: null, type: 'imglist'},
                            facialHair: {id: 16, script: 'Visualization', optionKey: '16', Category: 'Head', Show: false, Max: 28, MaxF: 0, MaxM: null, type: 'imglist'},
                            eyeBlack: {id: 17, script: 'Visualization', optionKey: '17', Category: 'Head', Show: false, Max: 12, MaxF: null, MaxM: null, type: 'imglist'},
                            helmetTar: {id: 18, script: 'Visualization', optionKey: '18', Category: 'Gear', Show: false, Max: 1, MaxF: null, MaxM: null, type: 'dropdown', dropdownOptions: {'0': 'Speck', '1': 'Gobs'}},
                            eyeWear: {id: 19, script: 'Visualization', optionKey: '19', Category: 'Head', Show: false, Max: 15, MaxF: null, MaxM: null, type: 'imglist'},
                            number: {id: 20, script: 'Visualization', optionKey: '20', Category: 'Main', Show: false, Max: 100, MaxF: null, MaxM: null, type: 'int'},
                            physique: {id: 22, script: 'Visualization', optionKey: '22', Category: 'Main', Show: false, Max: 4, MaxF: 1, MaxM: null, type: 'dropdown', dropdownOptions: {'0': 'Athletic(F)', '1': 'Petite(F)', '2': 'Skinny(M)', '3': 'Average(M)', '4': 'Beefy(M)'}},
                            elbowGuard: {id: 25, script: 'Visualization', optionKey: '25', Category: 'Gear', Show: false, Max: 1, MaxF: null, MaxM: null, type: 'dropdown', dropdownOptions: {'0': 'Off', '1': 'On'}},
                            ankleGuard: {id: 26, script: 'Visualization', optionKey: '26', Category: 'Gear', Show: false, Max: 1, MaxF: null, MaxM: null, type: 'dropdown', dropdownOptions: {'0': 'Off', '1': 'On'}},
                            undershirt: {id: 27, script: 'Visualization', optionKey: '27', Category: 'Body', Show: false, Max: 4, MaxF: null, MaxM: null, type: 'dropdown', dropdownOptions: {'0': 'None', '1': 'Shoulder', '2': 'Elbow', '3': 'Forearm', '4': 'Wrist'}},
                            leftTattoo: {id: 28, script: 'Visualization', optionKey: '28', Category: 'Body', Show: false, Max: 14, MaxF: null, MaxM: null, type: 'imglist'},
                            rightTattoo: {id: 29, script: 'Visualization', optionKey: '29', Category: 'Body', Show: false, Max: 14, MaxF: null, MaxM: null, type: 'imglist'},
                            leftSleeve: {id: 30, script: 'Visualization', optionKey: '30', Category: 'Body', Show: false, Max: 9, MaxF: null, MaxM: null, type: 'imglist'},
                            rightSleeve: {id: 31, script: 'Visualization', optionKey: '31', Category: 'Body', Show: false, Max: 9, MaxF: null, MaxM: null, type: 'imglist'},
                            pants: {id: 32, script: 'Visualization', optionKey: '32', Category: 'Body', Show: false, Max: 3, MaxF: null, MaxM: null, type: 'dropdownx'},
                            wristband: {id: 36, script: 'Visualization', optionKey: '36', Category: 'Body', Show: false, Max: 3, MaxF: null, MaxM: null, type: 'dropdownx'},
                            battingGlove: {id: 39, script: 'Visualization', optionKey: '39', Category: 'Gear', Show: false, Max: 6, MaxF: null, MaxM: null, type: 'imglist'},
                            cleats: {id: 40, script: 'Visualization', optionKey: '40', Category: 'Body', Show: false, Max: 7, MaxF: null, MaxM: null, type: 'imglist'},
                            wristTape: {id: 41, script: 'Visualization', optionKey: '41', Category: 'Body', Show: false, Max: 8, MaxF: null, MaxM: null, type: 'imglist'},
                            windup: {id: 48, script: 'Visualization', optionKey: '48', Category: 'Swagger', Show: false, Max: 4, MaxF: null, MaxM: null, type: 'imglist'},
                            armAngle: {id: 49, script: 'Visualization', optionKey: '49', Category: 'Swagger', Show: false, Max: 3, MaxF: null, MaxM: null, type: 'dropdownPosition', dropdownOptions: {'P':{'0': 'Sub', '1': 'Low', '2': 'Mid', '3': 'High'}, 'F': {'3': 'N/A'}}},
                            battingRoutine: {id: 50, script: 'Visualization', optionKey: '50', Category: 'Swagger', Show: false, Max: 14, MaxF: null, MaxM: null, type: 'imglist'},
                            battingStance: {id: 51, script: 'Visualization', optionKey: '51', Category: 'Swagger', Show: false, Max: 17, MaxF: null, MaxM: null, type: 'imglist'},
                            walkUpSong: {id: 52, script: 'Visualization', optionKey: '52', Category: 'Swagger', Show: false, Max: 104, MaxF: null, MaxM: null, type: 'int'},
                            portrait: {id: 53, script: 'Visualization', optionKey: '53', Category: 'null', Show: false, Max: 67, MaxF: null, MaxM: null, type: 'int'},
                            primaryPosition: {id: 54, script: 'Visualization', optionKey: '54', Category: 'Main', Show: false, Max: 13, MaxF: null, MaxM: null, type: 'dropdown', dropdownOptions: {'1': 'P', '2': 'C', '3': '1B', '4': 'C', '5': '3B', '6': 'SS', '7': 'LF', '8': 'CF', '9': 'RF', '10': 'IF', '11': 'OF', '12': '1B/OF', '13': 'IF/OF'}},
                            secondaryPosition: {id: 55, script: 'Visualization', optionKey: '55', Category: 'Main', Show: false, Max: 13, MaxF: null, MaxM: null, type: 'dropdownPosition', dropdownOptions: {'F':{'0': null, '1': 'P', '2': 'C', '3': '1B', '4': 'C', '5': '3B', '6': 'SS', '7': 'LF', '8': 'CF', '9': 'RF', '10': 'IF', '11': 'OF', '12': '1B/OF', '13': 'IF/OF'}, 'P':{'1': 'SP', '2': 'SP/RP', '3': 'RP', '4': 'CP'}}},
                            positionType: {id: 99, script: null, optionKey: '99', Category: 'Hidden', Show: false, Max: null, MaxF: null, MaxM: null, type: 'Hidden', dropdownOptions: {'P': 'Pitcher', 'F': 'Fielder'}},
                            pFourSeam: {id: 58, script: 'Visualization', optionKey: '58', Category: 'Pitches', Show: false, Max: 1, MaxF: null, MaxM: null, type: 'dropdown', dropdownOptions: {'0': 'No', '1': 'Yes'}},
                            pTwoSeam: {id: 59, script: 'Visualization', optionKey: '59', Category: 'Pitches', Show: false, Max: 1, MaxF: null, MaxM: null, type: 'dropdown', dropdownOptions: {'0': 'No', '1': 'Yes'}},
                            pScrewBall: {id: 60, script: 'Visualization', optionKey: '60', Category: 'Pitches', Show: false, Max: 1, MaxF: null, MaxM: null, type: 'dropdown', dropdownOptions: {'0': 'No', '1': 'Yes'}},
                            pChangeUp: {id: 61, script: 'Visualization', optionKey: '61', Category: 'Pitches', Show: false, Max: 1, MaxF: null, MaxM: null, type: 'dropdown', dropdownOptions: {'0': 'No', '1': 'Yes'}},
                            pForkBall: {id: 62, script: 'Visualization', optionKey: '62', Category: 'Pitches', Show: false, Max: 1, MaxF: null, MaxM: null, type: 'dropdown', dropdownOptions: {'0': 'No', '1': 'Yes'}},
                            pCurveBall: {id: 63, script: 'Visualization', optionKey: '63', Category: 'Pitches', Show: false, Max: 1, MaxF: null, MaxM: null, type: 'dropdown', dropdownOptions: {'0': 'No', '1': 'Yes'}},
                            pSlider: {id: 64, script: 'Visualization', optionKey: '64', Category: 'Pitches', Show: false, Max: 1, MaxF: null, MaxM: null, type: 'dropdown', dropdownOptions: {'0': 'No', '1': 'Yes'}},
                            pCutFastBall: {id: 65, script: 'Visualization', optionKey: '65', Category: 'Pitches', Show: false, Max: 1, MaxF: null, MaxM: null, type: 'dropdown', dropdownOptions: {'0': 'No', '1': 'Yes'}},
                            first: {id: 66, script: 'Visualization', optionKey: '66', Category: 'AlwaysOn', Show: true, Max: 10, MaxF: null, MaxM: null, type: 'string'},
                            last: {id: 67, script: 'Visualization', optionKey: '67', Category: 'AlwaysOn', Show: true, Max: 10, MaxF: null, MaxM: null, type: 'string'},
                            batStyle: {id: 92, script: 'Visualization', optionKey: '92', Category: 'Gear', Show: false, Max: 5, MaxF: null, MaxM: null, type: 'imglist'},
                            batGrip: {id: 93, script: 'Visualization', optionKey: '93', Category: 'Gear', Show: false, Max: 3, MaxF: null, MaxM: null, type: 'imglist'},
                            helmetStyle: {id: 104, script: 'Visualization', optionKey: '104', Category: 'Gear', Show: false, Max: 3, MaxF: null, MaxM: null, type: 'int'},
                            power: {id: 105, script: 'Statistics', optionKey: 'power', Category: 'Stats', Show: true, Max: 99, MaxF: null, MaxM: null, type: 'int'},
                            contact: {id: 106, script: 'Statistics', optionKey: 'contact', Category: 'Stats', Show: true, Max: 99, MaxF: null, MaxM: null, type: 'int'},
                            speed: {id: 107, script: 'Statistics', optionKey: 'speed', Category: 'Stats', Show: true, Max: 99, MaxF: null, MaxM: null, type: 'int'},
                            fielding: {id: 108, script: 'Statistics', optionKey: 'fielding', Category: 'Stats', Show: true, Max: 99, MaxF: null, MaxM: null, type: 'int'},
                            arm: {id: 109, script: 'Statistics', optionKey: 'arm', Category: 'Stats', Show: true, Max: 99, MaxF: null, MaxM: null, type: 'int'},
                            velocity: {id: 110, script: 'Statistics', optionKey: 'velocity', Category: 'Stats', Show: true, Max: 99, MaxF: null, MaxM: null, type: 'int'},
                            junk: {id: 111, script: 'Statistics', optionKey: 'junk', Category: 'Stats', Show: true, Max: 99, MaxF: null, MaxM: null, type: 'int'},
                            accuracy: {id: 112, script: 'Statistics', optionKey: 'accuracy', Category: 'Stats', Show: true, Max: 99, MaxF: null, MaxM: null, type: 'int'},
                            age: {id: 113, script: 'Statistics', optionKey: 'age', Category: 'Stats', Show: true, Max: 50, MaxF: null, MaxM: null, type: 'int'},
          }
        }
    },

    computed: {
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

                // number is zero indexed, so if the option key is for number, add one to correct the value
                if (optionKey === 20){
                    optionValue += 1
                }

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
        },

        showHideColumns(event){
            for (const [key, value] of Object.entries(this.queryAttributes)){
                if (value['Category'] === event.target.value || value['Category'] === 'AlwaysOn'){
                    value['Show'] = true;
                }
                else{
                    value['Show'] = false;
                }
            }
        },

        showDropdown(key, item){
            if (this.queryAttributes[key]['type'] === 'dropdown' && this.queryAttributes[key]['Show'] && item!==null) {
                return true;
            }
            else {
                return false;
            }
        },

        showNewDropdown(key, item){
            if (this.queryAttributes[key]['type'] === 'dropdownPosition' && this.queryAttributes[key]['Show'] && item!==null) {
                return true;
            }
            else {
                return false;
            }
        },
    }
}

</script>

