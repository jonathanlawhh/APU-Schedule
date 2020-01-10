<template>
    <div>
        <v-row>
            <v-col cols="7" sm="6" md="2" class="paddingFix">
                <v-autocomplete label="Classroom" placeholder="Lab 4-XX" outlined dense v-model="selected_class" :items="classrooms" v-on:change="doSearch"></v-autocomplete>
            </v-col>
            <v-col cols="5" sm="7" md="2" class="paddingFix">
                <v-select label="Day" :items="days" v-model="selected_day" outlined dense v-on:change="doSearch"></v-select>
            </v-col>
            <v-col cols="12" sm="5" md="3" style="padding-top: 0">
                <v-btn style="width: 100%" outlined color="teal" v-on:click="doSearch">SEARCH ME ◉_◉</v-btn>
            </v-col>
        </v-row>

        <v-row v-if="searchResult.length === 0">
            <v-col cols="12">
                <v-card outlined>
                    <v-card-text>
                        <p class="display-1">{{ notice }}</p>
                        <h5>Usage</h5>
                        <p>
                            The keyword [ Tech Lab x-xx, B-XX-XX etc ] is used to search for classes<br>
                            Check the more tab
                        </p>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>

        <v-row v-if="searchResult.length > 0">
            <h5>Showing results for {{ searchResult.length > 0 ? searchResult[0].ROOM : '' }} on {{ searchResult.length > 0 ? searchResult[0].DATESTAMP + ' ( ' + searchResult[0].DAY + ' )' : '' }}</h5>
            <v-simple-table style="overflow-y: auto; margin-top: 3%;">
                <template v-slot:default>
                    <thead>
                        <tr>
                            <th>From</th>
                            <th>To</th>
                            <th>Lecturer</th>
                            <th>Intake</th>
                            <th>Module</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(r, i) in searchResult" :key="i" v-bind:class="{ 'deep-orange lighten-5' : hasClassNow(r.TIME_FROM, r.TIME_TO) }">
                        <td>{{ r.TIME_FROM }}</td>
                        <td>{{ r.TIME_TO }}</td>
                        <td>{{ r.NAME }}</td>
                        <td>{{ r.INTAKE }}</td>
                        <td>{{ r.MODID }}</td>
                    </tr>
                    </tbody>
                </template>
            </v-simple-table>
        </v-row>
    </div>
</template>

<style scoped>
    .paddingFix {
        padding-bottom: 0;
        padding-top: 0;
    }
</style>

<script>
    import * as f from '../functions'

    export default {
        name: "ClassroomSearchPage",
        data : () => ({
            notice : "ಠ_ಠ",
            schedule : [],
            selected_day : "TODAY",
            selected_class : '',
            days : ["SUN", "MON","TUE","WED","THU","FRI","SAT"],
            classrooms : [],
            searchResult : []
        }),
        methods : {
            doSearch(){
                let searchResult = [];
                for (let i = 0; i < this.schedule.length; i++)
                    if(this.schedule[i].DAY === this.selected_day && this.schedule[i].ROOM === this.selected_class) searchResult.push(this.schedule[i]);

                ( searchResult.length > 0 ) ? (
                    searchResult.sort(function(a, b) {
                        return f.normalizeTime(a.TIME_FROM) - f.normalizeTime(b.TIME_FROM);
                    }) ) : this.notice = "ಠ╭╮ಠ  NADA" ;

                this.searchResult = searchResult;
            },
            hasClassNow(timefrom, timeto){
                let timestamp = f.getCurrentTimestamp();
                return (f.normalizeTime(timefrom) <= timestamp && f.normalizeTime(timeto) >= timestamp);
            }
        },
        async mounted() {
            this.selected_day = this.days[new Date().getDay()];
            this.schedule =  await f.loadSchedule();
            this.classrooms = await f.getClassroomList(this.schedule);
        }
    }
</script>
