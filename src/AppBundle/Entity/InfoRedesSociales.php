<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InfoRedesSociales
 *
 * @ORM\Table(name="INFO_REDES_SOCIALES")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InfoRedesSocialesRepository")
 */
class InfoRedesSociales
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_REDES_SOCIALES", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
    * @var InfoContenidoSubido
    *
    * @ORM\ManyToOne(targetEntity="InfoContenidoSubido")
    * @ORM\JoinColumns({
    * @ORM\JoinColumn(name="CONTENIDO_SUBIDO_ID", referencedColumnName="ID_CONTENIDO_SUBIDO")
    * })
    */
    private $CONTENIDO_SUBIDO_ID;

    /**
     * @var string
     *
     * @ORM\Column(name="DESCRIPCION", type="string", length=255, nullable=true)
     */
    private $DESCRIPCION;

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
    private $USRCREACION;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="FE_CREACION", type="date")
     */
    private $FECREACION;

    /**
     * @var string
     *
     * @ORM\Column(name="USR_MODIFICACION", type="string", length=255, nullable=true)
     */
    private $USRMODIFICACION;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="FE_MODIFICACION", type="date", nullable=true)
     */
    private $FEMODIFICACION;

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
     * Set DESCRIPCION
     *
     * @param string $DESCRIPCION
     *
     * @return InfoRedesSociales
     */
    public function setDESCRIPCION($DESCRIPCION)
    {
        $this->DESCRIPCION = $DESCRIPCION;

        return $this;
    }

    /**
     * Get DESCRIPCION
     *
     * @return string
     */
    public function getDESCRIPCION()
    {
        return $this->DESCRIPCION;
    }

    /**
     * Set ESTADO
     *
     * @param string $ESTADO
     *
     * @return InfoRedesSociales
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
     * @return InfoRedesSociales
     */
    public function setUSRCREACION($USRCREACION)
    {
        $this->USRCREACION = $USRCREACION;

        return $this;
    }

    /**
     * Get USRCREACION
     *
     * @return string
     */
    public function getUSRCREACION()
    {
        return $this->USRCREACION;
    }

    /**
     * Set FECREACION
     *
     * @param \DateTime $FECREACION
     *
     * @return InfoRedesSociales
     */
    public function setFECREACION($FECREACION)
    {
        $this->FECREACION = $FECREACION;

        return $this;
    }

    /**
     * Get FECREACION
     *
     * @return \DateTime
     */
    public function getFECREACION()
    {
        return $this->FECREACION;
    }

    /**
     * Set USRMODIFICACION
     *
     * @param string $USRMODIFICACION
     *
     * @return InfoRedesSociales
     */
    public function setUSRMODIFICACION($USRMODIFICACION)
    {
        $this->USRMODIFICACION = $USRMODIFICACION;

        return $this;
    }

    /**
     * Get USRMODIFICACION
     *
     * @return string
     */
    public function getUSRMODIFICACION()
    {
        return $this->USRMODIFICACION;
    }

    /**
     * Set FEMODIFICACION
     *
     * @param \DateTime $FEMODIFICACION
     *
     * @return InfoRedesSociales
     */
    public function setFEMODIFICACION($FEMODIFICACION)
    {
        $this->FEMODIFICACION = $FEMODIFICACION;

        return $this;
    }

    /**
     * Get FEMODIFICACION
     *
     * @return \DateTime
     */
    public function getFEMODIFICACION()
    {
        return $this->FEMODIFICACION;
    }

    /**
     * Set CONTENIDOSUBIDOID
     *
     * @param \AppBundle\Entity\InfoContenidoSubido $CONTENIDOSUBIDOID
     *
     * @return InfoRedesSociales
     */
    public function setCONTENIDOSUBIDOID(\AppBundle\Entity\InfoContenidoSubido $CONTENIDOSUBIDOID = null)
    {
        $this->CONTENIDO_SUBIDO_ID = $CONTENIDOSUBIDOID;

        return $this;
    }

    /**
     * Get CONTENIDOSUBIDOID
     *
     * @return \AppBundle\Entity\InfoContenidoSubido
     */
    public function getCONTENIDOSUBIDOID()
    {
        return $this->CONTENIDO_SUBIDO_ID;
    }
}