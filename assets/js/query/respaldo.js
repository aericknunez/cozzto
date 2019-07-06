$(document).ready(function()
{



//// monitorear los respaldos
    function SyncMonitor(){
        $.ajax({
            type: "POST",
            url: "application/src/routes.php?op=124",
            success: function(data) {
            	$('#SyncMonitor').html(data);
            }
        });
    }

//SyncMonitor();
setInterval(SyncMonitor, 3000);
///


});