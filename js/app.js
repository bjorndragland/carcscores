var app1 = new Vue({
    el: "#app-carc",

    data: {
        spiller: [],
        resultat: [],
        spillerNew: {
        },
        showingAddModal: false
    },

    created:
        function () {
            this.readSpillerViaREST();
            this.readResultatViaREST()
        },

    methods: {
        readSpillerViaREST: function () {
            axios.get("http://localhost/bjornagain/carcscores/carcscores/spiller/read.php")
                .then(response => { this.spiller = response.data.spiller })
            // .then(response => console.log(response))
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
        }
    }
}

);