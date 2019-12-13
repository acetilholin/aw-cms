<template>
    <div class="contact-form">
        <h3 class="h3-contact">Contact</h3>
        <div>
            <div class="col-md-8 mb-2 form-group">
                <label for="name-surname">Name and surname</label>
                <input type="text" class="form-control" id="name-surname"  v-bind:class="{ 'is-invalid': nameSurnameValid }" name="fullname" aria-describedby="emailHelp" placeholder="Name and surname" v-model="fullname" required>
                <div class="invalid-feedback">
                    Enter name and surname
                </div>
                <div v-if="!$v.fullname.minLength" >
                    <span class="is-invalid">Minimal lenght is {{ $v.fullname.$params.minLength.min }} characters</span>
                </div>
            </div>
            <div class="col-md-8 mb-2 form-group">
                <label for="email-label">Email</label>
                <input type="email" class="form-control" id="email-label" v-bind:class="{ 'is-invalid': emailValid }" name="email" aria-describedby="emailHelp" placeholder="Email" v-model="email" required>
                <div class="invalid-feedback">
                    Enter email
                </div>
                <div v-if="!$v.email.email">
                    <span class="is-invalid">Email not valid</span>
                </div>
            </div>
            <div class="col-md-8 mb-2 form-group">
                <label for="textarea">Message</label>
                <textarea class="form-control" id="textarea" v-bind:class="{ 'is-invalid': messageValid }" name="message" rows="3" placeholder="Message" v-model="message" required></textarea>
                <div class="invalid-feedback">
                    Enter message
                </div>
                <div v-if="!$v.message.minLength" >
                    <span class="is-invalid">{{ $v.message.$params.minLength.min - message.length }} more characters</span>
                </div>
            </div>
            <div class="col-md-8 mb-2 form-group" v-if="responseMessage">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ responseMessage }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <button class="btn btn-calculate" @click="sendEmail()" :disabled="$v.fullname.$invalid || !$v.email.email || $v.message.$invalid">Send</button>
        </div>
    </div>
</template>

<script>
    import {email, minLength} from "vuelidate/lib/validators";

    export default {
        name: "EnContact",
        data() {
            return {
                message: '', email: '', fullname: '',
                nameSurnameValid: '', emailValid: '', messageValid: '',
                responseMessage: ''
            }
        },
        validations: {
            fullname: {
                minLength: minLength(5)
            },
            email: {
                email:email
            },
            message: {
                minLength: minLength(30)
            }
        },
        methods: {
            sendEmail: function () {

                this.nameSurnameValid = this.fullname === '';
                this.emailValid = this.email === '';
                this.messageValid = this.message === '';

                if (this.fullname !== '' && this.email !== '' && this.message !== '') {
                    axios.get('/contact-en', {
                        params: {
                            email: this.email,
                            fullname: this.fullname,
                            message: this.message
                        }
                    })
                        .then(response => this.responseMessage = response.data.resp)

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
</style>

