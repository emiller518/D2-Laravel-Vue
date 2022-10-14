<template>

    <div>
        admin.vue
    </div>

</template>

<script>
import ApiService from "././services/api/api";

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

