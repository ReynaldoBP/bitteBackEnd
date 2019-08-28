<?php

namespace AppBundle\Repository;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
/**
 * AdmiSectorRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AdmiSectorRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Documentación para la función 'getSector'.
     * Método encargado de retornar todos los sectores según los parámetros enviados.
     * 
     * @author Kevin Baque
     * @version 1.0 16-07-2019
     * 
     * @return array  $arraySector
     * 
     */
    public function getSector($arrayParametros)
    {
        $strEstado       = $arrayParametros['estado'] ? $arrayParametros['estado']:array('ACTIVO','INACTIVO','ELIMINADO');
        $strParroquia    = $arrayParametros['idParroquia'] ? $arrayParametros['idParroquia']:'';
        $intIdSector     = $arrayParametros['idSector'] ? $arrayParametros['idSector']:'';
        $arraySector     = array();
        $objRsmBuilder   = new ResultSetMappingBuilder($this->_em);
        $objQuery        = $this->_em->createNativeQuery(null, $objRsmBuilder);
        $strMensajeError = '';
        $strSelect       = '';
        $strFrom         = '';
        $strWhere        = '';
        try
        {
            $strSelect = "SELECT sector.ID_SECTOR,sector.PARROQUIA_ID,sector.SECTOR_NOMBRE,sector.ESTADO ";
            $strFrom   = "FROM ADMI_SECTOR sector ";
            $strWhere  = "WHERE sector.ESTADO in (:ESTADO) ";
            $objQuery->setParameter("ESTADO", $strEstado);
            if(!empty($intIdSector))
            {
                $strWhere .= " AND sector.ID_SECTOR = :ID_SECTOR ";
                $objQuery->setParameter("ID_SECTOR", $intIdSector);
            }
            if(!empty($strParroquia))
            {
                $strFrom  .= " , ADMI_PARROQUIA parroquia ";
                $strWhere .= " AND parroquia.ID_PARROQUIA = sector.PARROQUIA_ID AND parroquia.ID_PARROQUIA = :ID_PARROQUIA ";
                $objQuery->setParameter("ID_PARROQUIA", $strParroquia);
            }
            $objRsmBuilder->addScalarResult('ID_SECTOR', 'ID_SECTOR', 'string');
            $objRsmBuilder->addScalarResult('PARROQUIA_ID', 'PARROQUIA_ID', 'string');
            $objRsmBuilder->addScalarResult('SECTOR_NOMBRE', 'SECTOR_NOMBRE', 'string');
            $objRsmBuilder->addScalarResult('ESTADO', 'ESTADO', 'string');

            $strSql  = $strSelect.$strFrom.$strWhere;
            $objQuery->setSQL($strSql);
            $arraySector['Sector'] = $objQuery->getResult();
        }
        catch(\Exception $ex)
        {
            $strMensajeError = $ex->getMessage();
        }
        $arraySector['error'] = $strMensajeError;
        return $arraySector;
    }
}
