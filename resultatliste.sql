SET @sql_dynamic = (
	SELECT
		GROUP_CONCAT( DISTINCT
			CONCAT( 
				'SUM( IF(resspillerref = '
				, resspillerref
				, ', respoeng,0) ) AS m_'
				, resspillerref
			)
			ORDER BY resspillerref
		)
	FROM resultat
);

SET @sql_static = CONCAT( 'SELECT  resomgref AS omgang, ',
	@sql_dynamic, '
	FROM kaerkis.resultat
	GROUP BY resomgref'
);

PREPARE stmt FROM @sql_static;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;