<?php

namespace AppBundle\Repository;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
/**
 * InfoVistaPublicidadRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class InfoVistaPublicidadRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Documentación para la función 'getVistasPublicidades'
     * Método encargado de retornar todos las vistas de las publicidades.
     * 
     * @author Kevin Baque
     * @version 1.0 17-11-2019
     * 
     * @return array  $arrayCliente
     * 
     */    
    public function getVistasPublicidades($arrayParametros)
    {
        $strGenero          = $arrayParametros['strGenero'] ? $arrayParametros['strGenero']:'';
        $strEdad            = $arrayParametros['strEdad'] ? $arrayParametros['strEdad']:'';
        $strGlobal          = $arrayParametros['strGlobal'] ? $arrayParametros['strGlobal']:'';
        $arrayCliente       = array();
        $strMensajeError    = '';
        $objRsmBuilder      = new ResultSetMappingBuilder($this->_em);
        $objQuery           = $this->_em->createNativeQuery(null, $objRsmBuilder);
        $strOrder           = ' ORDER BY IC.NOMBRE ASC';
        try
        {
            $strSelect      = "SELECT IP.ID_PUBLICIDAD,
                                IP.DESCRIPCION,
                                COUNT(*) AS VISTAS ";
            $strFrom        = "FROM INFO_VISTA_PUBLICIDAD IVP
                                INNER JOIN INFO_PUBLICIDAD IP ON IVP.PUBLICIDAD_ID = IP.ID_PUBLICIDAD
                                INNER JOIN INFO_RESTAURANTE IR ON IR.ID_RESTAURANTE = IVP.RESTAURANTE_ID
                                INNER JOIN INFO_CLIENTE IC ON IC.ID_CLIENTE = IVP.CLIENTE_ID
                                INNER JOIN ADMI_PARAMETRO AP_EDAD    ON AP_EDAD.DESCRIPCION     = 'EDAD'
                                                                    AND EXTRACT(YEAR FROM IC.EDAD) >= AP_EDAD.VALOR2
                                                                    AND EXTRACT(YEAR FROM IC.EDAD) <= AP_EDAD.VALOR3 ";
            if(!empty($strGenero) && $strGenero=='SI')
            {
                $strSelect .= " ,IC.GENERO AS CRITERIO ";
                $objRsmBuilder->addScalarResult('CRITERIO', 'CRITERIO', 'string');
                $strGroup = " GROUP BY IVP.PUBLICIDAD_ID,CRITERIO ";
            }
            if(!empty($strEdad) && $strEdad=='SI')
            {
                $strSelect .= " ,AP.VALOR1 AS CRITERIO ";
                $objRsmBuilder->addScalarResult('CRITERIO', 'CRITERIO', 'string');
                $strGroup = " GROUP BY IVP.PUBLICIDAD_ID,CRITERIO ";
            }
            if(!empty($strGroup) && $strGroup=='SI')
            {
                $strGroup = " GROUP BY IVP.PUBLICIDAD_ID ";
            }
            $objRsmBuilder->addScalarResult('ID_PUBLICIDAD', 'ID_PUBLICIDAD', 'string');
            $objRsmBuilder->addScalarResult('DESCRIPCION', 'DESCRIPCION', 'string');
            $objRsmBuilder->addScalarResult('VISTAS', 'VISTAS', 'string');
            $strSql       = $strSelect.$strFrom.$strGroup;
            $objQuery->setSQL($strSql);
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
