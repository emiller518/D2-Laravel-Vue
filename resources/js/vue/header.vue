<template>
    <div>
yooo
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
