<template>
    <div class="donation-box">
        <h5 class="font-lora text-center">
            <strong>{{ title }}</strong>
        </h5>
        <h1 class="font-montserrat text-center total" ref="total">
            ${{ total | addComma }}
        </h1>
        <h4 class="font-montserrat text-center">
            of ${{ targetInWords }} raised
        </h4>
        <br />
        <div class="progress-bar">
            <div class="progress" :style="{ width: progressWidth }"></div>
        </div>
        <br />
        <div class="row justify-content-center">
            <div class="col-md-3">
                <div
                    class="input-group mb-3"
                    :class="{
                        'has-error': hasError('donated'),
                    }"
                >
                    <span class="input-group-text">$</span>
                    <input
                        type="text"
                        class="form-control"
                        placeholder="10,000.00"
                        aria-label="donated"
                        aria-describedby="donated"
                        v-model="donated"
                    />
                </div>
            </div>
        </div>
        <p class="text-center description">{{ description }}</p>
        <br />
        <h5 class="font-lora fw-bold">Select payment method</h5>
        <hr class="mt-3 row opacity-5" />
        <div class="form-check form-check-inline">
            <input
                class="form-check-input"
                type="radio"
                name="payment_method"
                value="paypal"
                id="paypal"
                v-model="paymentMethod"
            />
            <label class="form-check-label fw-bolder" for="paypal">
                Paypal
            </label>
        </div>
        <div class="form-check form-check-inline">
            <input
                class="form-check-input"
                type="radio"
                name="payment_method"
                value="offline"
                id="offline"
                v-model="paymentMethod"
            />
            <label class="form-check-label fw-bolder" for="offline">
                Offline donation
            </label>
        </div>
        <br />
        <br />
        <h5 class="font-lora fw-bold">Personal info</h5>
        <hr class="mt-3 row opacity-5" />
        <div class="row">
            <div class="col-md-6">
                <input
                    type="text"
                    class="form-control mb-3"
                    placeholder="First name*"
                    v-model="firstName"
                    :class="{
                        'has-error': hasError('first_name'),
                    }"
                />
            </div>
            <div class="col-md-6">
                <input
                    type="text"
                    class="form-control mb-3"
                    placeholder="Last name*"
                    v-model="lastName"
                    :class="{
                        'has-error': hasError('last_name'),
                    }"
                />
            </div>
            <div class="col-md-6">
                <input
                    type="text"
                    class="form-control mb-3"
                    placeholder="Email*"
                    v-model="email"
                    :class="{
                        'has-error': hasError('email'),
                    }"
                />
            </div>
            <div class="col-md-6">
                <input
                    type="text"
                    class="form-control mb-3"
                    placeholder="Phone*"
                    v-model="phone"
                    :class="{
                        'has-error': hasError('phone'),
                    }"
                />
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div
                    class="input-group mb-4 mt-2"
                    :class="{
                        'has-error': hasError('donated'),
                    }"
                >
                    <span class="input-group-text"> Donation total: </span>
                    <input
                        type="text"
                        class="form-control"
                        placeholder="10,000.00"
                        aria-label="donated"
                        aria-describedby="donated"
                        v-model="donated"
                    />
                </div>
            </div>
        </div>
        <p class="text-success" v-if="success !== null">{{ success }}</p>
        <p class="text-center">
            <button
                type="button"
                class="btn btn-primary btn-lg fs-6 text-uppercase"
                @click="handleSubmitDonation"
            >
                Donate Now
            </button>
        </p>
    </div>
</template>

<script>
import Vue from "vue";
import anime from "animejs";
import axios from "axios";

export default {
    name: "donation-box",
    props: ["title", "description"],
    data() {
        let { target, payment_method, first_name, last_name, email, phone } =
            this.$attrs;

        return {
            paymentMethodOptions: [
                { text: "Paypal", value: "paypal" },
                { text: "Offline donation", value: "offline" },
            ],
            total: 0,
            target: parseInt(target),
            donated: 0,
            paymentMethod: payment_method,
            firstName: first_name,
            lastName: last_name,
            email,
            phone,
            success: null,
            errors: null,
        };
    },
    watch: {
        donated(newValue) {
            const result = newValue
                .replace(/\D/g, "")
                .replace(/\B(?=(\d{3})+(?!\d))/g, ",");

            Vue.nextTick(() => (this.donated = result));
        },
    },
    computed: {
        progressWidth() {
            let width = (this.total / this.target) * 100;

            return width <= 100 ? `${width}%` : "100%";
        },
        targetInWords() {
            return this.target.toLocaleString().replace(",000,000", " million");
        },
    },
    mounted() {
        setTimeout(() => {
            this.calculateTotal(parseInt(this.$attrs.total), this.total);
        }, 1000);
    },
    methods: {
        hasError(field) {
            return this.errors !== null && this.errors.hasOwnProperty(field);
        },
        reset() {
            this.firstName = "";
            this.lastName = "";
            this.email = "";
            this.phone = "";
            this.donated = 0;
            this.payment_method = "paypal";
        },
        async handleSubmitDonation() {
            var donated = 0;

            if (parseInt(this.donated) !== 0) {
                donated = parseInt(this.donated.replace(/\D/g, ""));
            }

            this.errors = null;

            await axios
                .post("wp-json/donation/submit", {
                    first_name: this.firstName,
                    last_name: this.lastName,
                    email: this.email,
                    phone: this.phone,
                    donated,
                    payment_method: this.paymentMethod,
                })
                .then((response) => {
                    this.calculateTotal(this.total + donated, this.total);
                    this.success = response.data.message;
                    this.reset();
                })
                .catch(({ response }) => {
                    if (typeof response !== "undefined") {
                        console.log(response);
                        this.errors = response.data.data.params;
                    }
                });
        },
        calculateTotal(newValue, oldValue) {
            const obj = { total: oldValue };

            anime({
                targets: obj,
                total: newValue,
                round: 1,
                duration: 2000,
                easing: "linear",
                update: () => {
                    this.total = obj.total;
                },
            });
        },
    },
    filters: {
        addComma(value) {
            return value.toLocaleString();
        },
    },
};
</script>

<style lang="scss" scoped>
@import "./../scss/_variables.scss";

.donation-box {
    background-color: white;
    border-radius: 15px;
    box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
    padding: 50px 90px;
    font-family: "montserrat";
    margin-bottom: 80px !important;
    hr {
        margin-right: calc(var(--bs-gutter-x) * -0.9);
        margin-left: calc(var(--bs-gutter-x) * -0.9);
    }
    .total {
        color: $primary;
        font-weight: 700;
    }
    .description {
        font-size: 14px;
        max-width: 500px;
        margin: auto;
        color: #888;
    }
    .input-group-text {
        border: var(--form--border-width) solid var(--form--border-color);
        border-radius: 0;
    }
    .progress-bar {
        background-color: #f1f1f1;
        height: 20px;
        text-align: left;
        display: block;
        width: 100%;
        .progress {
            background-color: $primary;
            height: inherit;
            border-radius: 0;
        }
    }
    .has-error {
        border-color: red;
        input {
            border-color: red;
        }
    }
}

@media only screen and (max-width: 520px) {
    .donation-box {
        padding: 30px 40px;
        margin: 0 10px;
        margin-bottom: 40px !important;
    }
}
</style>