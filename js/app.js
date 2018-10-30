
Vue.component('spiller-komp2', {
    props: ['id', 'navn', 'poeng'],
    // template: '<div><label>{{ enkeltspiller.SpillerFornavn }}</label><input type="text" {{ enkeltspiller.SpillerResultat }}></div>'
    // blir feil...
    template: `<div>
    <label>{{ navn }}</label>
    <input v-model="poeng">
    </div>`
})

var app1 = new Vue({
    el: "#app-carc",

    data: {
        spiller: [],
        resultat: [],
        nesteOmgangID: 0,
        omgangDato: "",
        showingAddModal: false,
        showingAddSpiller: false
    },

    created:
        function () {
            this.readLastOmgangIDViaREST();
            this.readSpillerViaREST();
            this.readComplexResultatViaREST();
            this.setDaters()
        },

    methods: {
        setDaters: function () {
            var DateNow = new Date;
            var DateString = DateNow.getFullYear() + "-" + (DateNow.getMonth() + 1) + "-" + DateNow.getDate();
            //sett riktig datoformat for input
            this.omgangDato = DateString;
        },

        readSpillerViaREST: function () {
            axios.get("http://localhost/bjornagain/carcscores/carcscores/spiller/read.php")
                .then(response => { this.spiller = response.data.spiller })
            //.then(response => console.log(this.spiller))
        },

        createSpillerViaREST: function (spillerNew) {
            axios.post("http://localhost/bjornagain/carcscores/carcscores/spiller/create.php", {
                SpillerFornavn: spillerNew.SpillerFornavn
            })
        },

        readOmgangViaREST: function () {
            axios.get("http://localhost/bjornagain/carcscores/carcscores/omgang/read.php")
                .then(response => { this.omganger = response.data.omganger })
        },

        createOmgangViaREST: function (omgangNew) {
            axios.post("http://localhost/bjornagain/carcscores/carcscores/omgang/create.php", {
                OmgangID: omgangNew.OmgangID
            })
        },

        readResultatViaREST: function () {
            axios.get("http://localhost/bjornagain/carcscores/carcscores/resultat/read.php")
                .then(response => { this.resultat = response.data.resultat })
            //.then(response => console.log(response.data.resultat))
        },

        createResultatViaREST: function (resultatNew) {
            axios.post("http://localhost/bjornagain/carcscores/carcscores/resultat/create.php", {
                ResultatID: resultatNew.ResultatID, ResOmgRef: resultatNew.ResOmgRef,
                ResSpillerRef: resultatNew.ResSpillerRef, ResPoeng: resultatNew.ResPoeng
            })
        },

        inputOmgangResults: function () {
            console.log(app1.spiller);
            // append resultater til tabell
            // opprett omgang med dato
            // opprett resultater fra array
        },

        readComplexResultatViaREST: function () {
            axios.get("http://localhost/bjornagain/carcscores/carcscores/resultat/readcomplex.php")
                .then(response => { this.resultat = response.data.resultat })
        },

        checkValue: function () {
            console.log(app1.message);
        },

        readLastOmgangIDViaREST: function () {
            axios.get("http://localhost/bjornagain/carcscores/carcscores/omgang/readLastID.php")
                .then(response => { this.nesteOmgangID = (parseInt(response.data.OmgangID) + 1) })
        },
    },
    computed: {
        spillerRes: function () {
            return this.spiller.map((sp) => {
                sp.SpillerOmgang = this.nesteOmgangID;
                sp.ResultatID = "NULL";
                return sp
            })
        },
        omgangRes: function () {

        }

    }

}

);