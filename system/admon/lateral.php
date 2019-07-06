<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
?>


<?php if(isset($admin)){ ?>
        <!--Card-->

        <div id="hashes"><?php $admin->UltimosHas(); ?></div>
        <!--Card-->
        <div class="card mb-4">

            <!--Card content-->
            <div class="card-body">

                <!-- List group links -->
                <div class="list-group list-group-flush">
                    <a class="list-group-item list-group-item-action waves-effect">Trafico
                        <span class="badge badge-success badge-pill pull-right"><?php echo $admin->Trafico(date("d-m-Y")); ?>
                            <i class="fa fa-arrow-right ml-1"></i>
                        </span>
                    </a>
                    <a class="list-group-item list-group-item-action waves-effect">Entradas
                        <span class="badge badge-danger badge-pill pull-right"><?php echo $admin->Entradas(date("d-m-Y")); ?>
                            <i class="fa fa-arrow-right ml-1"></i>
                        </span>
                    </a>
                    <a class="list-group-item list-group-item-action waves-effect">Productos Hoy
                        <span class="badge badge-primary badge-pill pull-right"><?php echo Helpers::Entero($admin->Productos(date("d-m-Y"))); ?></span>
                    </a>
                    <a class="list-group-item list-group-item-action waves-effect">Productos Total
                        <span class="badge badge-primary badge-pill pull-right"><?php echo $admin->ProductosT(); ?></span>
                    </a>
                    <a class="list-group-item list-group-item-action waves-effect">Cuentas
                        <span class="badge badge-primary badge-pill pull-right"><?php echo $admin->Cuentas(); ?></span>
                    </a>
                </div>
                <!-- List group links -->

            </div>

        </div>
        <!--/.Card-->
<?php } else {
echo '<div align="center"><br><img src="assets/img/logo/'. $_SESSION['config_imagen'] .'" alt="" class="img-fluid hoverable"></div>';
}
 ?>
