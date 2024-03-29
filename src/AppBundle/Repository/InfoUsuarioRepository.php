<?php

namespace AppBundle\Repository;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

/**
 * InfoUsuarioRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class InfoUsuarioRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Documentación para la función 'getUsuariosCriterio'
     * Método encargado de retornar todos los usuarios según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 16-07-2019
     * 
     * @author Kevin Baque
     * @version 1.1 10-11-2019 Se agrega filtro por restaurante.
     *
     * @return array  $arrayUsuarios
     * 
     */    
    public function getUsuariosCriterio($arrayParametros)
    {
        $intIdRestaurante   = $arrayParametros['intIdRestaurante'] ? $arrayParametros['intIdRestaurante']:'';
        $intIdUsuario       = $arrayParametros['intIdUsuario'] ? $arrayParametros['intIdUsuario']:'';
        $strTipoRol         = $arrayParametros['strTipoRol'] ? $arrayParametros['strTipoRol']:'';
        $strIdentificacion  = $arrayParametros['strIdentificacion'] ? $arrayParametros['strIdentificacion']:'';
        $strNombres         = $arrayParametros['strNombres'] ? $arrayParametros['strNombres']:'';
        $strApellidos       = $arrayParametros['strApellidos'] ? $arrayParametros['strApellidos']:'';
        $strEstado          = $arrayParametros['strEstado'] ? $arrayParametros['strEstado']:array('ACTIVO','INACTIVO','ELIMINADO');
        $strTipoRolRes      = $arrayParametros['strTipoRolRes'] ? $arrayParametros['strTipoRolRes']:'';
        $arrayUsuarios      = array();
        $strMensajeError    = '';
        $objRsmBuilder      = new ResultSetMappingBuilder($this->_em);
        $objQuery           = $this->_em->createNativeQuery(null, $objRsmBuilder);
        $objRsmBuilderCount = new ResultSetMappingBuilder($this->_em);
        $objQueryCount      = $this->_em->createNativeQuery(null, $objRsmBuilderCount);
        try
        {
            $strSelect      = "SELECT IU.ID_USUARIO,IU.NOMBRES,IU.APELLIDOS,IU.CONTRASENIA, IU.IDENTIFICACION, IU.CORREO,IU.TIPO_ROL_ID,
                               IU.ESTADO,IU.PAIS,IU.CIUDAD,IU.USR_CREACION,IU.FE_CREACION,IU.USR_MODIFICACION,IU.FE_MODIFICACION,
                               ATR.DESCRIPCION_TIPO_ROL,ATR.ID_TIPO_ROL ";
            $strSelectCount = "SELECT COUNT(*) AS CANTIDAD ";
            $strFrom        = "FROM INFO_USUARIO IU 
                               JOIN ADMI_TIPO_ROL ATR ON IU.TIPO_ROL_ID=ATR.ID_TIPO_ROL ";
            $strWhere       = "WHERE IU.ESTADO in (:ESTADO) ";
            $objQuery->setParameter("ESTADO",$strEstado);
            $objQueryCount->setParameter("ESTADO",$strEstado);
            if(!empty($intIdRestaurante))
            {
                $strFrom .= " JOIN INFO_USUARIO_RES IURES ON IURES.USUARIO_ID = IU.ID_USUARIO ";
                $strWhere .= " AND IURES.RESTAURANTE_ID =:RESTAURANTE_ID ";
                $objQuery->setParameter("RESTAURANTE_ID", $intIdRestaurante);
                $objQueryCount->setParameter("RESTAURANTE_ID", $intIdRestaurante);
            }
            if(!empty($intIdUsuario))
            {
                $strWhere .= " AND IU.ID_USUARIO =:intIdUsuario";
                $objQuery->setParameter("intIdUsuario", $intIdUsuario);
                $objQueryCount->setParameter("intIdUsuario", $intIdUsuario);
            }
            if(!empty($strNombres))
            {
                $strWhere .= " AND lower(IU.NOMBRES) like lower(:NOMBRES)";
                $objQuery->setParameter("NOMBRES", '%' . trim($strNombres) . '%');
                $objQueryCount->setParameter("NOMBRES", '%' . trim($strNombres) . '%');
            }
            if(!empty($strApellidos))
            {
                $strWhere .= " AND lower(IU.APELLIDOS) like lower(:APELLIDOS)";
                $objQuery->setParameter("APELLIDOS", '%' . trim($strApellidos) . '%');
                $objQueryCount->setParameter("APELLIDOS", '%' . trim($strApellidos) . '%');
            }
            if(!empty($strIdentificacion))
            {
                $strWhere .= " AND IU.IDENTIFICACION =:IDENTIFICACION";
                $objQuery->setParameter("IDENTIFICACION", $strIdentificacion);
                $objQueryCount->setParameter("IDENTIFICACION", $strIdentificacion);
            }
            if(!empty($strTipoRol))
            {
                $strWhere  .= " AND ATR.ID_TIPO_ROL = :ID_TIPO_ROL";
                $objQuery->setParameter("ID_TIPO_ROL", $strTipoRol);
                $objQueryCount->setParameter("ID_TIPO_ROL", $strTipoRol);
            }
            if(!empty($strTipoRolRes) && $strTipoRolRes=='RESTAURANTE')
            {
                $strSelect .= " ,IRES.NOMBRE_COMERCIAL ";
                $strFrom   .= " JOIN INFO_USUARIO_RES IURES ON IURES.USUARIO_ID = IU.ID_USUARIO 
                                JOIN INFO_RESTAURANTE IRES ON IURES.RESTAURANTE_ID = IRES.ID_RESTAURANTE ";
                $objRsmBuilder->addScalarResult('NOMBRE_COMERCIAL', 'NOMBRE_COMERCIAL', 'string');
            }

            $objRsmBuilder->addScalarResult('ID_USUARIO', 'ID_USUARIO', 'string');
            $objRsmBuilder->addScalarResult('NOMBRES', 'NOMBRES', 'string');
            $objRsmBuilder->addScalarResult('APELLIDOS', 'APELLIDOS', 'string');
            $objRsmBuilder->addScalarResult('CONTRASENIA', 'CONTRASENIA', 'string');
            $objRsmBuilder->addScalarResult('IDENTIFICACION', 'IDENTIFICACION', 'string');
            $objRsmBuilder->addScalarResult('CORREO', 'CORREO', 'string');
            $objRsmBuilder->addScalarResult('TIPO_ROL_ID', 'TIPO_ROL_ID', 'string');
            $objRsmBuilder->addScalarResult('ESTADO', 'ESTADO', 'string');
            $objRsmBuilder->addScalarResult('PAIS', 'PAIS', 'string');
            $objRsmBuilder->addScalarResult('CIUDAD', 'CIUDAD', 'string');
            $objRsmBuilder->addScalarResult('USR_CREACION', 'USR_CREACION', 'string');
            $objRsmBuilder->addScalarResult('FE_CREACION', 'FE_CREACION', 'date');
            $objRsmBuilder->addScalarResult('USR_MODIFICACION', 'USR_MODIFICACION', 'string');
            $objRsmBuilder->addScalarResult('FE_MODIFICACION', 'FE_MODIFICACION', 'date');
            $objRsmBuilder->addScalarResult('DESCRIPCION_TIPO_ROL', 'DESCRIPCION_TIPO_ROL', 'string');
            $objRsmBuilder->addScalarResult('ID_TIPO_ROL', 'ID_TIPO_ROL', 'string');
            $objRsmBuilderCount->addScalarResult('CANTIDAD', 'Cantidad', 'integer');
            $strSql       = $strSelect.$strFrom.$strWhere;
            $objQuery->setSQL($strSql);
            $strSqlCount  = $strSelectCount.$strFrom.$strWhere;
            $objQueryCount->setSQL($strSqlCount);
            $arrayUsuarios['cantidad']   = $objQueryCount->getSingleScalarResult();
            $arrayUsuarios['resultados'] = $objQuery->getResult();
        }
        catch(\Exception $ex)
        {
            $strMensajeError = $ex->getMessage();
        }
        $arrayUsuarios['error'] = $strMensajeError;
        return $arrayUsuarios;
    }
}
