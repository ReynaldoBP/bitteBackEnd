<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\InfoUsuario;
use AppBundle\Entity\AdmiTipoRol;

class UsuarioController extends Controller
{
    /**
     * @Route("/getUsuario")
     *
     * Documentación para la función 'getUsuario'
     * Método encargado de retornar todos los usuarios según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 01-08-2019
     * 
     * @return array  $objResponse
     */
    public function getUsuarioAction(Request $request)
    {
        $strTipoRol             = $request->query->get("tipoRol") ? $request->query->get("tipoRol"):'';
        $strIdentificacion      = $request->query->get("identificacion") ? $request->query->get("identificacion"):'';
        $strNombres             = $request->query->get("nombres") ? $request->query->get("nombres"):'';
        $strApellidos           = $request->query->get("apellidos") ? $request->query->get("apellidos"):'';
        $strEstado              = $request->query->get("estado") ? $request->query->get("estado"):'';
        $arrayUsuarios          = array();
        $strMensaje             = '';
        $strStatus              = 400;
        $objResponse            = new Response;
        try
        {
            $arrayParametros = array('strTipoRol'       => $strTipoRol,
                                    'strIdentificacion' => $strIdentificacion,
                                    'strNombres'        => $strNombres,
                                    'strApellidos'      => $strApellidos,
                                    'strEstado'         => $strEstado
                                    );
            $arrayUsuarios   = $this->getDoctrine()->getRepository('AppBundle:InfoUsuario')->getUsuariosCriterio($arrayParametros);
            if(isset($arrayUsuarios['error']) && !empty($arrayUsuarios['error']))
            {
                $strMensaje = false;
                $strStatus  = 404;
            }
        }
        catch(\Exception $ex)
        {
            $strMensaje ="Fallo al realizar la búsqueda, intente nuevamente.\n ". $ex->getMessage();
        }
        $objResponse->setContent(json_encode(array(
                                            'status'    => $strStatus,
                                            'resultado' => $arrayUsuarios,
                                            'succes'    => true
                                            )
                                        ));
        $objResponse->headers->set('Access-Control-Allow-Origin', '*');
        return $objResponse;
    }
    /**
     * @Route("/createUsuario")
     *
     * Documentación para la función 'createUsuario'
     * Método encargado de crear los usuarios según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 01-08-2019
     * 
     * @return array  $objResponse
     */
    public function createUsuarioAction(Request $request)
    {
        $strTipoRol             = $request->query->get("tipoRol") ? $request->query->get("tipoRol"):'';
        $strIdentificacion      = $request->query->get("identificacion") ? $request->query->get("identificacion"):'';
        $strNombres             = $request->query->get("nombres") ? $request->query->get("nombres"):'';
        $strApellidos           = $request->query->get("apellidos") ? $request->query->get("apellidos"):'';
        $strContrasenia         = $request->query->get("contrasenia") ? $request->query->get("contrasenia"):'';
        $strImagen              = $request->query->get("imagen") ? $request->query->get("imagen"):'';
        $strCorreo              = $request->query->get("correo") ? $request->query->get("correo"):'';
        $strEstado              = $request->query->get("estado") ? $request->query->get("estado"):'';
        $strPais                = $request->query->get("pais") ? $request->query->get("pais"):'';
        $strCiudad              = $request->query->get("ciudad") ? $request->query->get("ciudad"):'';
        $strUsuarioCreacion     = $request->query->get("usuarioCreacion") ? $request->query->get("usuarioCreacion"):'';
        $strDatetimeActual      = new \DateTime('now');
        $strMensajeError        = '';
        $strStatus              = 400;
        $objResponse            = new Response;
        $strDatetimeActual      = new \DateTime('now');
        $em                     = $this->getDoctrine()->getEntityManager();
        $strDescripcion='';
        try
        {
            $arrayParametrosRol = array('ESTADO'               => $strEstado,
                                        'DESCRIPCION_TIPO_ROL' => $strTipoRol);
            $objTipoRol         = $em->getRepository('AppBundle:AdmiTipoRol')->findOneBy($arrayParametrosRol);
            if(!is_object($objTipoRol) || empty($objTipoRol))
            {
                throw new \Exception('No existe rol con la descripción enviada por parámetro.');
            }
            $objUsuario         = $em->getRepository('AppBundle:InfoUsuario')->findOneBy(array('IDENTIFICACION'=>$strIdentificacion));
            if(is_object($objUsuario) && !empty($objUsuario))
            {
                throw new \Exception('Usuario ya existente.');
            }
            $entityUsuario = new InfoUsuario();
            $entityUsuario->setTIPOROLID($objTipoRol);
            $entityUsuario->setIDENTIFICACION($strIdentificacion);
            $entityUsuario->setNOMBRES($strNombres);
            $entityUsuario->setAPELLIDOS($strApellidos);
            $entityUsuario->setCONTRASENIA($strContrasenia);
            $entityUsuario->setIMAGEN($strImagen);
            $entityUsuario->setCORREO($strCorreo);
            $entityUsuario->setESTADO($strEstado);
            $entityUsuario->setPAIS($strPais);
            $entityUsuario->setCIUDAD($strCiudad);
            $entityUsuario->setUSRCREACION($strUsuarioCreacion);
            $entityUsuario->setFECREACION($strDatetimeActual);
            $em->persist($entityUsuario);
            $em->flush();
            $strMensajeError = 'Usuario creado con exito.!';
        }
        catch(\Exception $ex)
        {
            $strStatus       = 404;
            if ($em->getConnection()->isTransactionActive())
            {
                $em->getConnection()->rollback();
                $em->getConnection()->close();
            }
            $strMensajeError = "Fallo al crear un Usuario, intente nuevamente.\n ". $ex->getMessage();
        }
        $objResponse->setContent(json_encode(array(
                                            'status'    => $strStatus,
                                            'resultado' => $strMensajeError,
                                            'succes'    => true
                                            )
                                        ));
        $objResponse->headers->set('Access-Control-Allow-Origin', '*');
        return $objResponse;
    }
    /**
     * @Route("/editUsuario")
     *
     * Documentación para la función 'editUsuario'
     * Método encargado de editar los usuarios según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 01-08-2019
     * 
     * @return array  $objResponse
     */
    public function editUsuarioAction(Request $request)
    {
        $strTipoRol             = $request->query->get("tipoRol") ? $request->query->get("tipoRol"):'';
        $strIdentificacion      = $request->query->get("identificacion") ? $request->query->get("identificacion"):'';
        $strNombres             = $request->query->get("nombres") ? $request->query->get("nombres"):'';
        $strApellidos           = $request->query->get("apellidos") ? $request->query->get("apellidos"):'';
        $strContrasenia         = $request->query->get("contrasenia") ? $request->query->get("contrasenia"):'';
        $strImagen              = $request->query->get("imagen") ? $request->query->get("imagen"):'';
        $strCorreo              = $request->query->get("correo") ? $request->query->get("correo"):'';
        $strEstado              = $request->query->get("estado") ? $request->query->get("estado"):'';
        $strPais                = $request->query->get("pais") ? $request->query->get("pais"):'';
        $strCiudad              = $request->query->get("ciudad") ? $request->query->get("ciudad"):'';
        $strUsuarioCreacion     = $request->query->get("usuarioCreacion") ? $request->query->get("usuarioCreacion"):'';
        $strDatetimeActual      = new \DateTime('now');
        $strMensajeError        = '';
        $strStatus              = 400;
        $objResponse            = new Response;
        $strDatetimeActual      = new \DateTime('now');
        $em                     = $this->getDoctrine()->getEntityManager();
        $strDescripcion='';
        try
        {
            $objUsuario = $em->getRepository('AppBundle:InfoUsuario')->findOneBy(array('IDENTIFICACION'=>$strIdentificacion));
            if(!is_object($objUsuario) || empty($objUsuario))
            {
                throw new \Exception('No existe usuario con la identificación enviada por parámetro.');
            }
            if(!empty($strTipoRol))
            {
                $arrayParametrosRol = array('ESTADO'               => $strEstado,
                                            'DESCRIPCION_TIPO_ROL' => $strTipoRol);
                $objTipoRol         = $em->getRepository('AppBundle:AdmiTipoRol')->findOneBy($arrayParametrosRol);
                if(!is_object($objTipoRol) || empty($objTipoRol))
                {
                    throw new \Exception('No existe rol con la descripción enviada por parámetro.');
                }
                $objUsuario->setTIPOROLID($objTipoRol);
            }
            if(!empty($strNombres))
            {
                $objUsuario->setNOMBRES($strNombres);
            }
            if(!empty($strApellidos))
            {
                $objUsuario->setAPELLIDOS($strApellidos);
            }
            if(!empty($strContrasenia))
            {
                $objUsuario->setCONTRASENIA($strContrasenia);
            }
            if(!empty($strImagen))
            {
                $objUsuario->setIMAGEN($strImagen);
            }
            if(!empty($strCorreo))
            {
                $objUsuario->setCORREO($strCorreo);
            }
            if(!empty($strEstado))
            {
                $objUsuario->setESTADO($strEstado);
            }
            if(!empty($strPais))
            {
                $objUsuario->setPAIS($strPais);
            }
            if(!empty($strCiudad))
            {
                $objUsuario->setCIUDAD($strCiudad);
            }
            $objUsuario->setUSRMODIFICACION($strUsuarioCreacion);
            $objUsuario->setFEMODIFICACION($strDatetimeActual);
            $em->persist($objUsuario);
            $em->flush();
            $strMensajeError = 'Usuario editado con exito.!';
            if ($em->getConnection()->isTransactionActive())
            {
                $em->getConnection()->commit();
                $em->getConnection()->close();
            }
        }
        catch(\Exception $ex)
        {
            $strStatus       = 404;
            if ($em->getConnection()->isTransactionActive())
            {
                $em->getConnection()->rollback();
                $em->getConnection()->close();
            }
            $strMensajeError = "Fallo al editar un Usuario, intente nuevamente.\n ". $ex->getMessage();
        }
        $objResponse->setContent(json_encode(array(
                                            'status'    => $strStatus,
                                            'resultado' => $strMensajeError,
                                            'succes'    => true
                                            )
                                        ));
        $objResponse->headers->set('Access-Control-Allow-Origin', '*');
        return $objResponse;
    }
    
