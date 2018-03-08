<div class="jmgmodal visible" id="modal-miventana">
	<div class="panel" style="max-width: 400px; max-height: 40vh;">
		<div class="title">
			<!-- aqui va el titulo -->
		</div>
		<div class="close">&times;</div>
		<div class="content">
			<!-- aqui va el contenido -->
		</div>
		<div class="footer">
			<!-- aqui van los botones -->
			<button class="action">OK</button>
		</div>
	</div>
</div>

<div class="jmgmodal visible" id="modal-alertas" >
	<div class="panel">
		<div class="title">
			<!-- aqui va el titulo -->
			<span><?=$_GET["titulo_modal"];?></span>
		</div>
		<div></div>
		<div class="content">
			<!-- aqui va el contenido -->
			<span style='font-size: 18px;'>Recuerde que su número de solicitud para el seguimiento es el <strong style='font-size: 20px; color: #005395; z-index: 1;'><?=$_GET["numero_solicitud"]?></strong> y el Profesional/Comprador de abastecimiento que le apoyara en el proceso es <strong style='font-size: 20px; color: #005395;'><?=$_GET["profesional"]?></strong></span>
		</div>
		<div class="footer">
			<!-- aqui van los botones -->
			<button id="button-ok" class="action button-ok"  onclick='window.parent.document.getElementById("div_carga_busca_sol").style.display="none"; body.style.overflow = "visible"'>OK</button>
			<button style="display: none;" id="button-cancel" class="action button-cancel" value="" onclick="oculta_alerta()"></button>
		</div>
	</div>
</div>