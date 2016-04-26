<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_model('tarea_agenda.php');
/**
 * Description of agenda_inicio
 *
 * @author Administrador
 */
class agenda_inicio extends fs_controller
{
    public $listado;
    public $editar;
    public $tarea_agenda;


    public function __construct() {
        parent::__construct(__CLASS__, 'Portada', 'Agenda');
    }

    protected function private_core() {

        $this->tarea_agenda = new tarea_agenda();
        $completado = FALSE;
        $this->editar= FALSE;
        $this->listado= $this->tarea_agenda->all();


        if (isset($_POST['modificar'])) /// Editar Tarea
        {
         $this->tarea_agenda->id = $_POST['modificar'];
         $this->editar = $this->tarea_agenda->get($_POST['modificar']);
         if ($this->editar)
         {
          $this->tarea_agenda->fecha= $_POST['fecha'].' '.$_POST['hora'];
          $this->tarea_agenda->completado = isset($_POST['completado']);
          $this->tarea_agenda->tarea= $_POST['tarea'];
          $this->tarea_agenda->usuario= $_POST['usuario'];

            if ($this->tarea_agenda->save())
                {
                    $this->new_message('Datos Modificados Correctamante');

                }
                else
                {
                    $this->new_error_msg('Error al Modificar');
                }
         }
        }
        else if (isset($_POST['fecha'])) ///Nueva Tarea
            {
            $this->tarea_agenda->fecha = $_POST['fecha'].' '.$_POST['hora'];
            $this->tarea_agenda->tarea = $_POST['tarea'];
            $this->tarea_agenda->usuario = $_POST['usuario'];

            if($this->tarea_agenda->save())

                {
                    $this->new_message('Datos Guardados Correctamante');

                }
                else
                {
                    $this->new_error_msg('Error al Guardar');
                }
            }
        else if (isset ($_GET['id'])) ///Mostrar Tarea
            {
             $this->editar = $this->tarea_agenda->get($_GET['id']);
            }
            else if (isset ($_GET['delete'])) ///Eliminar Tarea
            {
             $aux = $this->tarea_agenda->get($_GET['delete']);
             if ($aux)
             {
             if ($aux->delete())
                {
                $this->new_message('Datos Eliminados Correctamante');
                }
                else
                {
                $this->new_error_msg('Error al Eliminar');
                }
             }
            else
            {
            $this->new_error_msg('Tarea NO Encontrada');
            }


            }
    }


}
