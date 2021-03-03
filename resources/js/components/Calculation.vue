<template>
    <div class="row">
        <div class="col-md-6">
            <div class="row">
                <label for="price" class="col-sm-3 align-self-center">Cena vozila</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" v-bind:class="{ 'is-invalid': carPrice }" id="price" v-model="price" aria-describedby="emailHelp" title="vpišite ceno vozila v evrih" required>
                    <div class="invalid-feedback">
                        Vpišite ceno vozila
                    </div>
                </div>
            </div>
            <fieldset>
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
                    <select class="custom-select" id="selectBox1" v-bind:class="{ 'is-invalid': carFuel }" v-model="fuel" title="izberite tip goriva" @change="checkFuelType()" required>
                        <option value="">Tip goriva</option>
                        <option value="dizel">Dizel</option>
                        <option value="elektrika">Elektrika</option>
                        <option value="benzin">Benzin(+vse ostalo)</option>
                    </select>
                    <div class="invalid-feedback">
                        Izberite tip goriva
                    </div>
                </div>
            </div>
            <div class="row" v-if="fuelType">
                <div class="col-sm-3 align-self-center">Prva registracija</div>
                <div class="col-sm-9">
                    <input type="text" class="form-control" v-bind:class="{ 'is-invalid': carMonthYear }" id="monthYear" v-model="monthYear" aria-describedby="emailHelp" title="vpišite mesec in leto prve registracije" required>
                    <div class="small">
                        Format: mm/llll
                    </div>
                    <div class="invalid-feedback">
                        Vneste datum prve registracije
                    </div>
                </div>
            </div>
            <div class="row" v-if="fuelType">
                <div class="col-sm-3 align-self-center">EURO motor</div>
                <div class="col-sm-9">
                    <select class="custom-select" id="selectBox3" v-bind:class="{ 'is-invalid': carEURO }" v-model="euroEngine" title="izberite tip EURO standarda motorja" required>
                        <option value="">Tip motorja</option>
                        <option value="0">EURO 0,1,2,3</option>
                        <option value="1">EURO 4</option>
                        <option value="2">EURO 5, 5a, 5b</option>
                        <option value="3">EURO 6, 6a, 6b</option>
                        <option value="4">EURO 6c</option>
                        <option value="5">EURO 6d</option>
                        <option value="6">višji od EURO 6d</option>
                    </select>
                    <div class="invalid-feedback">
                        Izberite EURO standard motorja
                    </div>
                </div>
            </div>
            <div class="row" v-if="fuelType">
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
                        Znesek DMV: {{ total | format }}€<br>
                        Strošek transporta: {{ transport.costs | format }}€ + DDV<br>
                        Homologacija: {{ homologacija | format }}€<br>
                    </p>
                    <hr>
                    <p class="mb-0">
                        Končni znesek vozila z davkom in transportom: <b>{{ grandTotal | format }}€</b><br><br>
                        <span class="font-weight-light">Končna cena vključuje DMV, DDV, homologacijo, stroške uvoza in transporta <i class="fas fa-info-circle" data-toggle="transport-info" title="Izračun je informativen in velja v primeru plačila vozila po predračunu."></i></span>
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
               price: 0, endPrice: 0, carMonthYear: 0,
               fuel: '',
               euroEngine: '',
               co2: 0,
               show: false, fuelType: true, priceType: false,
               emission:0, emissionPoints: 1,
               location: 0, transport: 0,
               monthYear: '',
               grandTotal: 0, total:0,
               step1: 0, step2:0, step3: 0,
               carPrice: 0, carFuel: '', carCCM: '', carEURO: '', carCO2: '',
               NEDCFaktorBenzin: 1.22, NEDCFaktorDizel: 1.2,
               faktor: 0, popravek: 0, co2Factor: 0
           }
       },
        filters: {
          format(val) {
              if (typeof val !== "undefined") {
                  return val.toFixed(1)
              }
          }
        },
        methods: {
           checkFuelType() {
             this.fuelType = this.fuel !== 'elektrika'
           },
            getEuroStandard(fuel, index) {
                let euroEmissionBenzin = [500, 400, 150, 75, 50, 50, 30, 10]
                let euroEmmisionDiesel = [1000, 800, 225, 112, 75, 45, 15]

                return fuel === 'dizel' ? euroEmmisionDiesel[index] : euroEmissionBenzin[index]
            },
            getTransportCosts(location) {
                let costs = [240, 260, 280, 320, 320, 330, 350, 400, 300, 350, 400, 430 ]
                let factorCountry = 0

                factorCountry = location < 8 ? 1.19 : 1.21

                return {
                    'costs': costs[location],
                    'factorCountry': factorCountry
                }
            },
            getEmissions(co2, fuel) {
                let pribitek = 0
                let min = 0
                let pribitekBenzin = 0
                let minBenzin = 0
                let pribitekDizel = 0
                let minDizel = 0
                let minSpodnja = 0

                if (co2 < 50) {
                    pribitekBenzin = 0
                    minBenzin = 0
                    pribitekDizel = 0
                    minDizel = 0
                    minSpodnja = 0
                } else if(co2 > 50 && co2 <=100) {
                    pribitekBenzin = 0.4
                    minBenzin = 0
                    pribitekDizel = 0.5
                    minDizel = 0
                    minSpodnja = 50
                } else if(co2 > 100 && co2 <= 140) {
                    pribitekBenzin = 0.7
                    minBenzin = 20
                    pribitekDizel = 0.8
                    minDizel = 25
                    minSpodnja = 100
                } else if(co2 > 140 && co2 <= 190) {
                    pribitekBenzin = 5
                    minBenzin = 48
                    pribitekDizel = 6
                    minDizel = 57
                    minSpodnja = 140
                } else if(co2 > 190 && co2 <= 230) {
                    pribitekBenzin = 30
                    minBenzin = 298
                    pribitekDizel = 36
                    minDizel = 357
                    minSpodnja = 190
                } else {
                    pribitekBenzin = 30
                    minBenzin = 298
                    pribitekDizel = 36
                    minDizel = 357
                    minSpodnja = 230
                }

                pribitek = fuel === 'benzin' ? pribitekBenzin : pribitekDizel
                min = fuel === 'benzin' ? minBenzin : minDizel

                return {
                    'pribitek':pribitek,
                    'min': min,
                    'minSpodnja': minSpodnja
                }
            },
            diffYears(date2, date1) {
                let  diff =(date2.getTime() - date1.getTime()) / 1000
                diff /= (60 * 60 * 24);
                return Math.floor(Math.abs(diff/365.25))
            },
            getPopravek(monthYear) {
                let splitted = monthYear.split("/")
                let percentage = 0
                let yearDiff = 0

                let carYear =  new Date(splitted[1], splitted[0]-1)
                let year = new Date().getFullYear()
                let month = new Date().getMonth()

                let currentMonthYear = new Date(year, month)

                yearDiff = this.diffYears(carYear, currentMonthYear)

                switch(true) {
                    case yearDiff === 0:
                        percentage = 0.91
                        break
                    case yearDiff < 2:
                        percentage = 0.83
                        break
                    case yearDiff < 3:
                        percentage = 0.76
                        break
                    case yearDiff < 4:
                        percentage = 0.70
                        break
                    case yearDiff < 5:
                        percentage = 0.64
                        break
                    case yearDiff < 6:
                        percentage = 0.58
                        break
                    case yearDiff < 7:
                        percentage = 0.53
                        break
                    case yearDiff < 8:
                        percentage = 0.48
                        break
                    case yearDiff < 10:
                        percentage = 0.38
                        break
                    default:
                        percentage = 0.33
                }
                return percentage
            },
            checkYearFaktor(monthYear) {
                let splitted = monthYear.split("/")
                let firstRegistration = new Date(splitted[1],splitted[0])
                let dateToCheck = new Date(2017, 8 ,1)
                return firstRegistration < dateToCheck
            },
            calculate() {
                this.transport = this.getTransportCosts(this.location)


                if (this.fuel !== 'elektrika') {
                    if (this.checkYearFaktor(this.monthYear)) {
                        this.co2Factor = this.fuel === 'benzin' ? (this.co2 * this.NEDCFaktorBenzin) : (this.co2 * this.NEDCFaktorDizel)
                    } else {
                        this.co2Factor = this.co2
                    }

                    this.emission = this.getEmissions(this.co2Factor, this.fuel)

                    this.popravek = this.getPopravek(this.monthYear)

                    this.result = this.emission.min + ((this.co2Factor - this.emission.minSpodnja) * this.emission.pribitek)


                    if(this.fuel !== 'elektrika') {
                        this.emissionPoints = this.getEuroStandard(this.fuel, this.euroEngine)
                    }

                  this.total = (this.emissionPoints + this.result) * this.popravek
                } else {
                    this.total = 0
                }

                this.endPrice = this.price;

                if (this.priceType === true) {
                    this.endPrice = Math.round((this.price / this.transport.factorCountry), 2)
                }

                this.grandTotal =  Math.round(((parseInt(this.endPrice) + this.total + this.transport.costs + this.homologacija) * 1.22), 2)
                this.grandTotal += this.provision + this.otherExpenses

                this.carPrice = this.price === 0
                this.carFuel = this.fuel === ''
                this.carMonthYear = this.monthYear === ''
                this.carEURO = this.euroEngine === ''
                this.carCO2 = this.fuel !== 'elektrika' && this.co2 === 0

                if (this.fuel !== 'elektrika') {
                    this.show = this.carPrice === false && this.carFuel === false && this.carEURO === false && this.carCO2 === false && this.carMonthYear === false
                } else {
                    this.show = this.carPrice === false && this.carFuel === false
                }
            }
        }
    }
</script>
