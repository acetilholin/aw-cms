<template>
    <div class="row">
        <div class="col-md-6">
            <div class="row">
                <label for="price" class="col-sm-3 align-self-center">Cena vozila</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" v-bind:class="{ 'is-invalid': carPrice }" id="price" v-model="price" aria-describedby="emailHelp" title="vpišite ceno vozila v evrih" placeholder="Davčna osnova" required>
                    <div class="invalid-feedback">
                        Vpišite ceno vozila
                    </div>
                </div>
            </div>
            <fieldset class="row">
                <div class="row">
                    <legend class="col-form-label col-sm-3">Tip cene</legend>
                    <div class="col-sm-9">
                        <div class="custom-control custom-switch" id="test1">
                            <input type="checkbox" class="custom-control-input" id="grossnett" v-model="priceType">
                            <label class="custom-control-label" for="grossnett">
                                <span v-if="priceType" class="choosen">Bruto</span>
                                <span v-else class="choosen">Neto</span></label>
                        </div>
                    </div>
                </div>
            </fieldset>
            <div class="row">
                <div class="col-sm-3 align-self-center">Gorivo</div>
                <div class="col-sm-9">
                    <select class="custom-select" id="selectBox1" v-bind:class="{ 'is-invalid': carFuel }" v-model="fuel" title="izberite tip goriva" required>
                        <option value="dizel">Dizel</option>
                        <option value="elektrika">Elektrika</option>
                        <option value="ostalo">Benzin(+vse ostalo)</option>
                    </select>
                    <div class="invalid-feedback">
                        Izberite tip goriva
                    </div>
                </div>
            </div>
            <div class="row zero-margin">
                <div class="col-sm-3 align-self-center pad">Prostornina</div>
                <div class="col-sm-9">
                    <select class="custom-select" id="selectBox2" v-bind:class="{ 'is-invalid': carCCM }" v-model="ccm" title="izberite razred prostornine motorja" required>
                        <option value="1">do 2499</option>
                        <option value="2">od 2500 do 2999</option>
                        <option value="3">od 3000 do 3499</option>
                        <option value="4">od 3500 do 3999</option>
                        <option value="5">nad 4000</option>
                    </select>
                    <div class="invalid-feedback">
                        Izberite razred prostornine
                    </div>
                </div>
            </div>
            <fieldset>
                <div class="row">
                    <legend class="col-form-label col-sm-3">Trdi delci <i class="fas fa-info-circle" data-toggle="diesel-info" title="Emisija trdih delcev v g/km (samo za dizel)"></i></legend>
                    <div class="col-sm-9">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="trdidelci" v-model="dizelTrdiDelci">
                            <label class="custom-control-label" for="trdidelci">Izpust trdih delcev nad 0,005 g/km</label>
                        </div>
                    </div>
                </div>
            </fieldset>
            <div class="row">
                <div class="col-sm-3 align-self-center">EURO motor</div>
                <div class="col-sm-9">
                    <select class="custom-select" id="selectBox3" v-bind:class="{ 'is-invalid': carEURO }" v-model="euroEngine" title="izberite tip EURO standarda motorja" required>
                        <option value="euro1">EURO 1</option>
                        <option value="euro2">EURO 2</option>
                        <option value="euro3">EURO 3</option>
                        <option value="euro4">EURO 4</option>
                        <option value="euro5">EURO 5</option>
                        <option value="euro6">EURO 6</option>
                    </select>
                    <div class="invalid-feedback">
                        Izberite EURO standard motorja
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3 align-self-center">Emisije CO2</div>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="emission" aria-describedby="emailHelp" placeholder="0" v-bind:class="{ 'is-invalid': carCO2 }" v-model="co2" required>
                    <div class="invalid-feedback">
                        Vpišite emisije CO2
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3 align-self-center pad-2">Transport</div>
                <div class="col-sm-9">
                    <select class="custom-select" id="selectBox4" v-model="location" title="izberite približno lokacijo transporta" required>
                        <optgroup label="Nemčija" data-max-options="1">
                            <option value="0">München</option>
                            <option value="1">Frankfurt, Nürnberg, Saarbrucken</option>
                            <option value="2">Köln, Dortmund, Kassel</option>
                            <option value="3">Munster</option>
                            <option value="4">Leipzig</option>
                            <option value="5">Hannover</option>
                            <option value="6">Berlin, Hamburg, Bremen</option>
                            <option value="7">Flensburg</option>
                        </optgroup>
                        <optgroup label="Belgija" data-max-options="1">
                            <option value="8">Celotna država</option>
                        </optgroup>
                        <optgroup label="Nizozemska" data-max-options="1">
                            <option value="9" >Rotterdam + Amsterdam</option>
                            <option value="10">Groningen</option>
                            <option value="11">Ostale destinacie v NL</option>
                        </optgroup>
                    </select>
                </div>
            </div>
            <transition name="fade">
                <div class="alert alert-secondary" role="alert" v-show="show" style="animation-duration: 1s">
                    <h4 class="alert-heading">Izračun:</h4>
                    <p>
                        Stopnja DMV: {{ stopnjaDavka }}%<br>
                        Znesek DMV: {{ znesekDavka }}€<br>
                        Stopnja pribitka: {{ stopnjaPribitka }}%<br>
                        Znesek pribitka: {{ znesekPribitka }}€<br>
                        Strošek transporta: {{ transportCosts }}€ + DDV<br>
                        Homologacija: {{ homologacija }}€<br>
                    </p>
                    <hr>
                    <p class="mb-0">
                        Končni znesek vozila z davkom in transportom: <b>{{ skupajDavek }}€</b><br><br>
                        <span class="font-weight-light">Končna cena vključuje DMV, DDV, homologacijo, vse stroške uvoza in transporta<i class="fas fa-info-circle" data-toggle="transport-info" title="Izračun je informativen in velja v primeru plačila vozila po predračunu."></i></span>
                    </p>
                </div>
            </transition>
            <button class="btn btn-calculate" @click="calculate()">Izračunaj</button>
        </div>
        <div class="col-md-6">
            Davek na motorna vozila - DMV<br>
            <a class="modal-title" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                Preberi več...
            </a>
            <div id="collapseOne" class="collapse hide" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body">
                    <p>Osnova za davek je prodajna cena posameznega motornega vozila, ki ne vključuje tega davka in davka na
                        dodano vrednost. Kot prodajna cena se pri pridobitvi motornega vozila iz druge države članice Evropske
                        unije šteje nakupna cena.</p>
                    <p>Če motorno vozilo iz prejšnjega odstavka uporablja kateri koli drug pogon, vključno z električnim, ali
                        kombinacijo različnih pogonov (hibridno vozilo), se stopnja davka določi z upoštevanjem lestvice, ki velja
                        za vozila z bencinskim gorivom.</p>
                </div>
            </div>
            <p style="margin-top: 1.5rem">
                Kdaj izbrati <span class="text-red">neto</span> ceno?<br>
                <li>kupec je pravna oseba zavezanec za DDV</li>
                <li>kupec je fizična oseba, ki financira vozilo preko Banke / leasinga</li>
                <li>vozilo je mlajše od 6 mesecev</li>
                <li>vozilo ima prevoženih manj kot 6.000 km</li>
                <br><br>
                Kdaj izbrati <span class="text-red">bruto</span> ceno?<br>
                <li>kupec je fizična oseba, ki plačuje po predračunu</li>
            </p>
        </div>
    </div>
