<template>
    <div class="contact-form">
        <h3 class="h3-contact">Kontakt</h3>
        <div>
            <div class="col-md-8 mb-2 form-group">
                <label for="name-surname">Ime in priimek</label>
                <input type="text" class="form-control" id="name-surname"
                       v-bind:class="{ 'is-invalid': nameSurnameValid }" name="fullname" aria-describedby="emailHelp"
                       placeholder="Ime in priimek" v-model="fullname" required>
                <div class="invalid-feedback">
                    Vpišite ime in priimek
                </div>
            </div>
            <div class="col-md-8 mb-2 form-group">
                <label for="email-label">Email</label>
                <input type="text" class="form-control" id="email-label" v-bind:class="{ 'is-invalid': emailValid }"
                       name="email" aria-describedby="emailHelp" placeholder="Email" v-model="email" required>
                <div class="invalid-feedback">
                    Vpišite email naslov
                </div>
            </div>
            <div class="col-md-8 mb-2 form-group">
                <label for="textarea">Sporočilo</label>
                <textarea class="form-control" id="textarea" v-bind:class="{ 'is-invalid': messageValid }"
                          name="message" rows="3" placeholder="Sporočilo" v-model="message" required></textarea>
                <div class="invalid-feedback">
                    Vpišite sporočilo
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
            <button class="btn btn-calculate" @click="sendEmail">Pošlji</button>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Contact",
        data() {
            return {
                message: '', email: '', fullname: '',
                nameSurnameValid: '', emailValid: '', messageValid: '',
                responseMessage: ''
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