    /**
     * @Route("/getLogin")
     *
     * Documentación para la función 'editUsuario'
     * Método encargado de editar los usuarios según los parámetros recibidos.
     * 
     * @author Kevin Baque
     * @version 1.0 01-08-2019
     * 
     * @return array  $objResponse
     */
    public function getLoginAction(Request $request)
    {
        $strCorreo              = $request->query->get("correo") ? $request->query->get("correo"):'';
        $strPass                = $request->query->get("contrasenia") ? $request->query->get("contrasenia"):'';
        $arrayUsuarios          = array();
        $strMensaje             = true;
        $strStatus              = 400;
        $strSucces              = true;
        $objResponse            = new Response;
        try
        {
            $objUsuario   = $this->getDoctrine()->getRepository('AppBundle:InfoUsuario')->findBy(array('CORREO'      => $strCorreo,
                                                                                                       'CONTRASENIA' => $strPass));
            if(empty($objUsuario))
            {
                $strStatus  = 404;
                $strSucces  = false;
                throw new \Exception('Usuario no existe.');
            }
            foreach($objUsuario as $objItemUsuario)
            {
                $arrayUsuarios [] = array(
                                            'IDENTIFICACION' => $objItemUsuario->getIDENTIFICACION(),
                                            'NOMBRES'        => $objItemUsuario->getNOMBRES(),
                                            'APELLIDOS'      => $objItemUsuario->getAPELLIDOS(),
                                            'IMAGEN'         => $objItemUsuario->getIMAGEN(),
                                            'CORREO'         => $objItemUsuario->getCORREO(),
                                            'TIPOROLID'      => $objItemUsuario->getTIPOROLID()->getDESCRIPCION_TIPO_ROL(),
                                            'ESTADO'         => $objItemUsuario->getESTADO(),
                                            'PAIS'           => $objItemUsuario->getPAIS(),
                                            'CIUDAD'         => $objItemUsuario->getCIUDAD(),
                                            'USRCREACION'    => $objItemUsuario->getUSRCREACION(),
                                            'FECREACION'     => $objItemUsuario->getFECREACION()
                                            );
            }
        }
        catch(\Exception $ex)
        {
            $strMensaje = $ex->getMessage();
        }
        $objResponse->setContent(json_encode(array(
                                            'status'    => $strStatus,
                                            'resultado' => $arrayUsuarios,
                                            'succes'    => $strSucces
                                            )
                                        ));
        $objResponse->headers->set('Access-Control-Allow-Origin', '*');
        return $objResponse;
    }

