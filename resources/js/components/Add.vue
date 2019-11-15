<template>
    <div>
        <div class="form-group">
            <label for="title">Model</label>
            <input type="text" class="form-control" id="title" aria-describedby="emailHelp" placeholder="Vnesite model" name="title" v-model="title" @keydown="vTitle" required>
            <span>
                  <small v-bind:style="vTitleColor">Še {{ this.titleLen - title.length}} znakov</small>
            </span>
        </div>
        <div class="form-group">
            <label for="subtitle">Oznaka</label>
            <input type="text" class="form-control" id="subtitle" aria-describedby="emailHelp" placeholder="Vnesite oznako" name="subtitle" v-model="subtitle" @keydown="vSubtitle" required>
            <span>
                  <small v-bind:style="vSubtitleColor">Še {{ this.subtitleLen - subtitle.length}} znakov</small>
            </span>
        </div>
        <div class="form-group">
            <label for="price">Cena</label>
            <small id="text-muted" class="form-text text-muted">Format e.g. 21.000</small>
            <input type="text" class="form-control" id="price" aria-describedby="emailHelp" placeholder="Vnesite ceno brez znaka za €" name="price" v-model="price" required>
        </div>
        <div class="form-group">
            <label for="description">Opis</label>
            <textarea class="form-control" id="description" rows="2" name="description" v-model="description" @keydown="vDescription" required></textarea>
            <span>
                  <small v-bind:style="vDescriptionColor">Še {{ this.descriptionLen - description.length}} znakov</small>
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

    export default {
        name: "Add",
        data() {
            return {
                title: '', subtitle: '', price: '',
                titleLen: 20, subtitleLen: 45, descriptionLen: 100,
                description: '',
                vTitleColor:{
                    color:''
                },
                vSubtitleColor:{
                    color:''
                },
                vDescriptionColor:{
                    color:''
                },
                gray: '#586168', red:'#ed1c24'
            }
        },
        methods: {
            vTitle() {
                this.vTitleColor.color = this.titleLen - this.title.length > 0 ? this.gray : this.red;
            },
            vSubtitle() {
                this.vSubtitleColor.color = this.subtitleLen - this.subtitle.length > 0 ? this.gray : this.red;
            },
            vDescription() {
                this.vDescriptionColor.color = this.descriptionLen - this.description.length > 0 ? this.gray : this.red;
            }
        }
    }
</script>
