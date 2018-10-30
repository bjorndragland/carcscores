
SELECT resultat.resomgref, omgang.omgangdato,

    SUM( IF(resspillerref = 1, respoeng,0) ) AS m1,
	SUM( IF(resspillerref = 2, respoeng,0) ) AS m2,
	SUM( IF(resspillerref = 3, respoeng,0) ) AS m3

FROM kaerkis.resultat
INNER JOIN omgang ON resultat.resomgref = omgang.omgangID
group by resomgref