    /**
     * @Route("/generarContrasenia")
     *
     * Documentación para la función 'generarContrasenia'
     * Método encargado de generar las contraseñas a todos los usuarios.
     * 
     * @author Kevin Baque
     * @version 1.0 01-08-2019
     * 
     * @return array  $objResponse
     */
    public function generarContraseniaAction()
    {
        $strCorreo        = 'baquekevin@hotmail.com';//$request->query->get("correo") ? $request->query->get("correo"):'baquekevin@hotmail.com';
        $strMensaje       = '';
        $email_address    = $strCorreo;
        $strStatus        = 400;
        $objResponse      = new Response;
        $strClavetemporal = 'asd';
        try
        {
            $to = $strCorreo;
            $email_subject = "Clave temporal Bitte";
            $email_body = "Tu clave temporal es : ";
            $headers = "From: georgerichardd@hotmail.com";
            //$headers .= "Reply-To: $strCorreo";
            mail($to, $email_subject, $email_body, $headers);
            /*$to = "baquekevin@hotmail.com";
            $subject = "Asunto del email";
            $message = "Este es mi primer envío de email con PHP";
            mail($to, $subject, $message);*/
        }
        catch(\Exception $ex)
        {
            $strStatus       = 404;
            $strMensaje = "Fallo al generar contraseña, intente nuevamente.\n ". $ex->getMessage();
        }
        $objResponse->setContent(json_encode(array(
                                            'status'    => $strStatus,
                                            'resultado' => $strMensaje,
                                            'succes'    => true
                                            )
                                        ));
        $objResponse->headers->set('Access-Control-Allow-Origin', '*');
        return $objResponse;
    }
    
