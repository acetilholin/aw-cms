<template>
    <div class="contact-form">
        <h3 class="h3-contact">Contact</h3>
        <div>
            <div class="col-md-8 mb-2 form-group">
                <label for="name-surname">Name and surname</label>
                <input type="text"
                       class="form-control"
                       id="name-surname"
                       v-bind:class="{ 'is-invalid': nameSurnameValid }"
                       name="fullname"
                       aria-describedby="emailHelp"
                       placeholder="Name and surname"
                       v-model="fullname"
                >
                <div class="invalid-feedback">
                    Enter name and surname
                </div>
                <div v-if="!$v.fullname.minLength">
                    <span class="is-invalid">Minimal lenght is {{ $v.fullname.$params.minLength.min }} characters</span>
                </div>
            </div>
            <div class="col-md-8 mb-2 form-group">
                <label for="email-label">Email</label>
                <input type="email"
                       class="form-control"
                       id="email-label"
                       v-bind:class="{ 'is-invalid': emailValid }"
                       name="email"
                       aria-describedby="emailHelp"
                       placeholder="Email"
                       v-model="email"
                >
                <div class="invalid-feedback">
                    Enter email
                </div>
                <div v-if="!$v.email.email">
                    <span class="is-invalid">Email not valid</span>
                </div>
            </div>
            <div class="col-md-8 mb-2 form-group">
                <label for="textarea">Message</label>
                <textarea class="form-control"
                          id="textarea"
                          v-bind:class="{ 'is-invalid': messageValid }"
                          name="message"
                          rows="3"
                          placeholder="Message"
                          v-model="message"
                ></textarea>
                <div class="invalid-feedback">
                    Enter message
                </div>
                <div v-if="!$v.message.minLength">
                    <span class="is-invalid">{{ $v.message.$params.minLength.min - message.length }} more characters</span>
                </div>
            </div>
            <VueLoadingButton class="btn btn-calculate"
                              aria-label='Send message'
                              @click.native="sendEmail"
                              :loading="isLoading"
                              :disabled="$v.fullname.$invalid || !$v.email.email || !$v.email.required || $v.message.$invalid"
            >{{ buttonText }}
            </VueLoadingButton>
        </div>
    </div>
</template>

<script>
    import {email, minLength, required} from "vuelidate/lib/validators";
    import VueLoadingButton from "vue-loading-button";

    export default {
        name: "EnContact",
        data() {
            return {
                message: '', email: '', fullname: '',
                nameSurnameValid: '', emailValid: '', messageValid: '',
                responseMessage: '',
                isLoading: false,
                buttonText: 'Send'
            }
        },
        components: {
            VueLoadingButton
        },
        validations: {
            fullname: {
                required,
                minLength: minLength(5)
            },
            email: {
                required,
                email: email
            },
            message: {
                required,
                minLength: minLength(30)
            }
        },
        methods: {
            sendEmail: function () {

                this.nameSurnameValid = this.fullname === '';
                this.emailValid = this.email === '';
                this.messageValid = this.message === '';

                if (this.fullname !== '' && this.email !== '' && this.message !== '') {
                    this.isLoading = true;
                    axios.get('/contact-en', {
                        params: {
                            email: this.email,
                            fullname: this.fullname,
                            message: this.message
                        }
                    })
                        .then(response => {
                                this.isLoading = response.data.loading
                                setTimeout(() => {
                                    this.buttonText =  response.data.resp
                                }, 500)
                            })

                }
            }
        }
    }
</script>
<style>
    .is-invalid {
        width: 100%;
        margin-top: .25rem;
        font-size: 80%;
        color: #dc3545;
    }

    button:disabled {
        cursor: not-allowed;
        pointer-events: all !important;
    }
</style>

