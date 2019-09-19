<?php

namespace AppBundle\Repository;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
/**
 * InfoClienteRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class InfoClienteRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Documentación para la función 'getClienteCriterio'
     * Método encargado de retornar todos los clientes según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 26-08-2019
     * 
     * @return array  $arrayCliente
     * 
     */    
    public function getClienteCriterio($arrayParametros)
    {
        $intIdCliente       = $arrayParametros['intIdCliente'] ? $arrayParametros['intIdCliente']:'';
        $strIdentificacion  = $arrayParametros['strIdentificacion'] ? $arrayParametros['strIdentificacion']:'';
        $strNombres         = $arrayParametros['strNombres'] ? $arrayParametros['strNombres']:'';
        $strApellidos       = $arrayParametros['strApellidos'] ? $arrayParametros['strApellidos']:'';
        $strEstado          = $arrayParametros['strEstado'] ? $arrayParametros['strEstado']:array('ACTIVO','INACTIVO','ELIMINADO');
        $arrayCliente       = array();
        $strMensajeError    = '';
        $objRsmBuilder      = new ResultSetMappingBuilder($this->_em);
        $objQuery           = $this->_em->createNativeQuery(null, $objRsmBuilder);
        $objRsmBuilderCount = new ResultSetMappingBuilder($this->_em);
        $objQueryCount      = $this->_em->createNativeQuery(null, $objRsmBuilderCount);
        $strOrder           = ' ORDER BY IC.NOMBRE ASC';
        try
        {
            $strSelect      = "SELECT IC.ID_CLIENTE,IC.USUARIO_ID,IC.TIPO_CLIENTE_PUNTAJE_ID, IC.IDENTIFICACION, IC.NOMBRE,IC.APELLIDO,
                                IC.CORREO,IC.DIRECCION,IC.EDAD,IC.TIPO_COMIDA,IC.GENERO,IC.ESTADO,
                                IC.USR_CREACION,IC.FE_CREACION,IC.USR_MODIFICACION,IC.FE_MODIFICACION,
                                IFNULL(SUM(ICP.CANTIDAD_PUNTOS),0) AS PUNTOS_RESTAURANTES, IFNULL(SUM(ICPG.CANTIDAD_PUNTOS),0) AS PUNTOS_GLOBALES ";
            $strSelectCount = "SELECT COUNT(*) AS CANTIDAD ";
            $strFrom        = "FROM INFO_CLIENTE IC 
                                LEFT JOIN INFO_CLIENTE_PUNTO ICP ON IC.ID_CLIENTE = ICP.CLIENTE_ID
                                LEFT JOIN INFO_CLIENTE_PUNTO_GLOBAL ICPG ON IC.ID_CLIENTE = ICPG.CLIENTE_ID ";
            $strWhere       = "WHERE IC.ESTADO in (:ESTADO) ";
            $objQuery->setParameter("ESTADO",$strEstado);
            $objQueryCount->setParameter("ESTADO",$strEstado);
            $strGroup = "GROUP BY IC.ID_CLIENTE,IC.USUARIO_ID,IC.TIPO_CLIENTE_PUNTAJE_ID, IC.IDENTIFICACION, IC.NOMBRE,IC.APELLIDO,
                            IC.CORREO,IC.DIRECCION,IC.EDAD,IC.TIPO_COMIDA,IC.GENERO,IC.ESTADO,
                            IC.USR_CREACION,IC.FE_CREACION,IC.USR_MODIFICACION,IC.FE_MODIFICACION ";
            if(!empty($intIdCliente))
            {
                $strWhere .= " AND IC.ID_CLIENTE =:intIdCliente";
                $objQuery->setParameter("intIdCliente", $intIdCliente);
                $objQueryCount->setParameter("intIdCliente", $intIdCliente);
            }
            if(!empty($strNombres))
            {
                $strWhere .= " AND lower(IC.NOMBRE) like lower(:NOMBRE)";
                $objQuery->setParameter("NOMBRE", '%' . trim($strNombres) . '%');
                $objQueryCount->setParameter("NOMBRE", '%' . trim($strNombres) . '%');
            }
            if(!empty($strApellidos))
            {
                $strWhere .= " AND lower(IC.APELLIDO) like lower(:APELLIDO)";
                $objQuery->setParameter("APELLIDO", '%' . trim($strApellidos) . '%');
                $objQueryCount->setParameter("APELLIDO", '%' . trim($strApellidos) . '%');
            }
            if(!empty($strIdentificacion))
            {
                $strWhere .= " AND IC.IDENTIFICACION =:IDENTIFICACION";
                $objQuery->setParameter("IDENTIFICACION", $strIdentificacion);
                $objQueryCount->setParameter("IDENTIFICACION", $strIdentificacion);
            }
            $objRsmBuilder->addScalarResult('ID_CLIENTE', 'ID_CLIENTE', 'string');
            $objRsmBuilder->addScalarResult('USUARIO_ID', 'USUARIO_ID', 'string');
            $objRsmBuilder->addScalarResult('TIPO_CLIENTE_PUNTAJE_ID', 'TIPO_CLIENTE_PUNTAJE_ID', 'string');
            $objRsmBuilder->addScalarResult('IDENTIFICACION', 'IDENTIFICACION', 'string');
            $objRsmBuilder->addScalarResult('NOMBRE', 'NOMBRE', 'string');
            $objRsmBuilder->addScalarResult('APELLIDO', 'APELLIDO', 'string');
            $objRsmBuilder->addScalarResult('CORREO', 'CORREO', 'string');
            $objRsmBuilder->addScalarResult('DIRECCION', 'DIRECCION', 'string');
            $objRsmBuilder->addScalarResult('EDAD', 'EDAD', 'string');
            $objRsmBuilder->addScalarResult('TIPO_COMIDA', 'TIPO_COMIDA', 'string');
            $objRsmBuilder->addScalarResult('GENERO', 'GENERO', 'string');
            $objRsmBuilder->addScalarResult('ESTADO', 'ESTADO', 'string');
            $objRsmBuilder->addScalarResult('PUNTOS_RESTAURANTES', 'PUNTOS_RESTAURANTES', 'string');
            $objRsmBuilder->addScalarResult('PUNTOS_GLOBALES', 'PUNTOS_GLOBALES', 'string');
            $objRsmBuilder->addScalarResult('USR_CREACION', 'USR_CREACION', 'string');
            $objRsmBuilder->addScalarResult('FE_CREACION', 'FE_CREACION', 'date');
            $objRsmBuilder->addScalarResult('USR_MODIFICACION', 'USR_MODIFICACION', 'string');
            $objRsmBuilder->addScalarResult('FE_MODIFICACION', 'FE_MODIFICACION', 'date');
            $objRsmBuilderCount->addScalarResult('CANTIDAD', 'Cantidad', 'integer');
            $strSql       = $strSelect.$strFrom.$strWhere.$strGroup.$strOrder;
            $objQuery->setSQL($strSql);
            $strSqlCount  = $strSelectCount.$strFrom.$strWhere;
            $objQueryCount->setSQL($strSqlCount);
            $arrayCliente['cantidad']   = $objQueryCount->getSingleScalarResult();
            $arrayCliente['resultados'] = $objQuery->getResult();
        }
        catch(\Exception $ex)
        {
            $strMensajeError = $ex->getMessage();
        }
        $arrayCliente['error'] = $strMensajeError;
        return $arrayCliente;
    }
}
