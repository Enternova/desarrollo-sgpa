<?  include("../lib/@session.php");

//12.1 - apertura urna
//12.2 - Evaluacion tecnica apertura
//12.3 - Apertura Economica


if($_POST["accion"]=="graba_gestion_apertura"){//12.1 - Apertura Economica
	agrega_firmas_urna_virtual($_POST["id_item_pecc"], "12.1");
	if($_POST["contiene_tecnico"] == 2){
		agrega_firmas_urna_virtual($_POST["id_item_pecc"], "12.2", 1500);
		}
	}
	
	
if($_POST["accion"]=="graba_gestion_tecnmmico"){//12.2 - Evaluacion tecnica apertura
	agrega_firmas_urna_virtual($_POST["id_item_pecc"], "12.2");
	}





?>