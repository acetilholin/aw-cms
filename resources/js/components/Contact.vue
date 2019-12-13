<template>
    <div class="contact-form">
        <h3 class="h3-contact">Kontakt</h3>
        <div>
            <div class="col-md-8 mb-2 form-group">
                <label for="name-surname">Ime in priimek</label>
                <input type="text" class="form-control" id="name-surname"
                       v-bind:class="{ 'is-invalid': nameSurnameValid }" name="fullname" aria-describedby="emailHelp" placeholder="Ime in priimek" v-model="fullname" @input="$v.fullname.$touch" required>
                <div class="invalid-feedback">
                    Vpišite ime in priimek
                </div>
                <div v-if="!$v.fullname.minLength" >
                    <span class="is-invalid">Minimalna dolžina je {{ $v.fullname.$params.minLength.min }} znakov</span>
                </div>
            </div>
            <div class="col-md-8 mb-2 form-group">
                <label for="email-label">Email</label>
                <input type="text" class="form-control" id="email-label" v-bind:class="{ 'is-invalid': emailValid }" name="email" aria-describedby="emailHelp" placeholder="Email" v-model="email" required>
                <div class="invalid-feedback">
                    Vpišite email naslov
                </div>
                <div v-if="!$v.email.email">
                   <span class="is-invalid">Email ni veljaven</span>
                </div>
            </div>
            <div class="col-md-8 mb-2 form-group">
                <label for="textarea">Sporočilo</label>
                <textarea class="form-control" id="textarea" v-bind:class="{ 'is-invalid': messageValid }" name="message" rows="3" placeholder="Sporočilo" v-model="message" @input="$v.fullname.$touch" required></textarea>
                <div class="invalid-feedback">
                    Vpišite sporočilo
                </div>
                <div v-if="!$v.message.minLength" >
                    <span class="is-invalid">Še {{ $v.message.$params.minLength.min - message.length }} znakov</span>
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
            <button class="btn btn-calculate" @click="sendEmail" :disabled="$v.fullname.$invalid || !$v.email.email || $v.message.$invalid">Pošlji</button>
        </div>
    </div>
</template>

<script>

    import { required, maxLength, minLength, email } from 'vuelidate/lib/validators'

    export default {
        name: "Contact",
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
                    axios.get('/contact', {
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

