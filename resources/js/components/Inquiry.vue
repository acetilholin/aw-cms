<template>
    <div class="inquiry-form">
        <h3 class="h3-contact">Povpraševanje</h3>
        <p>
            <button class="btn btn-red"
                    style="margin-left: 0 !important"
                    data-toggle="modal"
                    data-target="#inquiry"
            >Obrazec
            </button>
        </p>
        <!-- Modal -->
        <div class="modal fade"
             id="inquiry"
             tabindex="-1"
             role="dialog"
             aria-labelledby="exampleModalLabel"
             aria-hidden="true"
        >
            <div class="modal-dialog modal-lg"
                 role="document"
            >
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="text-red">Osnovni podatki</div>
                        <hr>
                        <div class="form-row">
                            <div class="col-md-6 form-group">
                                <label for="znamka">Znamka in model</label>
                                <input type="text"
                                       class="form-control"
                                       id="znamka"
                                       v-bind:class="{ 'is-invalid': znamkaValid }"
                                       v-model="znamka"
                                       aria-describedby="emailHelp"
                                       placeholder="Znamka in model"
                                >
                                <div class="invalid-feedback">
                                    Vpišite znamko in model
                                </div>
                                <div v-if="!$v.znamka.minLength">
                                    <span class="is-invalid">Minimalna dolžina je {{ $v.znamka.$params.minLength.min }} znakov</span>
                                </div>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="oprema">Tip opreme</label>
                                <input type="text"
                                       class="form-control"
                                       id="oprema"
                                       v-model="oprema"
                                       aria-describedby="emailHelp"
                                       placeholder="Tip opreme (S-line, R-line....)"
                                >
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-3 form-group">
                                <label for="sedezi">Sedeži</label>
                                <select class="custom-select"
                                        id="sedezi"
                                        title="sedezi"
                                        v-model="sedezi"
                                >
                                    <option value=""
                                            selected
                                            disabled
                                            hidden
                                    >Izberi
                                    </option>
                                    <option value="2">2</option>
                                    <option value="5">5</option>
                                    <option value="7">7</option>
                                </select>
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="vrata">Vrata</label>
                                <select class="custom-select"
                                        id="vrata"
                                        title="vrata"
                                        v-model="vrata"
                                >
                                    <option value=""
                                            selected
                                            disabled
                                            hidden
                                    >Izberi
                                    </option>
                                    <option value="3">3</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="karoserija">Karoserija</label>
                                <select class="custom-select"
                                        id="karoserija"
                                        title="Karoserija"
                                        v-model="karoserija"
                                >
                                    <option value=""
                                            selected
                                            disabled
                                            hidden
                                    >Izberi
                                    </option>
                                    <option value="0">Limuzina</option>
                                    <option value="1">Kombi limuzina</option>
                                    <option value="2">Karavan</option>
                                    <option value="3">Enoprostorec</option>
                                    <option value="4">Coupe</option>
                                    <option value="5">Cabrio</option>
                                    <option value="6">SUV / Terenski</option>
                                    <option value="7">Pick-up</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-3 form-group">
                                <label for="starostMin">Letnik min.</label>
                                <select class="custom-select"
                                        id="starostMin"
                                        v-bind:class="{ 'is-invalid': letnikMinValid }"
                                        title="starostMin"
                                        v-model="letaMin"
                                >
                                    <option value=""
                                            selected
                                            disabled
                                            hidden
                                    >Izberi
                                    </option>
                                    <option value="2013">od 2013</option>
                                    <option value="2014">od 2014</option>
                                    <option value="2015">od 2015</option>
                                    <option value="2016">od 2016</option>
                                    <option value="2017">od 2017</option>
                                    <option value="2018">od 2018</option>
                                    <option value="2019">od 2019</option>
                                </select>
                                <div class="invalid-feedback">
                                    Izberite letnik min.
                                </div>
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="starostMax">Letnik max.</label>
                                <select class="custom-select"
                                        id="starostMax"
                                        title="starostMax"
                                        v-bind:class="{ 'is-invalid': letnikMaxValid }"
                                        v-model="letaMax"
                                >
                                    <option value=""
                                            selected
                                            disabled
                                            hidden
                                    >Izberi
                                    </option>
                                    <option value="2013">do 2013</option>
                                    <option value="2014">do 2014</option>
                                    <option value="2015">do 2015</option>
                                    <option value="2016">do 2016</option>
                                    <option value="2017">do 2017</option>
                                    <option value="2018">do 2018</option>
                                    <option value="2019">do 2019</option>
                                </select>
                                <div class="invalid-feedback">
                                    Izberite letnik max.
                                </div>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="kilometri">Kilometri</label>
                                <select class="custom-select"
                                        id="kilometri"
                                        v-bind:class="{ 'is-invalid': kilometriValid }"
                                        title="kilometri"
                                        v-model="kilometri"
                                >
                                    <option value=""
                                            selected
                                            disabled
                                            hidden
                                    >Izberi
                                    </option>
                                    <option value="0">do 50.000</option>
                                    <option value="1">od 50.000 do 100.000</option>
                                    <option value="2">od 100.000 do 125.000</option>
                                    <option value="3">od 125.000 do 150.000</option>
                                    <option value="4">od 150.000 do 175.000</option>
                                </select>
                                <div class="invalid-feedback">
                                    Izberite kilometre
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-3 form-group">
                                <label for="barva">Barva</label>
                                <select class="custom-select"
                                        id="barva"
                                        title="barva"
                                        v-model="barva"
                                >
                                    <option value=""
                                            selected
                                            disabled
                                            hidden
                                    >Izberi
                                    </option>
                                    <option value="0">Katerakoli</option>
                                    <option value="1">Bela</option>
                                    <option value="2">Črna</option>
                                    <option value="3">Srebrna</option>
                                    <option value="4">Modra</option>
                                    <option value="5">Siva</option>
                                    <option value="6">Rumena</option>
                                    <option value="7">Rdeča</option>
                                    <option value="8">Zelena</option>
                                </select>
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="moc">Moč motorja</label>
                                <select class="custom-select"
                                        id="moc"
                                        title="moc"
                                        v-model="moc"
                                >
                                    <option value=""
                                            selected
                                            disabled
                                            hidden
                                    >Izberi
                                    </option>
                                    <option value="0">do 100KM</option>
                                    <option value="1">od 100 do 130KM</option>
                                    <option value="2">od 130 do 150KM</option>
                                    <option value="3">od 150 do 200KM</option>
                                </select>
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="menjalnik">Menjalnik</label>
                                <select class="custom-select"
                                        id="menjalnik"
                                        title="menjalnik"
                                        v-model="menjalnik"
                                >
                                    <option value=""
                                            selected
                                            disabled
                                            hidden
                                    >Izberi
                                    </option>
                                    <option value="0">Ročni</option>
                                    <option value="1">Avtomatski</option>
                                </select>
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="gorivo">Gorivo</label>
                                <select class="custom-select"
                                        id="gorivo"
                                        title="gorivo"
                                        v-model="gorivo"
                                >
                                    <option value=""
                                            selected
                                            disabled
                                            hidden
                                    >Izberi
                                    </option>
                                    <option value="0">Benzin</option>
                                    <option value="1">Dizel</option>
                                    <option value="2">Hibrid</option>
                                    <option value="3">Električni</option>
                                </select>
                            </div>
                            <div class="text-red">Dodatne opcije</div>
                        </div>
                        <hr>
                        <div class="form-row">
                            <div class="col-md-4">
                                <div class="text-gray">Notranja oprema</div>
                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           id="notranja1"
                                           v-model="notranja1"
                                    >
                                    <label class="form-check-label"
                                           for="notranja1"
                                    >
                                        Gretje sedežev
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           id="notranja2"
                                           v-model="notranja2"
                                    >
                                    <label class="form-check-label"
                                           for="notranja2"
                                    >
                                        Hlajenje/ventilacija sedežev
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           value=""
                                           id="notranja3"
                                           v-model="notranja3"
                                    >
                                    <label class="form-check-label"
                                           for="notranja3"
                                    >
                                        El. nastavitev sedežev
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           value=""
                                           id="notranja4"
                                           v-model="notranja4"
                                    >
                                    <label class="form-check-label"
                                           for="notranja4"
                                    >
                                        Usnjeni sedeži
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           value=""
                                           id="notranja5"
                                           v-model="notranja5"
                                    >
                                    <label class="form-check-label"
                                           for="notranja5"
                                    >
                                        Sončna streha
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           value=""
                                           id="notranja6"
                                           v-model="notranja6"
                                    >
                                    <label class="form-check-label"
                                           for="notranja6"
                                    >
                                        Navigacija
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           value=""
                                           id="notranja7"
                                           v-model="notranja7"
                                    >
                                    <label class="form-check-label"
                                           for="notranja7"
                                    >
                                        Head Up display
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-gray">Varnost</div>
                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           value=""
                                           id="varnost1"
                                           v-model="varnost1"
                                    >
                                    <label class="form-check-label"
                                           for="varnost1"
                                    >
                                        Tempomat
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           value=""
                                           id="varnost2"
                                           v-model="varnost2"
                                    >
                                    <label class="form-check-label"
                                           for="varnost2"
                                    >
                                        Aktivni tempomat
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           value=""
                                           id="varnost3"
                                           v-model="varnost3"
                                    >
                                    <label class="form-check-label"
                                           for="varnost3"
                                    >
                                        Xenon žarometi
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           value=""
                                           id="varnost4"
                                           v-model="varnost4"
                                    >
                                    <label class="form-check-label"
                                           for="varnost4"
                                    >
                                        LED žarometi
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           value=""
                                           id="varnost5"
                                           v-model="varnost5"
                                    >
                                    <label class="form-check-label"
                                           for="varnost5"
                                    >
                                        Avtom. ohranjanje voz.pasu
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           value=""
                                           id="varnost6"
                                           v-model="varnost6"
                                    >
                                    <label class="form-check-label"
                                           for="varnost6"
                                    >
                                        Samodejno zaviranje v sili
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-gray">Pomoč pri parkiranju</div>
                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           value=""
                                           id="pomoc1"
                                           v-model="pomoc1"
                                    >
                                    <label class="form-check-label"
                                           for="pomoc1"
                                    >
                                        Parkirni asistent
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           value=""
                                           id="pomoc2"
                                           v-model="pomoc2"
                                    >
                                    <label class="form-check-label"
                                           for="pomoc2"
                                    >
                                        Parkirna kamera
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           value=""
                                           id="pomoc3"
                                           v-model="pomoc3"
                                    >
                                    <label class="form-check-label"
                                           for="pomoc3"
                                    >
                                        Parkirni senzorji
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-4">
                                <div class="text-gray">Klimatizacija</div>
                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           value=""
                                           id="klima1"
                                           v-model="klima1"
                                    >
                                    <label class="form-check-label"
                                           for="klima1"
                                    >
                                        Avtomatska klima
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           value=""
                                           id="klima2"
                                           v-model="klima2"
                                    >
                                    <label class="form-check-label"
                                           for="klima2"
                                    >
                                        Gretje mirujočega vozila
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-gray">Ostalo</div>
                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           value=""
                                           id="ostalo1"
                                           v-model="ostalo1"
                                    >
                                    <label class="form-check-label"
                                           for="ostalo1"
                                    >
                                        Pogon 4x4
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           value=""
                                           id="ostalo2"
                                           v-model="ostalo2"
                                    >
                                    <label class="form-check-label"
                                           for="ostalo2"
                                    >
                                        Vlečna naprava
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4"></div>
                            <div class="text-red">Pričakovana cena</div>
                        </div>
                        <hr>
                        <div class="form-row">
                            <div class="col-md-9 form-group">
                                <label for="cena">Max. pričakovana cena <span class="small">(z DMV, DDV in ostalimi dajatvami v SLO)</span></label>
                                <input type="text"
                                       class="form-control col-md-7"
                                       v-bind:class="{ 'is-invalid': cenaValid }"
                                       id="cena"
                                       name="cena"
                                       aria-describedby="emailHelp"
                                       placeholder="Pričakovana cena v €"
                                       v-model="cena"
                                >
                                <div class="invalid-feedback">
                                    Vpišite ceno
                                </div>
                                <div v-if="!$v.cena.minLength">
                                    <span class="is-invalid">Minimalna dolžina je {{ $v.cena.$params.minLength.min }} znakov</span>
                                </div>
                            </div>
                            <div class="col-md-3"></div>
                            <div class="text-red">Osebni podatki</div>
                        </div>
                        <hr>
                        <div class="form-row">
                            <div class="col-md-4 form-group">
                                <label for="imepriimek">Ime in priimek</label>
                                <input type="text"
                                       class="form-control"
                                       id="imepriimek"
                                       v-bind:class="{ 'is-invalid': imePriimekValid }"
                                       @input="$v.imePriimek.$touch"
                                       name="imepriimek"
                                       aria-describedby="emailHelp"
                                       placeholder="Ime in priimek"
                                       v-model="imePriimek"
                                >
                                <div class="invalid-feedback">
                                    Vpišite ime in priimek
                                </div>
                                <div v-if="!$v.imePriimek.minLength">
                                    <span class="is-invalid">Minimalna dolžina je {{ $v.imePriimek.$params.minLength.min }} znakov</span>
                                </div>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="email">Email</label>
                                <input type="email"
                                       class="form-control"
                                       id="email"
                                       v-bind:class="{ 'is-invalid': emailValid }"
                                       name="imepriimek"
                                       aria-describedby="emailHelp"
                                       placeholder="Email"
                                       v-model="email"
                                >
                                <div class="invalid-feedback">
                                    Vpišite email naslov
                                </div>
                                <div v-if="!$v.email.email">
                                    <span class="is-invalid">Email ni veljaven</span>
                                </div>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="telefon">Telefon</label>
                                <input type="text"
                                       class="form-control"
                                       id="telefon"
                                       name="imepriimek"
                                       aria-describedby="emailHelp"
                                       placeholder="Telefon"
                                       v-model="telefon"
                                >
                            </div>
                        </div>
                    </div>
                    <div class="small text-center text-red"
                         v-if="helpText"
                    >
                        Polja znamka, letnik min. letnik max., kilometri, pričakovana cena ter vaši podatki (brez
                        telefona) so obvezna.
                    </div>
                    <div class="modal-footer">
                        <button type="button"
                                class="btn btn-gray btn-mobile-close"
                                data-dismiss="modal"
                        >Zapri
                        </button>
                        <VueLoadingButton class="btn btn-red"
                                          aria-label='Send message'
                                          @click.native="sendInquiry"
                                          :loading="isLoading"
                                          :disabled="$v.imePriimek.$invalid || !$v.email.email || letaMin === '' || letaMax ==='' || $v.znamka.$invalid || kilometri ===''"
                        >{{ buttonText }}
                        </VueLoadingButton>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import {required, maxLength, minLength, email} from 'vuelidate/lib/validators'
    import VueLoadingButton from "vue-loading-button"

    export default {
        name: "Inquiry",
        data() {
            return {
                imePriimekValid: '',
                emailValid: '',
                cenaValid: '',
                znamkaValid: '',
                kilometriValid: '',
                letnikMinValid: '',
                letnikMaxValid: '',
                znamka: '',
                oprema: '',
                sedezi: '',
                vrata: '',
                karoserija: '',
                letaMin: '',
                letaMax: '',
                kilometri: '',
                barva: '',
                moc: '',
                menjalnik: '',
                gorivo: '',
                imePriimek: '',
                email: '',
                telefon: '',
                cena: '',
                notranja1: false,
                notranja2: false,
                notranja3: false,
                notranja4: false,
                notranja5: false,
                notranja6: false,
                notranja7: false,
                varnost1: false,
                varnost2: false,
                varnost3: false,
                varnost4: false,
                varnost5: false,
                varnost6: false,
                pomoc1: false,
                pomoc2: false,
                pomoc3: false,
                klima1: false,
                klima2: false,
                ostalo1: false,
                ostalo2: false,
                karoserijaOpcije: ['Limuzina', 'Kombi limuzina', 'Karavan', 'Enoprostorec', 'Coupe', 'Cabrio', 'SUV / Terenski', 'Pick-up'],
                kilometriOpcije: ['do 50.000', 'od 50.000 do 100.000', 'od 100.000 do 125.000', 'od 125.000 do 150.000', 'od 150.000 do 175.000'],
                barveOpcije: ['Katerakoli', 'Bela', 'Črna', 'Srebrna', 'Modra', 'Siva', 'Rumena', 'Rdeča', 'Zelena'],
                mocOpcije: ['do 100KM', 'od 100 do 130KM', 'od 130 do 150KM', 'od 150 do 200KM'],
                menjalnikOpcije: ['ročni', 'avtomatski'],
                gorivoOpcije: ['Benzin', 'Dizel', 'Hibridni', 'Električni'],
                helpText: true,
                isLoading: false,
                buttonText: 'Pošlji'
            }
        },
        components: {
          VueLoadingButton
        },
        validations: {
            imePriimek: {
                minLength: minLength(7)
            },
            znamka: {
                minLength: minLength(5)
            },
            email: {
                email: email
            },
            cena: {
                minLength: minLength(4)
            }
        },
        methods: {
            sendInquiry() {

                this.imePriimekValid = this.imePriimek === '';
                this.emailValid = this.email === '';
                this.cenaValid = this.cena === '';
                this.znamkaValid = this.znamka === '';
                this.kilometriValid = this.kilometri === '';
                this.letnikMinValid = this.letaMin === '';
                this.letnikMaxValid = this.letaMax === '';

                if (this.znamka !== '' && this.letaMin !== '' && this.letaMax !== '' && this.kilometri !== '' && this.cena !== '' && this.imePriimek !== '' && this.email !== '') {
                    this.isLoading = true;
                    this.helpText = false;
                    axios.get('/inquiry', {
                        params: {
                            znamka: this.znamka,
                            oprema: this.oprema,
                            sedezi: this.sedezi,
                            vrata: this.vrata,
                            karoserija: this.karoserijaOpcije[this.karoserija],
                            letaMin: this.letaMin,
                            letaMax: this.letaMax,
                            kilometri: this.kilometriOpcije[this.kilometri],
                            barva: this.barveOpcije[this.barva],
                            moc: this.mocOpcije[this.moc],
                            menjalnik: this.menjalnikOpcije[this.menjalnik],
                            gorivo: this.gorivoOpcije[this.gorivo],
                            cena: this.cena,
                            imePriimek: this.imePriimek,
                            email: this.email,
                            telefon: this.telefon,
                            notranja1: this.notranja1,
                            notranja2: this.notranja2,
                            notranja3: this.notranja3,
                            notranja4: this.notranja4,
                            notranja5: this.notranja5,
                            notranja6: this.notranja6,
                            notranja7: this.notranja7,
                            varnost1: this.varnost1,
                            varnost2: this.varnost2,
                            varnost3: this.varnost3,
                            varnost4: this.varnost4,
                            varnost5: this.varnost5,
                            varnost6: this.varnost6,
                            pomoc1: this.pomoc1,
                            pomoc2: this.pomoc2,
                            pomoc3: this.pomoc3,
                            klima1: this.klima1,
                            klima2: this.klima2,
                            ostalo1: this.ostalo1,
                            ostalo2: this.ostalo2
                        }
                    })
                        .then(
                            response => {
                                this.isLoading = response.data.loading
                                setTimeout(() => {
                                    this.buttonText =  response.data.resp
                                }, 500)
                            }
                        )
                }
            }
        }
    }
</script>

<style scoped>
    button:disabled {
        cursor: not-allowed;
        pointer-events: all !important;
    }
    .btn-gray {
        border-width: 0 !important;
    }
</style>
