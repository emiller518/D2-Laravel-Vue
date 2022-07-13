<template>
    <div class="tutorial" id="current">Current Tutorial<br></div>
    <div class="tutorial" id="new-paragraph">  Create a new paragraph in the DOM with D3 <br> </div>
    <div class="tutorial" id="data-driven-paragraphs">   Creating new P Tags Using Data <br> </div>
    <div class="tutorial" id="html-bar">  Bar Graph using HTML & CSS Styling and Divs <br> </div>
    <div class="tutorial" id="svg-intro"> Intro to plotting using SVG (Mostly DIV) <br> </div>
    <div class="tutorial" id="svg-bar-intro"> SVG Bar Graph: Intro <br> </div>
    <div class="tutorial" id="svg-bar-full">SVG Bar Graph: Full (Static) <br> </div>
    <div class="tutorial" id="svg-scatterplot">SVG Scatterplot <br></div>
    <div class="tutorial" id="scales">Bar Chart - Auto Adjusting Color / Label Scales<br></div>
    <div class="tutorial" id="axis">Axis<br></div>
<!--    Page 131 - References time & date formatting-->

    <div></div>
</template>
<script>

import {ref, onMounted} from "@vue/runtime-core";
import * as d3 from "d3";

export default {
    name: "SldSvgD3",
    props: ["id"],
    setup(props) {
        const svgRef = ref(null);
        const svg_width = 400;
        const svg_height = 667;

        onMounted(() => {

            // Random Dataset
                let randdataset = []; //Initialize empty array
                for (var i = 0; i < 25; i++) { //Loop 25 times
                    var newNumber = Math.random() * 31; //New random number (0-30)
                    newNumber = Math.floor(newNumber);
                    randdataset.push(newNumber); //Add new number to array
                }

            //HTML Dataset
                let htmldataset = [5, 10, 15, 20, 25];

            //---------------------------------------------------------------------------------------------------------
            //Using D3 to append HTML elements
            //---------------------------------------------------------------------------------------------------------

                // Appends a p element to the hoops-app div, inserts text inside

                d3.select("#new-paragraph")
                    .append("p")
                    .text("New paragraph!");

            //---------------------------------------------------------------------------------------------------------
            //---------------------------------------------------------------------------------------------------------

            //Select all p tags that exist, then check the data in the dataset.
            //If there are more data values than p tags, enter creates new placeholder elements
            //In these placeholder elements, append p tags for each datapoint and append the text to them

                d3.select("#data-driven-paragraphs").selectAll("p")
                    .data(htmldataset)
                    .enter()
                    .append("p")
                    .text(function(d){return d});


            //---------------------------------------------------------------------------------------------------------
            //---------------------------------------------------------------------------------------------------------

            //Select all divs, based on the dataset append each bit of data as a div, then apply bar class

                d3.select("#html-bar").selectAll("div")
                    .data(randdataset)
                    .enter()
                    .append("div")
                    .attr("class", "bar")
                    .style("height", function(d) {
                        let barHeight = d * 5;
                        return barHeight + "px";
                    });

            //---------------------------------------------------------------------------------------------------------
            //Using D3 to append SVG elements
            //---------------------------------------------------------------------------------------------------------

                let h1 = 100;
                let w1 = 500;
                let circledataset = [5, 10, 15, 20, 25];

                //if we append this to a variable, we can reference it later
                let svg1 = d3.select("#svg-intro")
                            .append("svg")
                            .attr("width", w1)
                            .attr("height", h1);

                //appending circle elements to the div and assigning a variable to that as well
                let circles = svg1.selectAll("circle")
                    .data(circledataset)
                    .enter()
                    .append("circle");

                //cx sets the x value of the circle, i is the index, so for every index push it over 50 then add 25
                circles.attr("cx", function(d, i){
                    return (i * 50) + 25;
                })
                //cy sets the y value, so we're setting it at half the height of the svg
                        .attr("cy", h1/2)
                //r is the radius, so we're setting each data point to the radius
                        .attr("r", function(d){
                            return d;
                        })
                //adding color attributes
                        .attr("fill", "yellow")
                        .attr("stroke", "orange")
                        .attr("stroke-width", function(d) {
                            return d/2;
                        });

            //---------------------------------------------------------------------------------------------------------
            // Bar Chart using D3 and SVG
            //---------------------------------------------------------------------------------------------------------

                let bardataset = [ 5, 10, 13, 19, 21, 25, 22, 18, 15, 13, 11, 12, 15, 20, 18, 17, 16, 18, 23, 25 ];

                let w2 = 500;
                let h2 = 100;
                let barPadding1 = 1;

                d3.select("#svg-bar-intro").selectAll("div")
                    .data(randdataset)
                    .enter()
                    .append("div")
                    .attr("class", "bar")
                    .style("height", function(d) {
                        let barHeight = d * 5;
                        return barHeight + "px";
                    });

                let svg2 = d3.select("#svg-bar-full")
                            .append("svg")
                            .attr("width", w2)
                            .attr("height", h2);

                svg2.selectAll("rect")
                    .data(bardataset)
                    .enter()
                    .append("rect")
                // X placement - for each index of the bar, multiply it by the width divided by the number of elements in the dataset
                    .attr("x", function(d, i){
                        return i * (w2 / bardataset.length);
                    })
                // Bar Width - make it as long as the total width divided by the length of the dataset, and leave room for padding
                    .attr("width", w2/bardataset.length - barPadding1)
                // Y AXIS IS TRICKY - SVG starts at the top left corner. By setting the height to each point and y to zero, it's upside down.
                // To account for this, "Y" should start at the height of the SVG minus the data, then use the height of each datapoint so it emulates starting at the bottom.
                // SVG basically goes from the top down instead of bottom up.
                    .attr("y", function(d){
                        return h2-d*4;
                    })
                    .attr("height", function(d){
                        return d * 4;
                    })
                //Shade the blue based on the dataset. Higher the bar, the more blue it is
                    .attr("fill", function(d) {
                        return "rgb(0, 0, " + Math.round(d * 10) + ")";
                    });

                svg2.selectAll("text")
                    .data(bardataset)
                    .enter()
                    .append("text")
                    .text(function(d){
                        return d;
                    })
                    .attr("x", function(d, i) {
                        return i * (w2 / bardataset.length) + (w2 / bardataset.length - barPadding1 ) / 2;
                    })
                    .attr("y", function(d) {
                        return h2 - (d * 4) + 15;
                    })
                    .attr("font-family", "sans-serif")
                    .attr("font-size", "11px")
                    .attr("fill", "white")
                    .attr("text-anchor", "middle");

            //---------------------------------------------------------------------------------------------------------
            //Scatterplot
            //---------------------------------------------------------------------------------------------------------

                let w3 = 500;
                let h3 = 100;

                let dataset = [
                    [ 5, 20 ],
                    [ 480, 90 ],
                    [ 250, 50 ],
                    [ 100, 33 ],
                    [ 330, 95 ],
                    [ 410, 12 ],
                    [ 475, 44 ],
                    [ 25, 67 ],
                    [ 85, 21 ],
                    [ 220, 88 ]
                    ];

                let xScale = d3.scaleLinear()
                    .domain([0, d3.max(dataset, function(d) { return d[0]; })])
                    .range([0, w3]);

                let svg = d3.select("#svg-scatterplot")
                            .append("svg")
                            .attr("width", w3)
                            .attr("height", h3)

                svg.selectAll("circle")
                    .data(dataset)
                    .enter()
                    .append("circle")
                    .attr("cx", function(d){
                        return xScale(d[0]);
                    })
                    .attr("cy", function(d){
                        return d[1];
                    })
                    // Display the area as y value instead of the radius. Easier to compare this way.
                    // Area = pi*r2, so in this case sqrt of radius / pi.
                    // However dividing by pi just makes it smaller, so we can remove this.
                    .attr("r", function(d){
                        //return d[1];
                        return Math.sqrt( (h3 - d[1]))
                    });

                svg.selectAll("text")
                    .data(dataset)
                    .enter()
                    .append("text")
                    .text(function(d){
                        return d[0] + "," + d[1];
                    })
                    .attr("x", function(d){
                        return d[0];
                    })
                    .attr("y", function(d){
                        return d[1];
                    })
                    .attr("font-family", "sans-serif")
                    .attr("font-size", "11px")
                    .attr("fill", "red");

            //---------------------------------------------------------------------------------------------------------
            // Scales
            //---------------------------------------------------------------------------------------------------------

            // Input Domain (ie 100 - 500), Output Range (0-100 pixels)
            // Creating Random dataset with massive numbers, just to scale them to the bar chart and colors properly

            // Random Dataset
                let randdataset2 = []; //Initialize empty array
                for (let i = 0; i < 25; i++) { //Loop 25 times
                    let newNumber2 = Math.random() * 100; //New random number (0-30)
                    newNumber2 = Math.floor(newNumber2);
                    randdataset2.push(newNumber2); //Add new number to array
                }
                let h4 = 150;
                let w4 = 600;
                let barPadding4 = 1;

                let svg3 = d3.select("#scales")
                    .append("svg")
                    .attr("width", w4)
                    .attr("height", h4);

                // These are the scale values. The domain is the data, the range is what you want to scale it to.
                // You can either use range, or rangeRound which rounds to the nearest whole number

                let yScale = d3.scaleLinear()
                    .domain([0, d3.max(randdataset2)])
                    .rangeRound([0, h4])

                let colorScale = d3.scaleLinear()
                    .domain([0, d3.max(randdataset2)])
                    .rangeRound([0, 255]);


                svg3.selectAll("rect")
                    .data(randdataset2)
                    .enter()
                    .append("rect")
                    .attr("test", function(d){
                        return d;
                    })
                    .attr("x", function(d, i){
                        return i * (w4 / randdataset2.length);
                    })
                    .attr("width", w4/randdataset2.length - barPadding4)
                    .attr("y", function(d){
                        return h4-yScale(d);
                    })
                    .attr("height", function(d){
                        return yScale(d);
                    })
                    .attr("fill", function(d) {
                        return "rgb(0, 0, " + colorScale(d) + ")";
                    });


                svg3.selectAll("text")
                    .data(randdataset2)
                    .enter()
                    .append("text")
                    .text(function(d){
                        return d;
                    })
                    .attr("x", function(d, i) {
                        return i * (w4 / randdataset2.length) + ( w4/randdataset2.length - barPadding4) / 2;
                    })
                    .attr("y", function(d) {
                        return h4-yScale(d) + 10;
                    })
                    .attr("font-family", "sans-serif")
                    .attr("font-size", "11px")
                    .attr("fill", "white")
                    .attr("text-anchor", "middle");


            //---------------------------------------------------------------------------------------------------------
            // Axes
            //---------------------------------------------------------------------------------------------------------

            let w5 = 500;
            let h5 = 300;
            let padding = 30;

            //Dynamic, random dataset
            let dataset3 = [];
            let numDataPoints = 50;
            let xRange = Math.random() * 1000;
            let yRange = Math.random() * 1000;
            for (let i = 0; i < numDataPoints; i++) {
                var newNumber1 = Math.floor(Math.random() * xRange);
                var newNumber2 = Math.floor(Math.random() * yRange);
                dataset3.push([newNumber1, newNumber2]);
            }

            let xScale2 = d3.scaleLinear()
                .domain([0, d3.max(dataset3, function(d) { return d[0]; })])
                .range([padding, w5 - padding * 2]);

            let yScale2 = d3.scaleLinear()
                .domain([0, d3.max(dataset3, function(d) { return d[1]; })])
                .range([h5 - padding, padding])

            let aScale = d3.scaleSqrt()
                .domain([0, d3.max(dataset3, function(d) { return d[1]; })])
                .range([0,10])

            let svg4 = d3.select("#axis")
                .append("svg")
                .attr("width", w5)
                .attr("height", h5)

            svg4.selectAll("circle")
                .data(dataset3)
                .enter()
                .append("circle")
                .attr("cx", function(d){
                    return xScale2(d[0]);
                })
                .attr("cy", function(d){
                    return yScale2(d[1]);
                })
                .attr("r", function(d){
                    return aScale(d[1])
                    //return rScale(d[1]);
                });

            // svg4.selectAll("text")
            //     .data(dataset3)
            //     .enter()
            //     .append("text")
            //     .text(function(d){
            //         return d[0] + "," + d[1];
            //     })
            //     .attr("x", function(d){
            //         return xScale2(d[0]);
            //     })
            //     .attr("y", function(d){
            //         return yScale2(d[1]);
            //     })
            //     .attr("font-family", "sans-serif")
            //     .attr("font-size", "11px")
            //     .attr("fill", "red");

            // New code. Functions include axisBottom, left, right, top, tells it where to place the axis.
            // Then uses the scale to determine the range.
            // You also need to create a new append to the dom, so it knows where to append the axis
            // This is because you're drawing it to the screen and not just doing a calculation like the scales.
            // "g" is just a group element, it doesn't actually hold any other data like square or circle.
            // Then the call function passes the previous item (the appended "g") to the xAxis

            let xAxis = d3.axisBottom()
                .scale(xScale2)
                .ticks(5);
                // D3 will automatically judge and add ticks. To customize, you can pass a number through,
                // Or use .tickValues to manually add what you want.
                // Passing a number won't always be that specific number though. When you pass 5 there are actually 7
                // Because it uses logic to determine that increments of 100 is cleaner.
                // .tickValues([0,100,250,500,600]);


            // Appending classes to new dom elements such as axis is helpful, makes it easier to find and troubleshoot
            // Transform statement will move the axis from the top of the chart to the bottom in this case
            //    It actually moves the item based on (x,y) coordinates, so in this case we move it down to the bottom by using the height value in place of y
            svg4.append("g")
                .attr("class", "axis")
                .attr("transform", "translate(0, " + (h5 - padding) + ")")
                .call(xAxis);

            // Adding axis class makes it easy to override the default CSS for axis styling - see below
            // Use SVG properties for axes, not CSS. This gets tricky because there is some overlap but not always.

            let yAxis = d3.axisLeft()
                .scale(yScale2)
                .ticks(5);

            svg4.append("g")
                .attr("class", "axis")
                .attr('transform', "translate(" + padding + ",0)")
                .call(yAxis);

            // You can change the formatting using tickformat. From $ or % to time.
            // let formatAsPercentage = d3.format(".1%");
            // xAxis.tickFormat(formatAsPercentage);


            //---------------------------------------------------------------------------------------------------------
            // Updates, Transitions, Motion CH9
            //---------------------------------------------------------------------------------------------------------

            // let randdataset3 = []; //Initialize empty array
            // for (let i = 0; i < 25; i++) { //Loop 25 times
            //     let newNumber2 = Math.random() * 100; //New random number (0-30)
            //     newNumber2 = Math.floor(newNumber2);
            //     randdataset3.push(newNumber2); //Add new number to array
            // }

            let randdataset3=  [ 5, 10, 13, 19, 21, 25, 22, 18, 15, 13, 11, 12, 15, 20, 18, 17, 16, 18, 23, 25 ];

            let h6 = 150;
            let w6 = 600;
            let barPadding3 = 1;

            let svg5 = d3.select("#current")
                .append("svg")
                .attr("width", w6)
                .attr("height", h6);

            // This is the new code here. We are using the Band scale instead which uses ordinal values instead of numeric
            // Therefore we could have A, B, C, D, E instead of 0-100 (or in this case 0-20 or however many bars we have)
            // Range, and round, are two separate functions, or you can just use rangeRound

            let xScale4 = d3.scaleBand()
                .domain(d3.range(randdataset3.length))
                .rangeRound([0, w6])
            // Without the round function it could have decimals which will make the bar blurry
                .paddingInner(0.05);

            let yScale4 = d3.scaleLinear()
                .domain([0, d3.max(randdataset3)])
                .rangeRound([0, h4])

            let colorScale4 = d3.scaleLinear()
                .domain([0, d3.max(randdataset3)])
                .rangeRound([0, 255]);


            svg5.selectAll("rect")
                .data(randdataset3)
                .enter()
                .append("rect")
                .attr("test", function(d){
                    return d;
                })
                .attr("x", function(d, i){
                    return xScale4(i);
                })
                .attr("width", xScale4.bandwidth())
                .attr("y", function(d){
                    return h6 - yScale4(d);
                })
                .attr("height", function(d){
                    return yScale4(d);
                })
                .attr("fill", function(d) {
                    return "rgb(0, 0, " + colorScale4(d) + ")";
                });


            svg5.selectAll("text")
                .data(randdataset3)
                .enter()
                .append("text")
                .text(function(d){
                    return d;
                })
                .attr("x", function(d, i) {
                    return i * (w6 / randdataset3.length) + ( w6/randdataset3.length - barPadding3) / 2;
                })
                .attr("y", function(d) {
                    return h6 - yScale4(d) + 15;
                })
                .attr("font-family", "sans-serif")
                .attr("font-size", "11px")
                .attr("fill", "white")
                .attr("text-anchor", "middle");

            d3.select("#current")
                .on("click", function() {
                    //randdataset3 = [ 11, 12, 15, 20, 18, 17, 16, 18, 23, 25,
                    //    5, 10, 13, 19, 21, 25, 22, 18, 15, 13 ];
                    randdataset3.push(Math.round(Math.random() * 25));
                    console.log(randdataset3);

                    if(randdataset3.length > 25){
                        w6 = 800;
                    }
                    if(randdataset3.length > 35){
                        w6 = 1000;
                    }

                    let updxScale = d3.scaleBand()
                        .domain(d3.range(randdataset3.length))
                        .rangeRound([0, w6])
                        // Without the round function it could have decimals which will make the bar blurry
                        .paddingInner(0.05);

                    let updyScale = d3.scaleLinear()
                        .domain([0, d3.max(randdataset3)])
                        .rangeRound([0, h6])

                    let updcolorScale = d3.scaleLinear()
                        .domain([0, d3.max(randdataset3)])
                        .rangeRound([0, 255]);

                    d3.select("#current").select("svg").remove();
                    // svg5.append("svg")
                    //     .attr("width", w6)
                    //     .attr("height", h6);

                    let svgclick = d3.select("#current")
                        .append("svg")
                        .attr("width", w6)
                        .attr("height", h6)

                    svgclick.selectAll("rect")
                        .data(randdataset3)
                        .enter()
                        .append("rect")
                        .attr("x", function(d, i){
                            return updxScale(i);
                        })
                        .attr("width", updxScale.bandwidth())
                        .attr("y", function(d){
                            return h6 - updyScale(d);
                        })
                        .attr("height", function(d){
                            return updyScale(d);
                        })
                        .attr("fill", function(d) {
                            return "rgb(0, 0, " + updcolorScale(d) + ")";
                        });
                    svgclick.selectAll("text")
                        .data(randdataset3)
                        .enter()
                        .append("text")
                        .text(function(d){
                            return d;
                        })
                        .attr("x", function(d, i) {
                            return i * (w6 / randdataset3.length) + ( w6/randdataset3.length - barPadding3) / 2;
                        })
                        .attr("y", function(d) {
                            return h6 - updyScale(d) + 15;
                        })
                        .attr("font-family", "sans-serif")
                        .attr("font-size", "11px")
                        .attr("fill", "white")
                        .attr("text-anchor", "middle");
                })


        })
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

