<template>
    <table>
        <tr>
            <th v-for="(items, keys) in options[0]">{{keys}}</th>
        </tr>
        <tr v-for="(items,keys) in options">
            <td v-for="item in items">{{item}}</td>
        </tr>
    </table>


    <button @click="updatePlayer" class="transition duration-200 text-xs font-medium focus:outline-none rounded py-1 px-3 mx-2">
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
    },

    data: function() {
        return {
            apiService: null
        }
    },

    methods: {
        updatePlayer() {
            this.apiService.updatePlayer(3026);
        },
    }
}

</script>

