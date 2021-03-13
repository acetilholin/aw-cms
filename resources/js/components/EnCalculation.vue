<template>
    <div class="row">
        <div class="col-md-6">
            <div class="row">
                <label for="price" class="col-sm-3 align-self-center">Vehicle price</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" v-bind:class="{ 'is-invalid': carPrice }" id="price" v-model="price" aria-describedby="emailHelp" title="enter vehicle price in euros" required>
                    <div class="invalid-feedback">
                        Enter car price
                    </div>
                </div>
            </div>
            <fieldset>
                <div class="row">
                    <legend class="col-form-label col-sm-3">Price type</legend>
                    <div class="col-sm-9">
                        <div class="custom-control custom-switch" id="test1">
                            <input type="checkbox" class="custom-control-input" id="grossnett" v-model="priceType">
                            <label class="custom-control-label" for="grossnett">
                                <span v-if="priceType" class="choosen">Gross</span>
                                <span v-else class="choosen">Nett</span></label>
                        </div>
                    </div>
                </div>
            </fieldset>
            <div class="row">
                <div class="col-sm-3 align-self-center">Fuel</div>
                <div class="col-sm-9">
                    <select class="custom-select" id="selectBox1" v-bind:class="{ 'is-invalid': carFuel }" v-model="fuel" @change="checkFuelType()" title="select fuel type" required>
                        <option value="">Fuel type</option>
                        <option value="dizel">Diesel</option>
                        <option value="elektrika">Electricity</option>
                        <option value="benzin">Petrol(+ rest)</option>
                    </select>
                    <div class="invalid-feedback">
                        Select fuel type
                    </div>
                </div>
            </div>
            <div class="row" v-if="fuelType">
                <div class="col-sm-3 align-self-center">First registration</div>
                <div class="col-sm-9">
                    <input type="text" class="form-control" v-bind:class="{ 'is-invalid': carMonthYear || monthYearFormat }" id="monthYear" v-model="monthYear" aria-describedby="emailHelp" title="month and year of first registration" required>
                    <div class="small">
                        Format: MM/YYYY
                    </div>
                    <div class="invalid-feedback" v-if="carMonthYear">
                        Insert date of first registration
                    </div>
                    <div class="invalid-feedback" v-if="monthYearFormat">
                        Wrong format
                    </div>
                </div>
            </div>
            <div class="row" v-if="fuelType">
                <div class="col-sm-3 align-self-center">EURO motor</div>
                <div class="col-sm-9">
                    <select class="custom-select" id="selectBox3" v-bind:class="{ 'is-invalid': carEURO }" v-model="euroEngine" title="select EURO engine standard" required>
                        <option value="">Engine standard</option>
                        <option value="0">EURO 0,1,2,3</option>
                        <option value="1">EURO 4</option>
                        <option value="2">EURO 5, 5a, 5b</option>
                        <option value="3">EURO 6, 6a, 6b</option>
                        <option value="4">EURO 6c</option>
                        <option value="5">EURO 6d</option>
                        <option value="6">higher than EURO 6d</option>
                    </select>
                    <div class="invalid-feedback">
                        Choose EURO engine standard
                    </div>
                </div>
            </div>
            <div class="row" v-if="fuelType">
                <div class="col-sm-3 align-self-center">CO2 emissions</div>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="emission" aria-describedby="emailHelp" placeholder="0" v-bind:class="{ 'is-invalid': carCO2 }" v-model="co2" required>
                    <div class="invalid-feedback">
                        Insert CO2 emissions
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3 align-self-center pad-2">Transportation</div>
                <div class="col-sm-9">
                    <select class="custom-select" id="selectBox4" v-model="location" title="select approx. location of transport" required>
                        <optgroup label="Germany" data-max-options="1">
                            <option value="0">München</option>
                            <option value="1">Frankfurt, Nürnberg, Saarbrucken</option>
                            <option value="2">Köln, Dortmund, Kassel</option>
                            <option value="3">Munster</option>
                            <option value="4">Leipzig</option>
                            <option value="5">Hannover</option>
                            <option value="6">Berlin, Hamburg, Bremen</option>
                            <option value="7">Flensburg</option>
                        </optgroup>
                        <optgroup label="Belgium" data-max-options="1">
                            <option value="8">Whole country</option>
                        </optgroup>
                        <optgroup label="Holland" data-max-options="1">
                            <option value="9" >Rotterdam + Amsterdam</option>
                            <option value="10">Groningen</option>
                            <option value="11">Other cities in NL</option>
                        </optgroup>
                    </select>
                </div>
            </div>
            <transition name="fade">
                <div class="alert alert-secondary" role="alert" v-show="show" style="animation-duration: 1s">
                    <h4 class="alert-heading">Calculation:</h4>
                    <p>
                        DMV Tax: {{ total | format }}€<br>
                        Transportation costs: {{ transport.costs | format }}€ + DDV<br>
                        Homologation: {{ homologacija | format }}€<br>
                    <hr>
                    <p class="mb-0">
                        Final vehicle costs including taxes and transportation: <b>{{ grandTotal | format }}€</b><br><br>
                        <span class="font-weight-light">Final price includes "DMV", VAT, homologation, import costs and transport <i class="fas fa-info-circle" data-toggle="transport-info" title="The calculation is for information only and is valid in the case of payment of the vehicle upon invoice."></i></span>
                    </p>
                </div>
            </transition>
            <button class="btn btn-calculate" @click="calculate()">Calculate</button>
        </div>
        <div class="col-md-6">
            Motor vehicle tax - "DMV"<br>
            <a class="modal-title" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                Read more...
            </a>
            <div id="collapseOne" class="collapse hide" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body">
                    <p>The basis for tax is the selling price of each motor vehicle, which does not include this tax and value added tax.
                        The purchase price is considered to be a purchase price when acquiring a motor vehicle from another Member State of the European Union.</p>
                    <p>If the motor vehicle referred to in the previous paragraph uses any other drive, including an electric one, or a combination of different drives (hybrid vehicle),
                        the rate of tax shall be determined by reference to the scale applicable to petrol vehicles.</p>
                </div>
            </div>
            <p style="margin-top: 1.5rem">
                    When to choose <span class="text-red">nett</span> price?<br>
                <li>buyer is a legal entity (company) with VAT number</li>
                <li>buyer is a person who finances the vehicle through loan/leasing</li>
                <li>vehicle is less than 6 months old</li>
                <li>vehicle has less than 6,000 km</li>
                <br><br>
                When to choose <span class="text-red">gross</span> price?<br>
                <li>buyer is an individual (person) who pays according to the commercial offer</li>
            </p>
        </div>
    </div>
</template>

<script>
    export default {
        name: "EnCalculation",
        data() {
            return {
                priceGross:0, priceNett: 0, provision: 590, otherExpenses: 130, homologacija: 102,
                price: 0, endPrice: 0, carMonthYear: 0, monthYearFormat: false,
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
                let pattern = /^(0[1-9]|1[012])\/\d{4}$/

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

                if (this.monthYear !== '') {
                    this.monthYearFormat = !pattern.test(this.monthYear)
                }

                this.carEURO = this.euroEngine === ''
                this.carCO2 = this.fuel !== 'elektrika' && this.co2 === 0

                if (this.fuel !== 'elektrika') {
                    this.show = this.carPrice === false && this.carFuel === false && this.carEURO === false && this.carCO2 === false && this.carMonthYear === false && this.monthYearFormat === false
                } else {
                    this.show = this.carPrice === false && this.carFuel === false
                }
            }
        }
    }
</script>
