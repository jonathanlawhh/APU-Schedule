<template>
  <v-app>
    <v-card class="container">
      <v-card-title class="text-left">
        <h3>APU-Schedule</h3>
      </v-card-title>

      <v-tabs v-model="tab" background-color="transparent" color="teal">
        <v-tab>Search </v-tab>
        <v-tab>Empty Classes</v-tab>
        <v-tab>More</v-tab>
      </v-tabs>

      <v-tabs-items v-model="tab" touchless>
        <v-tab-item>
          <v-card flat>
            <v-card-text>
              <classroom-search-page></classroom-search-page>
            </v-card-text>
          </v-card>
        </v-tab-item>

        <v-tab-item>
          <v-card flat>
            <v-card-text>
              <empty-class-page></empty-class-page>
            </v-card-text>
          </v-card>
        </v-tab-item>

        <v-tab-item>
          <v-card flat>
            <v-card-text>
              <more-page></more-page>
            </v-card-text>
          </v-card>
        </v-tab-item>

      </v-tabs-items>
    </v-card>

    <v-card class="teal white--text container" style="margin-top: 3%" tile>
      <v-row>
        <v-col cols="12" class="text-right">
          <span style="margin: 10px;">
            &copy; {{ new Date().getFullYear() }} | <span style="background-color: white; padding-left: 5px; padding-right: 5px" class="teal--text"> jonathan law </span>
          </span>
        </v-col>
      </v-row>
    </v-card>

  </v-app>
</template>

<script>
  const ClassroomSearchPage = () => import("./components/ClassroomSearchPage");
  const EmptyClassPage = () => import("./components/EmptyClassPage");
  const MorePage = () => import("./components/MorePage");

  export default {
    components : {
      ClassroomSearchPage, EmptyClassPage, MorePage
    },
    data () {
      return {
        tab: null,
      }
    }
  }
</script>
