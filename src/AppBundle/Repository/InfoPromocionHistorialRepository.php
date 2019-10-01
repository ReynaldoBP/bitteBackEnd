<?php

namespace AppBundle\Repository;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

/**
 * InfoPromocionHistorialRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class InfoPromocionHistorialRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Documentación para la función 'getPromoHistorialCriterio'
     * Método encargado de retornar todos las promociones según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 29-09-2019
     * 
     * @return array  $arrayPromocion
     * 
     */
    public function getPromoHistorialCriterio($arrayParametros)
    {
        $strEstado          = $arrayParametros['strEstado'] ? $arrayParametros['strEstado']:array('PENDIENTE');
        $intIdCliente       = $arrayParametros['intIdCliente'] ? $arrayParametros['intIdCliente']:'';
        $arrayPromocion     = array();
        $strMensajeError    = '';
        $objRsmBuilder      = new ResultSetMappingBuilder($this->_em);
        $objQuery           = $this->_em->createNativeQuery(null, $objRsmBuilder);
        try
        {
            $strSelect      = "SELECT sum(IPROMO.CANTIDAD_PUNTOS) as CANTIDAD_PUNTOS ";
            $strFrom        = "FROM INFO_CLIENTE_PROMOCION_HISTORIAL ICPH
                                JOIN INFO_PROMOCION IPROMO
                                    ON IPROMO.ID_PROMOCION=ICPH.PROMOCION_ID ";
            $strWhere       = "WHERE ICPH.ESTADO in (:ESTADO) ";
            $objQuery->setParameter("ESTADO",$strEstado);
            if(!empty($intIdCliente))
            {
                $strWhere .= " AND ICPH.CLIENTE_ID =:CLIENTE_ID";
                $objQuery->setParameter("CLIENTE_ID", $intIdCliente);
            }
            $objRsmBuilder->addScalarResult('CANTIDAD_PUNTOS', 'CANTIDAD_PUNTOS', 'integer');
            $strSql       = $strSelect.$strFrom.$strWhere;
            $objQuery->setSQL($strSql);
            $arrayPromocion['resultados'] = $objQuery->getSingleScalarResult();
        }
        catch(\Exception $ex)
        {
            $strMensajeError = $ex->getMessage();
        }
        $arrayPromocion['error'] = $strMensajeError;
        return $arrayPromocion;
    }
    /**
     * Documentación para la función 'getPromocionCriterioWeb'
     * Método encargado de retornar todos los historiales promociones según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 29-09-2019
     * 
     * @return array  $arrayPromocion
     * 
     */
    public function getPromocionCriterioWeb($arrayParametros)
    {
        $strEstado          = $arrayParametros['strEstado'] ? $arrayParametros['strEstado']:array('PENDIENTE');
        $intIdRestaurante   = $arrayParametros['intIdRestaurante'] ? $arrayParametros['intIdRestaurante']:'';
        $intIdCliente       = $arrayParametros['intIdCliente'] ? $arrayParametros['intIdCliente']:'';
        $arrayPromocion     = array();
        $strMensajeError    = '';
        $objRsmBuilder      = new ResultSetMappingBuilder($this->_em);
        $objQuery           = $this->_em->createNativeQuery(null, $objRsmBuilder);
        try
        {
            $strSelect      = "SELECT ICH.ID_CLIENTE_PUNTO_HISTORIAL,ICH.ESTADO AS ESTADO_PROMOCION_HISTORIAL,ICH.CLIENTE_ID,
                                IPROMO.ID_PROMOCION,IPROMO.DESCRIPCION_TIPO_PROMOCION,IPROMO.ESTADO AS ESTADO_PROMOCION,
                                IRE.ID_RESTAURANTE,IRE.NOMBRE_COMERCIAL,IRE.ESTADO AS ESTADO_RESTAURANTE ";
            $strFrom        = "FROM INFO_CLIENTE_PROMOCION_HISTORIAL ICH
                                JOIN INFO_PROMOCION IPROMO 
                                    ON IPROMO.ID_PROMOCION = ICH.PROMOCION_ID
                                JOIN INFO_SUCURSAL ISU
                                    ON ISU.ID_SUCURSAL=IPROMO.SUCURSAL_ID
                                JOIN INFO_RESTAURANTE IRE
                                    ON IRE.ID_RESTAURANTE=ISU.RESTAURANTE_ID ";
            $strWhere       = "WHERE ICH.ESTADO in (:ESTADO) ";
            $objQuery->setParameter("ESTADO",$strEstado);
            if(!empty($intIdRestaurante))
            {
                $strWhere .= " AND IRE.ID_RESTAURANTE =:ID_RESTAURANTE ";
                $objQuery->setParameter("ID_RESTAURANTE", $intIdRestaurante);
            }
            if(!empty($intIdCliente))
            {
                $strWhere .= " AND ICH.CLIENTE_ID =:CLIENTE_ID ";
                $objQuery->setParameter("CLIENTE_ID", $intIdCliente);
            }
            $objRsmBuilder->addScalarResult('ID_CLIENTE_PUNTO_HISTORIAL', 'ID_CLIENTE_PUNTO_HISTORIAL', 'string');
            $objRsmBuilder->addScalarResult('ESTADO_PROMOCION_HISTORIAL', 'ESTADO_PROMOCION_HISTORIAL', 'string');
            $objRsmBuilder->addScalarResult('CLIENTE_ID', 'CLIENTE_ID', 'string');
            $objRsmBuilder->addScalarResult('ID_PROMOCION', 'ID_PROMOCION', 'string');
            $objRsmBuilder->addScalarResult('DESCRIPCION_TIPO_PROMOCION', 'DESCRIPCION_TIPO_PROMOCION', 'string');
            $objRsmBuilder->addScalarResult('ESTADO_PROMOCION', 'ESTADO_PROMOCION', 'string');
            $objRsmBuilder->addScalarResult('ID_RESTAURANTE', 'ID_RESTAURANTE', 'string');
            $objRsmBuilder->addScalarResult('NOMBRE_COMERCIAL', 'NOMBRE_COMERCIAL', 'string');
            $objRsmBuilder->addScalarResult('ESTADO_RESTAURANTE', 'ESTADO_RESTAURANTE', 'string');
            $strSql       = $strSelect.$strFrom.$strWhere;
            $objQuery->setSQL($strSql);
            $arrayPromocion['resultados'] = $objQuery->getResult();
        }
        catch(\Exception $ex)
        {
            $strMensajeError = $ex->getMessage();
        }
        $arrayPromocion['error'] = $strMensajeError;
        return $arrayPromocion;
    }
}