</template>

<script>
    export default {
       name: 'Calculation',
       data() {
           return {
               priceGross:0, priceNett: 0, provision: 590, otherExpenses: 130, homologacija: 102,
               price: 0, endPrice: 0,
               fuel: '',
               euroEngine: 0,
               co2: 0,
               show: false,
               emission:0, emissionPoints: 1,
               fuelPoints: 0,
               ccm: 0, ccmPoints: 0,
               location: 0, transportCosts: 0,
               dizelTrdiDelci: false, priceType: false,
               step1: 0, step2:0, step3: 0,
               emissionBenzin: 0, emissionDizel:0,
               carPrice: 0, carFuel: '', carCCM: '', carEURO: '', carCO2: '',
               stopnjaDavka: 0, stopnjaPribitka: 0, znesekPribitka: 0, skupajDavek: 0, znesekDavka: 0
           }
       },
        methods: {
            calculate: function () {

                var costs = [240, 260, 280, 320, 320, 330, 350, 400, 300, 350, 400, 430 ];
                this.transportCosts = costs[this.location];

                if(this.fuel === 'elektrika') {
                    this.fuelPoints = 1;
                } else if (this.fuel === 'dizel') {
                    this.fuelPoints = 2;
                } else {
                    this.fuelPoints = 3
                }

                if (this.euroEngine === 'euro1') {
                    this.emissionPoints = 10;
                } else if (this.euroEngine === 'euro2') {
                    this.emissionPoints = 10;
                } else if (this.euroEngine === 'euro3') {
                    this.emissionPoints = 5;
                } else if (this.euroEngine === 'euro4') {
                    this.emissionPoints = 2;
                } else if (this.euroEngine === 'euro5') {
                    this.emissionPoints = 0;
                } else {
                    this.emissionPoints = 0;
                }

                if (this.ccm === '1') {
                    this.ccmPoints = 0;
                } else if (this.ccm === '2') {
                    this.ccmPoints = 8;
                } else if (this.ccm === '3') {
                    this.ccmPoints = 10;
                } else if (this.ccm === '4') {
                    this.ccmPoints = 13;
                } else {
                    this.ccmPoints = 16;
                }

                if (this.fuel === 'dizel' && this.dizelTrdiDelci === true) {
                    this.dizelTrdiDelci = 5;
                } else {
                    this.dizelTrdiDelci = 0;
                }

                if (this.fuel === 'elektrika') {
                    this.co2 = 0;
                }

                if (this.co2 >= 0 && this.co2 < 110.1) {
                    this.emissionBenzin = 0.5;
                    this.emissionDizel = 1
                } else if(this.co2 > 110.1 && this.co2 < 120.01) {
                    this.emissionBenzin = 1;
                    this.emissionDizel = 2;
                } else if (this.co2 > 120.01 && this.co2 < 130.01) {
                    this.emissionBenzin = 1.5;
                    this.emissionDizel = 3
                } else if (this.co2 > 130.01 && this.co2 < 150.01) {
                    this.emissionBenzin = 3;
                    this.emissionDizel = 6
                } else if (this.co2 > 150.01 && this.co2 < 170.01) {
                    this.emissionBenzin = 6;
                    this.emissionDizel = 11
                } else if (this.co2 > 170.01 && this.co2 < 190.01) {
                    this.emissionBenzin = 9;
                    this.emissionDizel = 15
                } else if (this.co2 > 190.01 && this.co2 < 210.01) {
                    this.emissionBenzin = 13;
                    this.emissionDizel = 18;
                } else if (this.co2 > 210.01 && this.co2 < 230.1) {
                    this.emissionBenzin = 18;
                    this.emissionDizel = 22;
                } else if (this.co2 > 230.01 && this.co2 < 250.01) {
                    this.emissionBenzin = 23;
                    this.emissionDizel = 26;
                } else {
                    this.emissionBenzin = 28;
                    this.emissionDizel = 31;
                }

                if(this.fuel === 'ostalo'){
                    this.step1 = true;
                } else if (this.fuel === 'dizel' && this.euroEngine === 'euro6') {
                    this.step1 = true;
                } else this.step1 = this.fuel === 'elektrika';

                this.step2 = this.step1 === true ? this.emissionBenzin : this.emissionDizel;

                if (this.fuel === 'elektrika') {
                    this.step3 = this.step2;
                } else {
                    this.step3 = this.step2 + this.emissionPoints;
                }

                this.endPrice = this.price;

                this.stopnjaDavka = this.step3 + this.dizelTrdiDelci;
                this.znesekDavka = Math.round((this.stopnjaDavka / 100) * this.endPrice, 0);
                this.stopnjaPribitka = this.ccmPoints;
                this.znesekPribitka = Math.round(this.endPrice * (this.stopnjaPribitka / 100), 0);

                if (this.priceType === true) {
                    this.endPrice = Math.round((this.price / 1.19), 2);
                }

                this.skupajDavek =  (parseInt(this.endPrice) + this.znesekDavka + this.znesekPribitka + this.transportCosts + this.homologacija) * 1.22;
                this.skupajDavek += this.provision + this.otherExpenses;

                this.carPrice = this.price === 0;
                this.carFuel = this.fuel === '';
                this.carCCM = this.ccm === 0;
                this.carEURO = this.euroEngine === 0;
                this.carCO2 = this.fuel !== 'elektrika' && this.co2 === 0;
                this.show = this.carPrice === false && this.carFuel === false && this.carCCM === false && this.carEURO === false && this.carCO2 === false;
            }
        }
    }
</script>
