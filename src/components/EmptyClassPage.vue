<template>
    <div>
        <v-row>
            <v-chip style="margin: 5px" v-on:click="filterClass('ALL')">ALL</v-chip>
            <v-chip style="margin: 5px" v-on:click="filterClass('B-')">Block B</v-chip>
            <v-chip style="margin: 5px" v-on:click="filterClass('D-')">Block D</v-chip>
            <v-chip style="margin: 5px" v-on:click="filterClass('E-')">Block E</v-chip>
            <v-chip style="margin: 5px" v-on:click="filterClass('Au')">Auditoriums</v-chip>
            <v-chip style="margin: 5px" v-on:click="filterClass('Te')">APU Labs</v-chip>
            <v-chip style="margin: 5px" v-on:click="filterClass('La')">APIIT Labs</v-chip>
            <v-chip style="margin: 5px" v-on:click="searchByFloor = !searchByFloor">Filter by floors</v-chip>
            <v-chip style="margin: 5px" v-on:click="emptyClassDisplay = []">Clear filter</v-chip>
        </v-row>
        <v-row>
            <v-chip v-show="searchByFloor" v-for="i in 9" v-bind:key="i" style="margin: 5px; width: 60px"
                    v-on:click="filterLevel(i)">{{ i }}</v-chip>
        </v-row>

        <v-row v-if="emptyClassDisplay.length > 0">
            <v-col v-for="(c, i) in emptyClassDisplay" v-bind:key="i" cols="6" sm="6" md="3">
                <v-card v-bind:class="displayEmpty(c) && 'class-empty'">
                    <v-card-text>
                        <h5>{{ c }}</h5>
                        <p v-on:click="displayClassTimetable(c)" class="open_url">Schedule here</p>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>

        <v-row v-if="!(emptyClassDisplay.length > 0)">
            <v-col cols="12">
                <v-card outlined>
                    <v-card-text>
                        <p class="display-1">(°ロ°)☝</p>
                        <h5>Hey there...</h5>
                        <p>Choose a filter from above </p>
                        <p>Last updated on {{ today }}, {{ timestamp }}</p>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>

        <EmptyClassSchedule :sheet="sheet" :result="searchResult" @sheetOpen="updateSheetStatus" />

    </div>
</template>

<script>
    import * as f from '../functions'
    const EmptyClassSchedule = () => import('./EmptyClassSchedule')

    const zeroPad = (num, places) => String(num).padStart(places, '0')

    export default {
        name: "EmptyClassPage",
        components: {
          EmptyClassSchedule
        },
        data : () => ({
            today : "TODAY",
            timestamp : "",
            days : ["SUN", "MON","TUE","WED","THU","FRI","SAT"],
            schedule : [],
            classrooms : [],
            classrooms_today: [],
            emptyClass : [],
            emptyClassDisplay : [],
            searchResult : [],
            sheet: false,
            searchByFloor: false
        }),
        methods: {
            classroomsToday(){
              this.classrooms_today = this.schedule.filter( d => d.DAY === this.today );
            },
            hasClassNow(timefrom, timeto){
                let timestamp = f.getCurrentTimestamp();
                return (f.normalizeTime(timefrom) <= timestamp && f.normalizeTime(timeto) >= timestamp);
            },
            findEmptyClass(){
                let classes_today = this.classrooms_today.filter( d => this.hasClassNow(d.TIME_FROM, d.TIME_TO) );

                classes_today = classes_today.map((f) => f.ROOM);
                classes_today = Array.from(new Set(classes_today));

                this.emptyClass = this.classrooms.filter( function( el ) {
                    return !classes_today.includes( el );
                });
            },
            filterClass(block){
                this.emptyClassDisplay = [];
                if( block === "ALL" ){
                    this.emptyClassDisplay = this.emptyClass;
                } else {
                    for(let i = 0; i < this.emptyClass.length; i++){
                        if( this.emptyClass[i].substring(0,2) === block ) this.emptyClassDisplay.push(this.emptyClass[i]);
                    }
                }
            },
            filterLevel(lvl){
                this.emptyClassDisplay = [];
                for(let i = 0; i < this.emptyClass.length; i++){
                    let c = this.emptyClass[i].split("-");
                    if( c[0].length === 1 && c[1] === zeroPad(lvl, 2) )
                        this.emptyClassDisplay.push(this.emptyClass[i]);
                }
            },
            doSearch(classroom){
                let searchResult = this.classrooms_today.filter((f) => f.ROOM === classroom );

                let temp = [];
                if ( searchResult.length > 0 ){
                    searchResult.sort(function(a, b) {
                        return f.normalizeTime(a.TIME_FROM) - f.normalizeTime(b.TIME_FROM);
                    });

                    temp = [ searchResult[0] ] ;
                    for(let i = 0; i < searchResult.length; i++)
                        if( ( i - 1 > 0) && searchResult[i].TIME_FROM !== searchResult[i - 1].TIME_FROM ) temp.push(searchResult[i]);
                }

                return temp;
            },
            emptyForTheDay(last_timeto){
                let timestamp = f.getCurrentTimestamp();
                return ( f.normalizeTime(last_timeto) < timestamp );
            },
            displayClassTimetable(classroom){
                this.searchResult = this.doSearch(classroom);
                this.sheet = true;
            },
            displayEmpty(classroom){
                let temp = this.doSearch(classroom);
                return ( temp.length !== 0 ) ? this.emptyForTheDay(temp[temp.length - 1].TIME_TO) : true;
            },
            updateSheetStatus(status){
                this.sheet = status;
            }
        },
        async mounted() {
            let da = new Date();
            this.timestamp = f.getCurrentTimestamp();
            this.today = this.days[da.getDay()];
            this.schedule =  await f.loadSchedule();
            this.classrooms = f.getClassroomList(this.schedule);
            this.classroomsToday();
            await this.findEmptyClass();
        }
    }
</script>

<style scoped>
    .class-empty {
        border-left: 5px solid teal !important;
    }
    .open_url {
        cursor: pointer;
    }
</style>
