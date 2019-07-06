<?php 
defined('BASEPATH') OR exit('No direct script access allowed');


$hoy = date("d-m-Y");
$dia1 = Fechas::DiaResta(date("d-m-Y"),1);
$dia2 = Fechas::DiaResta(date("d-m-Y"),2);
$dia3 = Fechas::DiaResta(date("d-m-Y"),3);
$dia4 = Fechas::DiaResta(date("d-m-Y"),4);
$dia5 = Fechas::DiaResta(date("d-m-Y"),5);
$dia6 = Fechas::DiaResta(date("d-m-Y"),6);
 
 ?>

     <!-- Charts -->
    <script>
        // Line
        var ctx = document.getElementById("myChart").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [
              "<?php echo Fechas::NombreDia($dia6); ?>", 
              "<?php echo Fechas::NombreDia($dia5); ?>", 
              "<?php echo Fechas::NombreDia($dia4); ?>", 
              "<?php echo Fechas::NombreDia($dia3); ?>", 
              "<?php echo Fechas::NombreDia($dia2); ?>", 
              "<?php echo Fechas::NombreDia($dia1); ?>", 
              "<?php echo Fechas::NombreDia($hoy); ?>"],
                datasets: [{
                    label: 'Trafico Diario',
                    data: [
                    <?php echo Helpers::Entero($admin->Productos($dia6)); ?>, 
			        <?php echo Helpers::Entero($admin->Productos($dia5)); ?>, 
			        <?php echo Helpers::Entero($admin->Productos($dia4)); ?>, 
			        <?php echo Helpers::Entero($admin->Productos($dia3)); ?>, 
			        <?php echo Helpers::Entero($admin->Productos($dia2)); ?>, 
			        <?php echo Helpers::Entero($admin->Productos($dia1)); ?>, 
			        <?php echo Helpers::Entero($admin->Productos($hoy)); ?>
        ],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });


    </script>