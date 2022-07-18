<template>


    <table>
        <tr>
            <th v-for="(items, keys) in options[0]">{{keys}}</th>
        </tr>
        <tr v-for="(items) in options">
            <td v-for="(item, key) in items">
                <input v-on:change="event => newPendingChange(event, key, items['playerId'])" :value="item">
            </td>
        </tr>
    </table>

    <button @click="updateVisuals" class="transition duration-200 text-xs font-medium focus:outline-none rounded py-1 px-3 mx-2">
        Visual Debug
    </button>

    <button @click="submitChanges" class="transition duration-200 text-xs font-medium focus:outline-none rounded py-1 px-3 mx-2">
        Save
    </button>


<!--    options:-->
<!--    {{options}}-->


<!--    <div v-for="(items, keys) in options">-->
<!--        items:-->
<!--        {{items}}-->

<!--        <div v-for="(item, key) in items">-->
<!--            sub-item:-->
<!--                {{item}}-->

<!--            sub-key:-->
<!--                {{key}}-->
<!--        </div>-->

<!--        keys: <br>-->
<!--        {{keys}}-->
<!--    </div>-->



<!--    <div v-for="(items, keys) in options[0]">-->
<!--        {{keys}}-->
<!--        <template v-if="queryAttributes[keys]">-->
<!--            <li>{{queryAttributes[keys]['id']}}</li>-->
<!--        </template>-->
<!--    </div>-->

<!--    {{queryAttributes['First']}}-->

<!--    {{queryAttributes[0]}}-->


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
    },

    data: function() {
        return {
            apiService: null,
            changeLog: [],

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

                // NEED FEEDBACK: This looks kind of gross, is there a way to fix this ? Should I declare variables for readability?
                if (this.changeLog[i]['script'] === 'Visualization'){
                    this.updateVisuals(this.changeLog[i]['playerID'], this.changeLog[i]['optionKey'], this.changeLog[i]['optionValue'])
                    console.log(this.changeLog[i])
                }

                if (this.changeLog[i]['script'] === 'Statistics'){
                    this.updateStats(this.changeLog[i]['playerID'], this.changeLog[i]['optionKey'], this.changeLog[i]['optionValue'])
                    console.log(this.changeLog[i])

                }

            }
            this.changeLog = [];
        }
    }
}

</script>

