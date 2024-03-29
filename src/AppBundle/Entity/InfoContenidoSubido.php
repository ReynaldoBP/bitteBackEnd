<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InfoContenidoSubido
 *
 * @ORM\Table(name="INFO_CONTENIDO_SUBIDO")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InfoContenidoSubidoRepository")
 */
class InfoContenidoSubido
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_CONTENIDO_SUBIDO", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
    * @var InfoCliente
    *
    * @ORM\ManyToOne(targetEntity="InfoCliente")
    * @ORM\JoinColumns({
    * @ORM\JoinColumn(name="CLIENTE_ID", referencedColumnName="ID_CLIENTE")
    * })
    */
    private $CLIENTE_ID;

    /**
    * @var InfoRedesSociales
    *
    * @ORM\ManyToOne(targetEntity="InfoRedesSociales")
    * @ORM\JoinColumns({
    * @ORM\JoinColumn(name="REDES_SOCIALES_ID", referencedColumnName="ID_REDES_SOCIALES")
    * })
    */
    private $REDES_SOCIALES_ID;

    /**
     * @var string
     *
     * @ORM\Column(name="DESCRIPCION", type="string", length=255, nullable=true)
     */
    private $DESCRIPCION;

    /**
     * @var string
     *
     * @ORM\Column(name="IMAGEN", type="string", length=450)
     */
    private $IMAGEN;

    /**
     * @var int
     *
     * @ORM\Column(name="CANTIDAD_PUNTOS", type="integer")
     */
    private $CANTIDADPUNTOS;

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
     * @return InfoContenidoSubido
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
     * Set IMAGEN
     *
     * @param string $IMAGEN
     *
     * @return InfoContenidoSubido
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
     * Set ESTADO
     *
     * @param string $ESTADO
     *
     * @return InfoContenidoSubido
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
     * @return InfoContenidoSubido
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
     * @return InfoContenidoSubido
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
     * @return InfoContenidoSubido
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
     * @return InfoContenidoSubido
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
     * Set CLIENTEID
     *
     * @param \AppBundle\Entity\InfoCliente $CLIENTEID
     *
     * @return InfoContenidoSubido
     */
    public function setCLIENTEID(\AppBundle\Entity\InfoCliente $CLIENTEID = null)
    {
        $this->CLIENTE_ID = $CLIENTEID;

        return $this;
    }

    /**
     * Get CLIENTEID
     *
     * @return \AppBundle\Entity\InfoCliente
     */
    public function getCLIENTEID()
    {
        return $this->CLIENTE_ID;
    }

    /**
     * Set REDESSOCIALESID
     *
     * @param \AppBundle\Entity\InfoRedesSociales $REDESSOCIALESID
     *
     * @return InfoContenidoSubido
     */
    public function setREDESSOCIALESID(\AppBundle\Entity\InfoRedesSociales $REDESSOCIALESID = null)
    {
        $this->REDES_SOCIALES_ID = $REDESSOCIALESID;

        return $this;
    }

    /**
     * Get REDESSOCIALESID
     *
     * @return \AppBundle\Entity\InfoRedesSociales
     */
    public function getREDESSOCIALESID()
    {
        return $this->REDES_SOCIALES_ID;
    }

    /**
     * Set cANTIDADPUNTOS
     *
     * @param integer $cANTIDADPUNTOS
     *
     * @return InfoContenidoSubido
     */
    public function setCANTIDADPUNTOS($cANTIDADPUNTOS)
    {
        $this->CANTIDADPUNTOS = $cANTIDADPUNTOS;

        return $this;
    }

    /**
     * Get cANTIDADPUNTOS
     *
     * @return integer
     */
    public function getCANTIDADPUNTOS()
    {
        return $this->CANTIDADPUNTOS;
    }
}
