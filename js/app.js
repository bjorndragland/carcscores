
var app1 = new Vue({
    el: "#app-carc",

    data: {
        spiller: [],
        resultat: [],
        resultatToChange: {},
        resultatToKeep: {},
        nesteOmgangID: 0,
        omgangDato: "",
        showingmodalAddOmgang: false,
        showingmodalChangeOmgang: false,
        showingAddSpiller: false,
        show: true,
        isActive: true
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
        },

        // i bruk
        resetChange: function () {
            // dersom avbrutt, nullstill ved å laste tabell på nytt
            this.readComplexResultatViaREST();
        },

        /*
                slettResultat: function (skalSlettes) {
                    alert(skalSlettes);
                },
        */

        // i bruk
        checkContent: function (resultatlinje) {
            this.resultatToChange = resultatlinje;
            //this.resultatToKeep = JSON.parse(JSON.stringify(this.resultatToChange));
            console.log();
        },

        // i bruk
        readSpillerViaREST: function () {
            axios.get("http://localhost/bjornagain/carcscores/carcscores/spiller/read.php")
                .then(response => { this.spiller = response.data.spiller })
        },
        /*
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
                },
        
                createResultatViaREST: function (resultatNew) {
                    axios.post("http://localhost/bjornagain/carcscores/carcscores/resultat/create.php", {
                        ResultatID: resultatNew.ResultatID, ResOmgRef: resultatNew.ResOmgRef,
                        ResSpillerRef: resultatNew.ResSpillerRef, ResPoeng: resultatNew.ResPoeng
                    })
                },
        */

        // i bruk
        updateResultatViaREST: function (resultatNew) {
            axios.post("http://localhost/bjornagain/carcscores/carcscores/resultat/updatemulti.php", {
                //ResultatID: "22"
                ResultatID: resultatNew
            })
        },

        // i bruk
        deleteResultatViaREST: function (resultatDelete) {
            //alert(resultatDelete);
            axios.post("http://localhost/bjornagain/carcscores/carcscores/resultat/delete.php", {
                ResultatID: resultatDelete
            })
                .then(this.readComplexResultatViaREST())
                // les siste omgangsID på nytt:
                .then(this.readLastOmgangIDViaREST())
        },

        // i bruk
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

        // i bruk
        flashTableRow: function () {
            //document.querySelector(".tr:nth-child(2)").style.backgroundColor = "red";
            //console.log("jjjj");
            //this.isActive = false;
            console.log(this.resultat);

        },

        testStuff: function () {

        },

        // i bruk
        nullStillSpiller: function () {
            return this.spiller.map((spi) => {
                spi.SpillerOmgang = this.nesteOmgangID;
                spi.SpillerResultat = 0;
                return spi
            })
        },

        // i bruk
        readComplexResultatViaREST: function () {
            axios.get("http://localhost/bjornagain/carcscores/carcscores/resultat/readcomplex.php")
                .then(response => { this.resultat = response.data.resultat })
        },

        /*
                checkValue: function () {
                    console.log(app1.message);
                },
                */

        // i bruk
        readLastOmgangIDViaREST: function () {
            axios.get("http://localhost/bjornagain/carcscores/carcscores/omgang/readLastID.php")
                .then(response => { this.nesteOmgangID = (response.data.Auto_increment).toString() })
        },

        // under arbeid
        getStat1ViaRest: function () {
            axios.get("http://localhost/bjornagain/carcscores/carcscores/statistikk/plassering.php")
                .then(response => { this.nesteOmgangID = (response.data.Auto_increment).toString() })
        }
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
            return this.resultatToChange.slice(-1 * (this.resultatToChange.length - 2))
        }/*,

        omgangResKeep: function () {
            return this.resultatToKeep.slice(-1 * (this.resultatToKeep.length - 2))
        },*/

        /*
                lookUpSpiller: function () {
                    for (i = 0; i < this.spiller.length; i++) {
                        if (this.spiller[i].SpillerID == ressos.id) {
                            return this.spiller[i].SpillerFornavn;
                        }
                    }
                }
        */
    }

}

);