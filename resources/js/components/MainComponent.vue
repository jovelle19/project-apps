<template lang="">
    <v-app>
        <div class="container pa-10">
            <div class="d-flex justify-center align-center">
                <v-btn
                    success
                    rounded
                    dark
                    class="mb-3 font-weight-bold"
                    @click="create"
                >
                    Create new article
                </v-btn>
            </div>

            <div cols="12" lg="10" md="12" class="py-3 px-8">
                <v-card
                    class="my-0"
                    v-for="article in articles"
                    :key="article.id"
                    v-if="articles"
                >
                    <v-card-title
                        class="text-h5 card-title-text font-weight-light pa-2 px-3"
                    >
                        {{ article.title }}
                    </v-card-title>
                    <v-divider class="my-0"></v-divider>
                    <v-card-text class="py-2" @click="showArticle(article)">
                        <v-container class="dialog-container mt-2">
                            <v-row>
                                <p class="text-body">{{ article.content }}</p>
                                <p class="text-caption">
                                    {{ article.created_at }}
                                </p>
                            </v-row>
                            <p></p
                        ></v-container>
                    </v-card-text>
                    <v-card-actions class="dialog-footer">
                        <v-spacer></v-spacer>
                        <v-btn
                            dense
                            color="primary"
                            @click="unlike_article(article.id)"
                        >
                            <v-icon small title--text class="mr-1">
                                mdi-thumb-down-outline
                            </v-icon>

                            {{ article.unlikes }} Unlike
                        </v-btn>
                        <v-btn
                            dense
                            color="primary"
                            @click="like_article(article.id)"
                        >
                            <v-icon small title--text class="mr-1">
                                mdi-thumb-up
                            </v-icon>
                            {{ article.likes }} Like
                        </v-btn>
                        <v-btn
                            dense
                            color="primary"
                            @click="deleteArticle(article.id)"
                        >
                            <v-icon small title--text class="mr-1">
                                mdi-trash
                            </v-icon>
                            Delete
                        </v-btn>
                    </v-card-actions>
                </v-card>

                <v-card class="my-0" v-if="!hasArticle">
                    <v-card-text class="py-2">
                        <v-container class="mt-2">
                            <v-row>
                                <p class="text-body">No articles posted</p>
                            </v-row>
                            <p></p
                        ></v-container>
                    </v-card-text>
                </v-card>
            </div>

            <v-dialog
                v-model="dialogCreateArticle"
                persistent
                scrollable
                width="500"
                eager
            >
                <v-form
                    ref="form"
                    v-model="valid"
                    lazy-validation
                    @keydown.native.enter="createArticle"
                >
                    <v-card class="my-0">
                        <v-card-title class="text-h5 font-weight-light pa-2">
                            Create Article
                            <v-spacer></v-spacer>
                            <v-icon
                                class="text-color white--text"
                                medium
                                @click="dialog = false"
                                >mdi-close</v-icon
                            >
                        </v-card-title>
                        <v-divider class="my-0"></v-divider>
                        <v-card-text class="py-2">
                            <v-container class="dialog-container">
                                <v-row>
                                    <v-col cols="12" class="mt-0">
                                        <label class="py-2">Enter Title</label>

                                        <v-text-field
                                            class="custom-label-color"
                                            v-model="form.title"
                                            label="title"
                                            single-line
                                            hide-details
                                            dense
                                            outlined
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" class="mt-0">
                                        <label class="py-2"
                                            >Enter Content</label
                                        >

                                        <v-textarea
                                            class="custom-placeholder-color"
                                            type="text"
                                            variant="filled"
                                            auto-grow
                                            outlined
                                            required
                                            v-model="form.content"
                                        ></v-textarea>

                                        <v-card-actions
                                            class="dialog-footer my-0"
                                        >
                                            <v-spacer></v-spacer>
                                            <v-btn
                                                class="white--text"
                                                color="error"
                                                dense
                                                @click="
                                                    dialogCreateArticle = false
                                                "
                                            >
                                                Close
                                            </v-btn>

                                            <v-btn
                                                color="primary"
                                                densed
                                                @click="submit"
                                                :loading="loading"
                                            >
                                                Create
                                            </v-btn>
                                        </v-card-actions>
                                    </v-col>
                                </v-row>
                            </v-container>
                        </v-card-text>
                    </v-card>
                </v-form>
            </v-dialog>

            <v-dialog v-model="dialogShowArticle" max-width="600" persistent>
                <div>
                    <v-card>
                        <v-card-title class="text-h5 font-weight-light">
                            View
                            <v-spacer></v-spacer>
                            <v-icon
                                class="text-color"
                                medium
                                @click="dialogShowArticle = false"
                                >mdi-close</v-icon
                            >
                        </v-card-title>
                        <v-card-text
                            class="d-flex flex-column justify-center align-center"
                        >
                            <p
                                class="text-capitalize font-weight-black text-center"
                            >
                                {{ selectedArticle.title }}
                            </p>
                            <p class="text-capitalize text-center">
                                {{ selectedArticle.content }}
                            </p>
                            <p class="text-body text-center">
                                {{ selectedArticle.created_at }}
                            </p>
                        </v-card-text>
                        <v-card-actions class="">
                            <v-spacer></v-spacer>
                            <v-btn
                                dense
                                color="error"
                                @click="dialogShowArticle = false"
                            >
                                Close
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </div>
            </v-dialog>

            <v-dialog v-model="dialogDelete" max-width="550" persistent>
                <v-card class="pa-10">
                    <v-card-text
                        class="d-flex flex-column justify-center align-center pb-0"
                    >
                        <v-icon elevation="10" size="100" color="error">
                            mdi-alert-circle</v-icon
                        >
                        <p
                            class="text-capitalize font-weight-black mt-8 text-center"
                        >
                            Are you sure you want to delete this?
                        </p>
                        <div class="d-flex flex-row">
                            <v-btn
                                @click="dialogDelete = false"
                                color="primary"
                                outlined
                                class="text-capitalize mt-2 mr-4"
                            >
                                No
                            </v-btn>
                            <v-btn
                                @click="deletethisArticle()"
                                color="primary"
                                class="text-capitalize mt-2"
                                :loading="loading"
                            >
                                Yes
                            </v-btn>
                        </div>
                    </v-card-text>
                </v-card>
            </v-dialog>
        </div>
    </v-app>
