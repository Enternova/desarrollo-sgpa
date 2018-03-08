	/****** CAMBIAR EL FORMATO DE LA FECHA PARA PASASRLOS A LA BD *****
		var input=$('#fecha-cita').pickadate();//obtengo el formato de fecha en texto
		var picker = input.pickadate('picker');//lo convierto en un objeto
		var inicio=picker.get('select', 'yyyy-mm-dd');//cambio el formato de texto a numero
	/****** CAMBIAR EL FORMATO DE LA FECHA PARA PASASRLOS A LA BD *****/

	$('.datepicker').pickadate({
	    onSet: function( arg ){
	        if ( 'select' in arg ){ //prevent closing on selecting month/year
	            this.close();
	            fecha_inicio=new Date($('#per-fecha-inicio').val());
				fecha_fin=new Date($('#per-fecha-fin').val());
				if(fecha_inicio!="" && fecha_fin!=""){
					if(fecha_inicio>fecha_fin || fecha_fin<fecha_inicio){
						document.getElementById('per-fecha-inicio').value="";
						document.getElementById('per-fecha-fin').value="";
						alert('la fecha inicial no puede ser mayor que la final');}
				}
				
	        }
	    },
	    // Strings and translations se traduce el calendario a español
		showMonthsShort: true,
		showWeekdaysFull: true,
		monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
		monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
		weekdaysFull: ['Dom', 'Lun', 'Mar', 'Mi&eacute;', 'Jue', 'Vie', 'S&aacute;b'],
		selectYears: 80,

		// Buttons
		today: 'Hoy',
		clear: 'Borrar',
		close: 'Cerrar',

		// Accessibility labels
		labelMonthNext: 'Mes Siguiente',
		labelMonthPrev: 'Mes Anterior',
		labelMonthSelect: 'Seleccionar Mes',
		labelYearSelect: 'Seleccionar Año',

		// Formats
		format: 'dd mmmm, yyyy',
		formatSubmit: 'dd mmmm, yyyy',
		hiddenPrefix: undefined,
		hiddenSuffix: '_submit',
		hiddenName: true,

		// Editable input
		editable: undefined,

		// Dropdown selectors
		selectYears: true,
		selectMonths: true,

		// First day of the week
		firstDay: 1,

		// Date limits se hablitan solo 15 dias para sacar citas, no para fechasn tan futuras.
		min: false,
		max: false,
		yearRange: undefined,

		// Disable dates se deshabilita desde hoy hacia atrás tambien los dias domingos
		disable: [7,6],

		// Root picker container
		container: undefined,

		// Hidden input container
		containerHidden: undefined,

		// Close on a user action
		closeOnSelect: true,
		closeOnClear: true,

		// Events
		onStart: undefined,
		onRender: undefined,
		onOpen: undefined,
		onClose: true,
		onStop: undefined,

		// Classes
		klass: {

		  // The element states
		  input: 'picker__input',
		  active: 'picker__input--active',

		  // The root picker and states *
		  picker: 'picker',
		  opened: 'picker--opened',
		  focused: 'picker--focused',

		  // The picker holder
		  holder: 'picker__holder',

		  // The picker frame, wrapper, and box
		  frame: 'picker__frame',
		  wrap: 'picker__wrap',
		  box: 'picker__box',

		  // The picker header
		  header: 'picker__header',

		  // Month navigation
		  navPrev: 'picker__nav--prev',
		  navNext: 'picker__nav--next',
		  navDisabled: 'picker__nav--disabled',

		  // Month & year labels
		  month: 'picker__month',
		  year: 'picker__year',

		  // Month & year dropdowns
		  selectMonth: 'picker__select--month',
		  selectYear: 'picker__select--year',

		  // Table of dates
		  table: 'picker__table',

		  // Weekday labels
		  weekdays: 'picker__weekday',

		  // Day states
		  day: 'picker__day',
		  disabled: 'picker__day--disabled',
		  selected: 'picker__day--selected',
		  highlighted: 'picker__day--highlighted',
		  now: 'picker__day--today',
		  infocus: 'picker__day--infocus',
		  outfocus: 'picker__day--outfocus',

		  // The picker footer
		  footer: 'picker__footer',

		  // Today, clear, & close buttons
		  buttonClear: 'picker__button--clear',
		  buttonClose: 'picker__button--close',
		  buttonToday: 'picker__button--today'
		}
	});