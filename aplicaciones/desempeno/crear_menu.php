<?
	function agrega_row_menu($tamano_menu, $titulo_menu, $descripcion_menu, $link){ 
       echo $imprime='
        
		
		<div class="col '.$tamano_menu.'">
          <div class="card blue-grey darken-1">
            <div class="card-content white-text">
              <span class="card-title">'.$titulo_menu.'</span>
              <p>'.$descripcion_menu.'</p>
            </div>
            <div class="card-action">
              <a href="#">'.$link.'</a>
            </div>
          </div>
        </div>
		
		
		
		
		';
      
	}
?>