<template>
    <div>
        <div class="form-group">
            <label for="title">Model</label>
            <input type="text" class="form-control" id="title" aria-describedby="emailHelp" placeholder="Vnesite model" name="title" v-model="title" @input="$v.title.$touch" required>
            <span>
                  <div class="small" :class="{invalid: $v.title.$error}">Še {{$v.title.$params.maxLength.max - title.length }} znakov</div>
            </span>
        </div>
        <div class="form-group">
            <label for="subtitle">Oznaka</label>
            <input type="text" class="form-control" id="subtitle" aria-describedby="emailHelp" placeholder="Vnesite oznako" name="subtitle" v-model="subtitle" @input="$v.subtitle.$touch" required>
            <span>
                <div class="small" :class="{invalid: $v.subtitle.$error}">Še {{$v.subtitle.$params.maxLength.max - subtitle.length }} znakov</div>
            </span>
        </div>
        <div class="form-group">
            <label for="price">Cena</label>
            <small id="text-muted" class="form-text text-muted">Format e.g. 21.000, brez znaka za €</small>
            <input type="text" class="form-control" id="price" aria-describedby="emailHelp" placeholder="Vnesite ceno" name="price" required>
            <div class="form-check">
                <input class="form-check-input" id="cfp" type="checkbox" value="checked" name="cfp">
                <label class="form-check-label" for="cfp">
                    Pokličite za ceno
                </label>
            </div>
        </div>
        <div class="form-group">
            <label for="description">Opis</label>
            <textarea class="form-control" id="description" rows="4" name="description" v-model="description" @input="$v.description.$touch" required></textarea>
            <span>
                   <div class="small" :class="{invalid: $v.description.$error}">Še {{$v.description.$params.maxLength.max - description.length }} znakov</div>
            </span>
        </div>
        <div class="form-group">
            <div class="form-check">
                <input class="form-check-input" id="new" type="checkbox" value="checked" name="new">
                <label class="form-check-label" for="new">
                    Novo vozilo
                </label>
            </div>
        </div>
        <div class="form-group">
            <label for="file">Slika</label>
            <br>
            <small class="text-muted">Slika bo avtomatsko zmanjšana na primerno velikost.</small>
            <input type="file" class="form-control-file" name="file" id="file">
        </div>
    </div>
</template>

<script>

    import { required, maxLength } from 'vuelidate/lib/validators'

    export default {
        name: "Add",
        data() {
            return {
                title: '', subtitle: '', description: ''
            }
        },
        validations: {
            title: {
                maxLength: maxLength(20)
            },
            subtitle: {
                maxLength: maxLength(45)
            },
            description: {
                maxLength: maxLength(120)
            }
        }
    }
</script>
<style>
    .invalid {
        color: #ed1c24;
    }
</style>
