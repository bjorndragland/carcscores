

var spiller = [
    { 'SpillerID': 1, 'SpillerFornavn': 'Asgeir', 'SpillerOmgang': 0, 'SpillerResultat': 0 },
    { 'SpillerID': 2, 'SpillerFornavn': 'Bj\u00f8rn', 'SpillerOmgang': 0, 'SpillerResultat': 0 },
    { 'SpillerID': 12, 'SpillerFornavn': 'Taystee', 'SpillerOmgang': 0, 'SpillerResultat': 0 }
];

var reslinje = [
    { 'id': 'resomgref', 'verdi': '166' },
    { 'id': 'omgangdato', 'verdi': '2018-10-18' },
    { 'id': 1, 'verdi': '0' },
    { 'id': 2, 'verdi': '112' },
    { 'id': 12, 'verdi': '0' }
];

function lookUpPlayer(playerArr, playerID) {

    for (i = 0; i < playerArr.length; i++) {
        if (playerArr[i].SpillerID == playerID) {
            alert(playerArr[i].SpillerFornavn);
        }
    }



}

