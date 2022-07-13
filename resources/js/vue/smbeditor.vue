<template>
    <table>
        <tr>
            <th v-for="(items, keys) in options[0]">{{keys}}</th>
        </tr>
        <tr v-for="(items,keys) in options">
            <td v-for="item in items">{{item}}</td>
        </tr>
    </table>
</template>
<script>

import {ref, onMounted} from "@vue/runtime-core";
import * as d3 from "d3";

export default {
    props: {
        'options': {
            required: true
        },
    }
}


</script>


<style lang="scss">

.fill-100{
    width: 100%;
    height: 100%;
}

div.bar {
    display: inline-block;
    width: 20px;
    height: 75px; /* We'll override height later */
    background-color: teal;
    margin-right: 5px;
}

b {
    font-size: 16px;
}

.tutorial{
    margin-bottom: 50px;
    margin-left: 20px;
}

.axis path,
.axis line {
    stroke: teal;
    shape-rendering: crispEdges;
}
.axis text {
    font-family: Optima, Futura, sans-serif;
    font-size: 12px;
    fill: teal;
}

</style>