    /**
     * @Route("/generarPass")
     *
     * Documentación para la función 'generarPass'
     * Método encargado de generar las contraseñas a todos los usuarios.
     *
     * @author Kevin Baque
     * @version 1.0 01-08-2019
     *
     * @return array  $objResponse
     */
    public function generarPassAction()
    {
        $strAsunto        = 'Clave temporal Bitte';
        $strMensajeCorreo = 'Tu clave temporal es :';
        $strRemitente     = 'baquekevin@hotmail.com';
        $strCorreo        = 'baquekevin@hotmail.com';
        $objResponse      = new Response;
        $objMessage = \Swift_Message::newInstance()
        ->setSubject($strAsunto)
        ->setFrom('notificaciones_telcos@telconet.ec')
        ->setTo($strCorreo)
        ->setBody($strMensajeCorreo, 'text/html');
        $respuesta = $this->get('mailer')->send($objMessage);
        $objResponse->setContent(json_encode(array(
                                            'status'    => 200,
                                            'resultado' => $respuesta,
                                            'succes'    => true
                                            )
                                        ));
        $objResponse->headers->set('Access-Control-Allow-Origin', '*');
        return $objResponse;
    }
    /**
     * @Route("/generarPass")
     *
     * Documentación para la función 'generarPass'
     * Método encargado de generar las contraseñas a todos los usuarios.
     * 
     * @author Kevin Baque
     * @version 1.0 01-08-2019
     * 
     * @return array  $objResponse
     */
    public function generarPassPruebaAction()
    {
        try
        {
            $strStatus        = 400;
            $objResponse      = new Response;
            $strMensaje       = 'ok';
            $strAsunto        = 'Clave temporal Bitte';
            $strMensajeCorreo = 'Tu clave temporal es :';
            $strRemitente     = 'baquekevin@hotmail.com';
            $strCorreo        = 'baquekevin@hotmail.com';
            include_once "swift_required.php";
            $transport = Swift_SmtpTransport::newInstance('smtp.mailtrap.io', 25)
                                ->setUsername('58e18a743e44f1')
                                ->setPassword('c362f862d245c4');
            $mailer = Swift_Mailer::newInstance($transport);
            /*$message = Swift_Message::newInstance('Hola')
                                ->setFrom($strRemitente)
                                ->setTo($strCorreo)
                                ->setBody($strMensajeCorreo, 'text/html');
            $mailer->send($message);*/
            /*------------------------------------------- */
            $message = \Swift_Message::newInstance()
                                        ->setSubject($strAsunto)
                                        ->setFrom($strRemitente)
                                        ->setTo($strCorreo)
                                        ->setBody($strMensajeCorreo, 'text/html');
            $mailer->send($message);
            /*------------------------------------------- */
            /*$transport = (new Swift_SmtpTransport('smtp.mailtrap.io', 2525))
                            ->setUsername('950ef3a975634d')
                            ->setPassword('3c99a3ebfa827f');
            $mailer = new Swift_Mailer($transport);
            $message = (new Swift_Message($strAsunto))
            ->setFrom($strCorreo)
            ->setTo($strCorreo)
            ->setBody('Here is the message itself');
            $mailer->send($message);*/
            /*------------------------------------------- */
            /*$message = \Swift_Message::newInstance()
                                        ->setSubject($strAsunto)
                                        ->setFrom($strRemitente)
                                        ->setTo($strCorreo)
                                        ->setBody($strMensajeCorreo, 'text/html');*/
            
        }
        catch(\Exception $ex)
        {
            $strStatus       = 404;
            $strMensaje = "Fallo al generar contraseña, intente nuevamente.\n ". $ex->getMessage();
        }
        $objResponse->setContent(json_encode(array(
                                            'status'    => $strStatus,
                                            'resultado' => '',
                                            'succes'    => true
                                            )
                                        ));
        $objResponse->headers->set('Access-Control-Allow-Origin', '*');
        return $objResponse;
    }

}
