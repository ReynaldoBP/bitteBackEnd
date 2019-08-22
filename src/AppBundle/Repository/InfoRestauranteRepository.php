<?php

namespace AppBundle\Repository;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

/**
 * InfoRestauranteRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class InfoRestauranteRepository extends \Doctrine\ORM\EntityRepository
{

    /**
     * Documentación para la función 'getRestauranteCriterio'
     * Método encargado de retornar todos los restaurantes según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 16-07-2019
     * 
     * @return array  $arrayRestaurante
     * 
     */    
    public function getRestauranteCriterio($arrayParametros)
    {
        $strTipoComida         = $arrayParametros['strTipoComida'] ? $arrayParametros['strTipoComida']:'';
        $strIdentificacion     = $arrayParametros['strIdentificacion'] ? $arrayParametros['strIdentificacion']:'';
        $intIdRestaurante      = $arrayParametros['intIdRestaurante'] ? $arrayParametros['intIdRestaurante']:'';
        $strTipoIdentificacion = $arrayParametros['strTipoIdentificacion'] ? $arrayParametros['strTipoIdentificacion']:'';
        $strRazonSocial        = $arrayParametros['strRazonSocial'] ? $arrayParametros['strRazonSocial']:'';
        $strEstado             = $arrayParametros['strEstado'] ? $arrayParametros['strEstado']:array('ACTIVO','INACTIVO','ELIMINADO');
        $arrayRestaurante      = array();
        $strMensajeError       = '';
        $objRsmBuilder         = new ResultSetMappingBuilder($this->_em);
        $objQuery              = $this->_em->createNativeQuery(null, $objRsmBuilder);
        $objRsmBuilderCount    = new ResultSetMappingBuilder($this->_em);
        $objQueryCount         = $this->_em->createNativeQuery(null, $objRsmBuilderCount);
        try
        {
            $strSelect      = "SELECT IR.ID_RESTAURANTE,IR.TIPO_IDENTIFICACION, IR.IDENTIFICACION, IR.RAZON_SOCIAL, 
                                        IR.NOMBRE_COMERCIAL, IR.REPRESENTANTE_LEGAL, IR.TIPO_COMIDA_ID,ATC.DESCRIPCION_TIPO_COMIDA, 
                                        IR.DIRECCION_TRIBUTARIO, IR.URL_CATALOGO, IR.NUMERO_CONTACTO, IR.ESTADO ";
            $strSelectCount = "SELECT COUNT(*) AS CANTIDAD ";
            $strFrom        = "FROM INFO_RESTAURANTE IR,ADMI_TIPO_COMIDA ATC ";
            $strWhere       = "WHERE IR.ESTADO in (:ESTADO) AND IR.TIPO_COMIDA_ID = ATC.ID_TIPO_COMIDA";
            $objQuery->setParameter("ESTADO", $strEstado);
            $objQueryCount->setParameter("ESTADO", $strEstado);
            if(!empty($strRazonSocial))
            {
                $strWhere .= " AND lower(IR.RAZON_SOCIAL) like lower(:RAZON_SOCIAL)";
                $objQuery->setParameter("RAZON_SOCIAL", '%' . trim($strRazonSocial) . '%');
                $objQueryCount->setParameter("RAZON_SOCIAL", '%' . trim($strRazonSocial) . '%');
            }
            if(!empty($strTipoIdentificacion))
            {
                $strWhere .= " AND lower(IR.TIPO_IDENTIFICACION) like lower(:TIPO_IDENTIFICACION)";
                $objQuery->setParameter("TIPO_IDENTIFICACION", '%' . trim($strTipoIdentificacion) . '%');
                $objQueryCount->setParameter("TIPO_IDENTIFICACION", '%' . trim($strTipoIdentificacion) . '%');
            }
            if(!empty($strIdentificacion))
            {
                $strWhere .= " AND IR.IDENTIFICACION =:IDENTIFICACION";
                $objQuery->setParameter("IDENTIFICACION", $strIdentificacion);
                $objQueryCount->setParameter("IDENTIFICACION", $strIdentificacion);
            }
            if(!empty($intIdRestaurante))
            {
                $strWhere .= " AND IR.ID_RESTAURANTE =:ID_RESTAURANTE";
                $objQuery->setParameter("ID_RESTAURANTE", $intIdRestaurante);
                $objQueryCount->setParameter("ID_RESTAURANTE", $intIdRestaurante);
            }
            if(!empty($strTipoComida))
            {
                $strWhere  .= " AND ATC.ID_TIPO_COMIDA = :ID_TIPO_COMIDA";
                $objQuery->setParameter("ID_TIPO_COMIDA", $strTipoComida);
                $objQueryCount->setParameter("ID_TIPO_COMIDA", $strTipoComida);
            }
            $objRsmBuilder->addScalarResult('ID_RESTAURANTE', 'ID_RESTAURANTE', 'string');
            $objRsmBuilder->addScalarResult('TIPO_IDENTIFICACION', 'TIPO_IDENTIFICACION', 'string');
            $objRsmBuilder->addScalarResult('IDENTIFICACION', 'IDENTIFICACION', 'string');
            $objRsmBuilder->addScalarResult('RAZON_SOCIAL', 'RAZON_SOCIAL', 'string');
            $objRsmBuilder->addScalarResult('NOMBRE_COMERCIAL', 'NOMBRE_COMERCIAL', 'string');
            $objRsmBuilder->addScalarResult('REPRESENTANTE_LEGAL', 'REPRESENTANTE_LEGAL', 'string');
            $objRsmBuilder->addScalarResult('TIPO_COMIDA_ID', 'TIPO_COMIDA_ID', 'string');
            $objRsmBuilder->addScalarResult('DESCRIPCION_TIPO_COMIDA', 'DESCRIPCION_TIPO_COMIDA', 'string');
            $objRsmBuilder->addScalarResult('DIRECCION_TRIBUTARIO', 'DIRECCION_TRIBUTARIO', 'string');
            $objRsmBuilder->addScalarResult('URL_CATALOGO', 'URL_CATALOGO', 'string');
            $objRsmBuilder->addScalarResult('NUMERO_CONTACTO', 'NUMERO_CONTACTO', 'string');
            $objRsmBuilder->addScalarResult('ESTADO', 'ESTADO', 'string');
            $objRsmBuilderCount->addScalarResult('CANTIDAD', 'Cantidad', 'integer');
            $strSql       = $strSelect.$strFrom.$strWhere;
            $objQuery->setSQL($strSql);
            $strSqlCount  = $strSelectCount.$strFrom.$strWhere;
            $objQueryCount->setSQL($strSqlCount);
            $arrayRestaurante['cantidad']   = $objQueryCount->getSingleScalarResult();
            $arrayRestaurante['resultados'] = $objQuery->getResult();
        }
        catch(\Exception $e)
        {
            $strMensajeError = $ex->getMessage();
        }
        $arrayRestaurante['error'] = $strMensajeError;
        return $arrayRestaurante;
    }
}
