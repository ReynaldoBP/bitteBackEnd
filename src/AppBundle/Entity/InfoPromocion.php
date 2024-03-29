<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InfoPromocion
 *
 * @ORM\Table(name="INFO_PROMOCION")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InfoPromocionRepository")
 */
class InfoPromocion
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_PROMOCION", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="IMAGEN", type="string", length=400)
     */
    private $IMAGEN;

    /**
    * @var InfoRestaurante
    *
    * @ORM\ManyToOne(targetEntity="InfoRestaurante")
    * @ORM\JoinColumns({
    * @ORM\JoinColumn(name="RESTAURANTE_ID", referencedColumnName="ID_RESTAURANTE")
    * })
    */
    private $RESTAURANTE_ID;

    /**
     * @var string
     *
     * @ORM\Column(name="DESCRIPCION_TIPO_PROMOCION", type="string", length=255)
     */
    private $DESCRIPCIONTIPOPROMOCION;

    /**
     * @var string
     *
     * @ORM\Column(name="PREMIO", type="string", length=2)
     */
    private $PREMIO;

    /**
     * @var int
     *
     * @ORM\Column(name="CANTIDAD_PUNTOS", type="integer", nullable=true)
     */
    private $CANTIDADPUNTOS;

    /**
     * @var string
     *
     * @ORM\Column(name="ACEPTA_GLOBAL", type="string", length=50)
     */
    private $ACEPTAGLOBAL;

    /**
     * @var string
     *
     * @ORM\Column(name="ESTADO", type="string", length=100)
     */
    private $ESTADO;

    /**
     * @var string
     *
     * @ORM\Column(name="USR_CREACION", type="string", length=255)
     */
    private $USR_CREACION;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="FE_CREACION", type="date")
     */
    private $FE_CREACION;

    /**
     * @var string
     *
     * @ORM\Column(name="USR_MODIFICACION", type="string", length=255, nullable=true)
     */
    private $USR_MODIFICACION;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="FE_MODIFICACION", type="date", nullable=true)
     */
    private $FE_MODIFICACION;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set DESCRIPCIONTIPOPROMOCION
     *
     * @param string $DESCRIPCIONTIPOPROMOCION
     *
     * @return InfoPromocion
     */
    public function setDESCRIPCIONTIPOPROMOCION($DESCRIPCIONTIPOPROMOCION)
    {
        $this->DESCRIPCIONTIPOPROMOCION = $DESCRIPCIONTIPOPROMOCION;

        return $this;
    }

    /**
     * Get DESCRIPCIONTIPOPROMOCION
     *
     * @return string
     */
    public function getDESCRIPCIONTIPOPROMOCION()
    {
        return $this->DESCRIPCIONTIPOPROMOCION;
    }

    /**
     * Set CANTIDADPUNTOS
     *
     * @param integer $CANTIDADPUNTOS
     *
     * @return InfoPromocion
     */
    public function setCANTIDADPUNTOS($CANTIDADPUNTOS)
    {
        $this->CANTIDADPUNTOS = $CANTIDADPUNTOS;

        return $this;
    }

    /**
     * Get CANTIDADPUNTOS
     *
     * @return int
     */
    public function getCANTIDADPUNTOS()
    {
        return $this->CANTIDADPUNTOS;
    }

    /**
     * Set ACEPTAGLOBAL
     *
     * @param string $ACEPTAGLOBAL
     *
     * @return InfoPromocion
     */
    public function setACEPTAGLOBAL($ACEPTAGLOBAL)
    {
        $this->ACEPTAGLOBAL = $ACEPTAGLOBAL;

        return $this;
    }

    /**
     * Get ACEPTAGLOBAL
     *
     * @return string
     */
    public function getACEPTAGLOBAL()
    {
        return $this->ACEPTAGLOBAL;
    }

    /**
     * Set ESTADO
     *
     * @param string $ESTADO
     *
     * @return InfoPromocion
     */
    public function setESTADO($ESTADO)
    {
        $this->ESTADO = $ESTADO;

        return $this;
    }

    /**
     * Get ESTADO
     *
     * @return string
     */
    public function getESTADO()
    {
        return $this->ESTADO;
    }

    /**
     * Set USRCREACION
     *
     * @param string $USRCREACION
     *
     * @return InfoPromocion
     */
    public function setUSRCREACION($USRCREACION)
    {
        $this->USR_CREACION = $USRCREACION;

        return $this;
    }

    /**
     * Get USRCREACION
     *
     * @return string
     */
    public function getUSRCREACION()
    {
        return $this->USR_CREACION;
    }

    /**
     * Set FECREACION
     *
     * @param \DateTime $FECREACION
     *
     * @return InfoPromocion
     */
    public function setFECREACION($FECREACION)
    {
        $this->FE_CREACION = $FECREACION;

        return $this;
    }

    /**
     * Get FECREACION
     *
     * @return \DateTime
     */
    public function getFECREACION()
    {
        return $this->FE_CREACION;
    }

    /**
     * Set USRMODIFICACION
     *
     * @param string $USRMODIFICACION
     *
     * @return InfoPromocion
     */
    public function setUSRMODIFICACION($USRMODIFICACION)
    {
        $this->USR_MODIFICACION = $USRMODIFICACION;

        return $this;
    }

    /**
     * Get USRMODIFICACION
     *
     * @return string
     */
    public function getUSRMODIFICACION()
    {
        return $this->USR_MODIFICACION;
    }

    /**
     * Set FEMODIFICACION
     *
     * @param \DateTime $FEMODIFICACION
     *
     * @return InfoPromocion
     */
    public function setFEMODIFICACION($FEMODIFICACION)
    {
        $this->FE_MODIFICACION = $FEMODIFICACION;

        return $this;
    }

    /**
     * Get FEMODIFICACION
     *
     * @return \DateTime
     */
    public function getFEMODIFICACION()
    {
        return $this->FE_MODIFICACION;
    }

    /**
     * Set IMAGEN
     *
     * @param string $IMAGEN
     *
     * @return InfoPromocion
     */
    public function setIMAGEN($IMAGEN)
    {
        $this->IMAGEN = $IMAGEN;

        return $this;
    }

    /**
     * Get IMAGEN
     *
     * @return string
     */
    public function getIMAGEN()
    {
        return $this->IMAGEN;
    }

    /**
     * Set PREMIO
     *
     * @param string $PREMIO
     *
     * @return InfoPromocion
     */
    public function setPREMIO($PREMIO)
    {
        $this->PREMIO = $PREMIO;

        return $this;
    }

    /**
     * Get PREMIO
     *
     * @return string
     */
    public function getPREMIO()
    {
        return $this->PREMIO;
    }

    /**
     * Set RESTAURANTEID
     *
     * @param \AppBundle\Entity\InfoRestaurante $RESTAURANTEID
     *
     * @return InfoPromocion
     */
    public function setRESTAURANTEID(\AppBundle\Entity\InfoRestaurante $RESTAURANTEID = null)
    {
        $this->RESTAURANTE_ID = $RESTAURANTEID;

        return $this;
    }

    /**
     * Get RESTAURANTEID
     *
     * @return \AppBundle\Entity\InfoRestaurante
     */
    public function getRESTAURANTEID()
    {
        return $this->RESTAURANTE_ID;
    }
}