</template>
<script>
import axios from "axios";
import Articles from "./Articles/index.vue";
export default {
    components: {
        Articles,
    },
    data() {
        return {
            selectedArticle: "",
            selectedId: "",
            loading: false,
            dialogCreateArticle: false,
            dialogDelete: false,
            dialogShowArticle: false,
            dialog: false,
            valid: false,
            form: {},
            image_url: "",
            selected_article: "",
            articles: [],
            hasArticle: false,
        };
    },
    methods: {
        create() {
            this.dialogCreateArticle = true;
        },
        submit() {
            if (this.$refs.form.validate()) {
                console.log(this.form);
                this.loading = true;
                axios
                    .post("/create", this.form)
                    .then((res) => {
                        console.log(res);
                        this.$refs.form.reset();
                        this.$refs.form.resetValidation();
                        this.dialog = false;
                        alert("Successfully Saved");
                        this.loading = false;
                        this.dialogCreateArticle = false;

                        this.getArticles();
                    })
                    .catch((error) => {});
            }
        },
        getArticles() {
            axios
                .get("/articles")
                .then((res) => {
                    console.log(res.data);
                    this.articles = res.data;
                    let arr = res.data;
                    if (arr.length > 0) {
                        this.hasArticle = true;
                    } else {
                        this.hasArticle = false;
                    }
                })
                .catch((error) => {
                    if (error.response.status === 401) {
                    }
                });
        },
        deleteArticle(id) {
            this.selectedId = id;
            this.dialogDelete = true;
        },
        deletethisArticle() {
            let form = {
                id: this.selectedId,
            };
            this.loading = true;
            axios
                .post("/delete", form)
                .then((res) => {
                    alert("Successfully Deleted");
                    this.getArticles();
                    this.dialogDelete = false;
                    this.loading = false;
                })
                .catch((error) => {
                    if (error.response.status === 401) {
                    }
                });
        },
        like_article(id) {
            let form = {
                id: id,
            };
            axios
                .post("/like-article", form)
                .then((res) => {
                    this.getArticles();
                })
                .catch((error) => {
                    if (error.response.status === 401) {
                    }
                });
        },
        unlike_article(id) {
            let form = {
                id: id,
            };
            axios
                .post("/unlike-article", form)
                .then((res) => {
                    this.getArticles();
                })
                .catch((error) => {
                    if (error.response.status === 401) {
                    }
                });
        },
        showArticle(data) {
            this.dialogShowArticle = true;
            this.selectedArticle = data;
        },
    },
    mounted() {
        this.getArticles();
    },
};
</script>
<style lang="scss" scoped>
html,
body {
    height: 100%;
    margin: 0;
}
</style>

<style scoped lang="scss">
@import "../../../public/css/app.css";
</style>
