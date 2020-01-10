<template>
    <div>
        <v-row>
            <v-col cols="12" lg="6">
                <v-card>
                    <v-card-title>App Settings</v-card-title>
                    <v-card-text>
                        <v-row>
                            <v-col cols="12">
                                <v-switch @change="switchTheme" :value="dark_theme" label="Dark theme" color="teal"></v-switch>
                            </v-col>
                        </v-row>

                    </v-card-text>
                </v-card>
            </v-col>
            <v-col cols="12" lg="6">
                <v-card>
                    <v-card-title>App Data</v-card-title>
                    <v-card-text>
                        <v-col cols="12">
                            <p>Number of cache : {{ this.cache_count }}</p>
                            <v-btn v-on:click="clean_cache">Clear cache</v-btn>
                        </v-col>

                        <v-col cols="12">
                            <p>Number of local storage : {{ this.storage_count }}</p>
                            <v-btn v-on:click="clean_storage">Clear storage</v-btn>
                        </v-col>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </div>
</template>

<script>
    export default {
        name: "MorePage",
        data : () => ({
            dark_theme : null,
            cache_count : null,
            storage_count : null
        }),
        methods: {
            switchTheme(t) {
                (!t) ? localStorage.removeItem("darktheme") : localStorage.setItem("darktheme", true);
                this.$vuetify.theme.dark = t;
            },
            clean_cache(){
                let self = this;
                caches.keys().then((names) => {
                    for(let i = 0; i < names.length; i++) caches.delete(names[i]);
                    self.cache_count = 0;
                });
            },
            clean_storage(){
                localStorage.clear();
                this.storage_count = localStorage.length;
            }
        },
        watch: {
            dark_theme(newVal) {
                this.switchTheme(newVal)
            }
        },
        mounted() {
            this.dark_theme = this.$vuetify.theme.dark;
            let self = this;
            caches.keys().then((names) => { self.cache_count = names.length; });
            this.storage_count = localStorage.length;
        }
    }
</script>
