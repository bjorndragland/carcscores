
var app1 = new Vue({
    el: "#app-carc",

    data: {
        spiller: [],
        resultat: [],
        resultatToChange: {},
        nesteOmgangID: 0,
        omgangDato: "",
        showingmodalAddOmgang: false,
        showingmodalChangeOmgang: false,
        showingAddSpiller: false,
        show: true,
        isActive: true,
        troll:
        {
            "spiller": {
                1: {
                    "SpillerID": "1",
                    "SpillerFornavn": "Asgeir",
                    "SpillerOmgang": 0,
                    "SpillerResultat": 0

                },
                2: {
                    "SpillerID": "2",
                    "SpillerFornavn": "Bj\u00f8rn",
                    "SpillerOmgang": 0,
                    "SpillerResultat": 0

                },
                7: {
                    "SpillerID": "7",
                    "SpillerFornavn": "Terje",
                    "SpillerOmgang": 0,
                    "SpillerResultat": 0
                }
            }
        }
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
            let DateNow = new Date;
            let Maaned, Dag;
            if ((DateNow.getMonth() + 1) < 10) {
                Maaned = "0" + (DateNow.getMonth() + 1)
            } else {
                Maaned = (DateNow.getMonth() + 1)
            }

            if (DateNow.getDate() < 10) {
                Dag = "0" + DateNow.getDate()
            } else {
                Dag = DateNow.getDate()
            }
            var DateString = DateNow.getFullYear() + "-" + Maaned + "-" + Dag;
            //sett riktig datoformat for input
            this.omgangDato = DateString;
            //console.log(DateString);
        },

        checkContent: function (resultatlinje) {
            //console.log(resultatlinje);
            this.resultatToChange = resultatlinje;
            console.log();
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
            // opprett omgang med dato fra dato-input
            axios.post("http://localhost/bjornagain/carcscores/carcscores/omgang/create.php", {
                OmgangID: "NULL", OmgangDato: app1.omgangDato
            })
                .then(function (response) {
                    // console.log(response);
                })

            // opprett resultater fra array
            axios.post("http://localhost/bjornagain/carcscores/carcscores/resultat/createmulti.php", app1.spillerRes
            )
                // les inn til spillere på nytt.
                .then(this.readSpillerViaREST())
                // les resultater fra database på nytt
                .then(this.readComplexResultatViaREST())
                // les siste omgangsID på nytt:
                .then(this.readLastOmgangIDViaREST())

        },

        flashTableRow: function () {
            //document.querySelector(".tr:nth-child(2)").style.backgroundColor = "red";
            //console.log("jjjj");
            //this.isActive = false;
            console.log(this.resultat);

        },

        nullStillSpiller: function () {
            return this.spiller.map((spi) => {
                spi.SpillerOmgang = this.nesteOmgangID;
                spi.SpillerResultat = 0;
                return spi
            })
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
                .then(response => { this.nesteOmgangID = (response.data.Auto_increment).toString() })
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