<template>
    <form
        class="link-form"
        method="POST"
        action="/i"
        @submit="sendLink"
        v-bind:class="{ 'was-validated': link }"
    >
        <input type="hidden" name="_token" :value="csrf" />
        <div class="mb-3 d-flex flex-column">
            <label for="url" class="form-label"
                ><b>Input your URL here:</b></label
            >
            <input
                id="url"
                class="form-control url-control"
                name="url"
                placeholder="http://example.com"
                type="text"
                aria-describedby="urlFeedback"
                required
                v-model="url"
                v-bind:class="{ 'is-invalid': error }"
            />
            <div id="urlFeedback" class="invalid-feedback error">
                <div class="error-text">{{ error }}</div>
                <ul class="error-description">
                    <error-description
                        v-for="(descr, i) of errorDescription"
                        v-bind:key="i"
                        v-bind:descr="descr"
                    ></error-description>
                </ul>
            </div>
            <button type="submit" class="btn btn-primary mt-2">
                Get short-link
            </button>
        </div>

        <div
            class="link-alert alert alert-success activated"
            role="alert"
            v-bind:class="{ active: link }"
        >
            Your short-link:
            <a :href="link" class="link-text" target="_blank">{{ link }}</a>
            <span class="copy-link activated" title="copy"></span>
        </div>
    </form>
</template>

<script>
export default {
    data: () => ({
        csrf: document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content"),
        url: "",
        link: "",
        error: "",
        errorDescription: [],
    }),
    mounted() {
        this.$nextTick(function () {

            const _this = this;

            if (location.protocol === "https:") {
                const copyLink = document.querySelector(".copy-link");
                copyLink.classList.add("active");
                copyLink.onclick = (e) => {
                    navigator.clipboard.writeText(_this.link);
                };
            }
        });
    },
    methods: {
        sendLink(e) {
            e.preventDefault();

            const _this = this;

            this.removeErrorTitle();

            axios
                .post("/api/i", { csrf: this.csrf, url: this.url })
                .then((response) => {
                    if (response.data.status === "error") {
                        _this.showError(response);
                    } else {
                        _this.link = response.data.message;
                        _this.error = "";
                        _this.errorDescription = [];
                    }
                })
                .catch((error) => {
                    if (error.response) {
                        _this.showError(error.response);
                        console.log("Error code: " + error.response.status);
                        console.log(error.response.headers);
                    } else if (error.request) {
                        console.log(error.request);
                    } else {
                        console.log("Error", error.message);
                    }
                    console.log(error.config);
                });
        },

        removeErrorTitle() {
            const errorTitle = document.querySelector(".no-link");
            if (errorTitle) {
                errorTitle.remove();
            }
        },

        showError(response) {
            this.link = "";
            this.error = response.data.message;

            if (
                response.status === 406 ||
                response.data.message === "Validation error"
            ) {
                this.errorDescription = response.data.data.url;
            }

            console.log(this.errorDescription);
        },
    },
};
</script>
