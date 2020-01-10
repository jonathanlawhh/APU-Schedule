<template>
    <v-bottom-sheet v-model="sheetOpen">
        <v-sheet class="text-center" height="100%">
            <div v-if="result.length > 0">
                <v-row v-bind:class="emptyForTheDay(result[result.length - 1 ].TIME_TO ) && 'teal white--text' ">
                    <v-spacer></v-spacer>
                    <v-col cols="6" class="text-left">
                        <span class="font-weight-bold">{{ ( result.length > 0 ) ? result[0].ROOM : '' }}</span><br>
                        {{ ( result.length > 0 ) ? result[0].DATESTAMP_ISO : '' }}<br>
                        <span style="font-size: 70%" v-if="emptyForTheDay(result[result.length - 1 ].TIME_TO )">Empty for the day</span>
                    </v-col>
                    <v-col cols="4">
                        <v-icon @click="sheetOpen = false">close</v-icon>
                    </v-col>
                </v-row>
                <v-divider></v-divider>

                <v-simple-table>
                    <thead>
                    <tr>
                        <td>Time from</td><td>Time to</td>
                    </tr>
                    </thead>
                    <tr v-for="(c, i) in result" v-bind:key="i">
                        <td>{{ c.TIME_FROM }}</td>
                        <td>{{ c.TIME_TO }}</td>
                    </tr>
                </v-simple-table>
            </div>

            <div v-if="result.length === 0">
                <v-row class="teal white--text">
                    <v-spacer></v-spacer>
                    <v-col cols="6" class="text-left">
                        <p style="font-size: 180%">ಠ⌣ಠ</p>
                        <h3>No classes here today</h3>
                    </v-col>
                    <v-col cols="4">
                        <v-icon @click="sheetOpen = false">close</v-icon>
                    </v-col>
                </v-row>
            </div>
        </v-sheet>
    </v-bottom-sheet>
</template>

<script>
    import * as f from "../functions";

    export default {
        name: "EmptyClassSchedule",
        props: ["sheet","result", "isEmptyTillEnd"],
        data : () => {
          return {
              sheetOpen : false
          }
        },
        watch: {
            sheet(val){
                let s = val;
                this.sheetOpen = s;
            },
            sheetOpen: function (val){
                let s = val;
                this.$emit('sheetOpen', s);
            }
        },
        methods: {
            emptyForTheDay(last_timeto){
                let timestamp = f.getCurrentTimestamp();
                return ( f.normalizeTime(last_timeto) < timestamp );
            }
        }
    }
</script>
