/*** SE UTILZA EL PATRÓN IIFE
**** Expresión de Función Inmediatamente Invocada
**** Función Anónima Auto Ejecutable */
(function(window, document){
	'use strict';
	var hocolTables=function(){
		var tablePagination={
			'first':0,
			'after':0,
			'actual':0,
			'next':0,
			'last':0,
			'total':0,
			'firstTime':0
		},
		arrayTableHocol=[],
		tableOnBody={},
		hocolTables_methods={
			addEventToTable: function(id){
				if(id!=null && id!=""){
					var table=document.getElementById(id)
					//if(document.addEventListener){
						//document.getElementById(id).addEventListener("mousedown",function(event){
							var id_table=table.id
							var id_i=0;
							var htead=table.tHead.rows[0].cells
							/*for(var i=0; i<htead.length; i++){
								//console.log(id_i)
								if(document.getElementById("id_row_"+id_i)){
									
								}else{
									var elementth=htead[i]
									//console.log(htead[i])
									var text_content=htead[i]
									var row=document.createElement("div");
									row.className="input-field col s2 m2 l2"
									row.id="id_row_"+id_i
									var icon1=document.createElement("i");
									icon1.className="material-icons md-24 left icon-order-left"
									icon1.id="th_"+id_i+"_icon1_"+id_i
									icon1.addEventListener("mousedown",function(event){
										_.changeOrderToTable(this.id,id_table)
				                        //$("#gerente_confirma_asegu").val($(this).text())
				                    }, false);
				                    var tex_i1=document.createTextNode("&#xE5D8;");
									var icon2=document.createElement("i");
									icon2.className="material-icons md-24 right icon-order-right"
									icon2.id="th_"+id_i+"_icon2_"+id_i
									icon2.addEventListener("mousedown",function(event){
										_.changeOrderToTable(this.id,id_table)
				                        //$("#gerente_confirma_asegu").val($(this).text())
				                    }, false);
				                    var tex_i2=document.createTextNode("&#xE5DB;");
				                    //icon1.appendChild(tex_i1);
				                    //icon2.appendChild(tex_i2);
				                    row.appendChild(icon1);
				                    row.appendChild(icon2);
				                    text_content.appendChild(row);
				                    $("#th_"+id_i+"_icon1_"+id_i).append('&#xE5D8;')
				                    $("#th_"+id_i+"_icon2_"+id_i).append('&#xE5DB;')
				                	
				                	id_i++;
				                }

							}*/
							_.resetArrayTable()
							_.addIdToTable(table.id)
							
							_.orderOriginal(table.id)
							_.addListPagination()

							//console.log(htead)
			                //alert(this.id)			                
			            //}, false);
					/*}else{
						document.getElementById(id).attachEvent("mousedown",function(event){
			            	alert(this.id)
			            }, false);
					}*/
				}
			},
			addIdToTable: function (id){
				var table=document.getElementById(id)
				//console.log(table)
				var tbody=table.getElementsByTagName("tbody")
                //console.log(tbody[0].rows.length)
                var z=0, y=0;
                for (var h=0; h<tbody[0].rows.length; h++){
                	for (var j=0; j<tbody[0].rows[h].cells.length; j++){
                		if(document.getElementById("row_"+j+"_tr_"+h+"_td_"+j)){
                		}else{					                			
	                		var td_element=tbody[0].rows[h].cells[j]
	                		td_element.id="row_"+j+"_tr_"+h+"_td_"+j
	                		td_element.className="row_"+j
	                		//console.log(td_element.className)
                		}
                	}
                }
			},
			changeOrderToTable: function(id_icon, id_table){
				var table=document.getElementById(id_table)
				var htead=table.tHead.rows[0].cells
				for(var i=0; i<htead.length; i++){
					var icon_element1=document.getElementById("th_"+i+"_icon1_"+i)
					var icon_element2=document.getElementById("th_"+i+"_icon2_"+i)
					icon_element1.classList.remove("icon-order-active");
					icon_element2.classList.remove("icon-order-active");
				}
				var icon_element_actual=document.getElementById(id_icon)
				icon_element_actual.classList.add("icon-order-active");
				var id_icon_actived=id_icon
				id_icon_actived=id_icon_actived.split("_")
				if(id_icon_actived[2] === "icon1"){
					_.orderTableUp(id_icon, table.id)
				}else{
					_.orderTableDown(id_icon, table.id)
				}
			},
			orderTableUp: function(id_icon, id_table){
				var is_number=true;
				var id_icon_actived=id_icon
				id_icon_actived=id_icon_actived.split("_")
				var table=document.getElementById(id_table);
				var tbody=table.getElementsByTagName("tbody");
				var contPosJson=0;
                var jsonTdTemp=[],
					jsonMethodsTables={
						jsonPushTableTemp: function(rowData,tr){
							var obj={
								'row':rowData,
								tr
							}
							arrayTableHocol.push(obj)
							return this
						},
						jsonPushTdTemp:function(tr,td){
							jsonTdTemp.push(td)
							return this
						},
						resetJsonTd:function(){
							jsonTdTemp=[]
						}
					};
                for (var h=0; h<tbody[0].rows.length; h++){
                	var string_td=[]
                	var string_row=""
                	jsonMethodsTables.resetJsonTd()
                	for (var j=0; j<tbody[0].rows[h].cells.length; j++){
                		var td_element=tbody[0].rows[h].cells[j]
                		var result=td_element.innerHTML
            			result=result.replace("\n", "")//para dejar solo la cadena
			            result=result.replace(/^\s+|\s+$/g, "")//para dejar solo la cadena
						result=result.replace("\n","")
						result=result.replace("[\n\r]", "");
                		if(parseFloat(result)){
                		}else{
                			is_number=false;
                		}
                		if(td_element.className=="row_"+id_icon_actived[1]){
                			string_row=result
                		}
                		jsonMethodsTables.jsonPushTdTemp('tr',result);
                		if(j==tbody[0].rows[h].cells.length-1){
                			jsonMethodsTables.jsonPushTableTemp(string_row,jsonTdTemp);
                		}
                	}
                }
                arrayTableHocol.sort(function(a,b){
                	if (a.row > b.row) {
						return 1;
					}
					if (a.row < b.row) {
						return -1;
					}
					return 0;
                })
                var number_colums=arrayTableHocol.length,number_total=arrayTableHocol.length;
                var totalPages=""+number_colums/9, findFloat=0;
                findFloat=totalPages.indexOf(".")
                if(findFloat==1){
                	//si es decimal se corta la cadena y se aproxima al numero siguiente
                	totalPages=totalPages.split(".")
                	totalPages=parseInt(totalPages[0])
                	totalPages=totalPages+1;
                }
                _.addPaginationArray(0,9,1,2,totalPages,number_total,id_table)
                _.changePagiantionArray(0, 1)
                //console.log(tablePagination)
                _.addIdToTable(id_table)
			},
			orderTableDown: function(id_icon, id_table){
				var is_number=true;
				var id_icon_actived=id_icon
				id_icon_actived=id_icon_actived.split("_")
				var table=document.getElementById(id_table);
				var tbody=table.getElementsByTagName("tbody");
				var contPosJson=0;
                var jsonTdTemp=[],
					jsonMethodsTables={
						jsonPushTableTemp: function(rowData,tr){
							var obj={
								'row':rowData,
								tr
							}
							arrayTableHocol.push(obj)
							return this
						},
						jsonPushTdTemp:function(tr,td){
							jsonTdTemp.push(td)
							return this
						},
						resetJsonTd:function(){
							jsonTdTemp=[]
						}
					};
                var z=0, y=0;
                for (var h=0; h<tbody[0].rows.length; h++){
                	var string_td=[]
                	var string_row=""
                	jsonMethodsTables.resetJsonTd()
                	for (var j=0; j<tbody[0].rows[h].cells.length; j++){
                		var td_element=tbody[0].rows[h].cells[j]
                		var result=td_element.innerHTML
            			result=result.replace("\n", "")//para dejar solo la cadena
			            result=result.replace(/^\s+|\s+$/g, "")//para dejar solo la cadena
						result=result.replace("\n","")
						result=result.replace("[\n\r]", "");
                		if(parseFloat(result)){
                		}else{
                			is_number=false;
                		}
                		if(td_element.className=="row_"+id_icon_actived[1]){
                			string_row=result
                		}
                		jsonMethodsTables.jsonPushTdTemp('tr',result);
                		if(j==tbody[0].rows[h].cells.length-1){
                			jsonMethodsTables.jsonPushTableTemp(string_row,jsonTdTemp);
                		}
                	}
                }
                arrayTableHocol.sort(function(b,a){
                	if (a.row > b.row) {
						return 1;
					}
					if (a.row < b.row) {
						return -1;
					}
					return 0;
                })
                var number_colums=arrayTableHocol.length,number_total=arrayTableHocol.length;
                var totalPages=""+number_colums/9, findFloat=0;
                findFloat=totalPages.indexOf(".")
                if(findFloat==1){
                	//si es decimal se corta la cadena y se aproxima al numero siguiente
                	totalPages=totalPages.split(".")
                	totalPages=parseInt(totalPages[0])
                	totalPages=totalPages+1;
                }
                _.addPaginationArray(0,9,1,2,totalPages,number_total,id_table)
                _.changePagiantionArray(0, 1)
                //console.log(tablePagination)
                _.addIdToTable(id_table)
			},
			orderOriginal: function(id_table){
				var is_number=true;
				var table=document.getElementById(id_table);
				var tbody=table.getElementsByTagName("tbody");
				var contPosJson=0;
                var jsonTdTemp=[],
					jsonMethodsTables={
						jsonPushTableTemp: function(rowData,tr){
							var obj={
								'row':rowData,
								tr
							}
							arrayTableHocol.push(obj)
							return this
						},
						jsonPushTdTemp:function(tr,td){
							jsonTdTemp.push(td)
							return this
						},
						resetJsonTd:function(){
							jsonTdTemp=[]
						}
					};
                var z=0, y=0;
                for (var h=0; h<tbody[0].rows.length; h++){
                	var string_td=[]
                	var string_row=""
                	jsonMethodsTables.resetJsonTd()
                	for (var j=0; j<tbody[0].rows[h].cells.length; j++){
                		var td_element=tbody[0].rows[h].cells[j]
                		var result=td_element.innerHTML
            			result=result.replace("\n", "")//para dejar solo la cadena
			            result=result.replace(/^\s+|\s+$/g, "")//para dejar solo la cadena
						result=result.replace("\n","")
						result=result.replace("[\n\r]", "");
                		if(parseFloat(result)){
                		}else{
                			is_number=false;
                		}
                			string_row=result
                		jsonMethodsTables.jsonPushTdTemp('tr',result);
                		if(j==tbody[0].rows[h].cells.length-1){
                			jsonMethodsTables.jsonPushTableTemp(string_row,jsonTdTemp);
                		}
                	}
                }
                arrayTableHocol.sort(function(b,a){
                	if (a.row > b.row) {
						return 1;
					}
					if (a.row < b.row) {
						return -1;
					}
					return 0;
                })
                var number_colums=arrayTableHocol.length,number_total=arrayTableHocol.length;
                var totalPages=""+number_colums/9, findFloat=0;
                findFloat=totalPages.indexOf(".")
                if(findFloat==1){
                	//si es decimal se corta la cadena y se aproxima al numero siguiente
                	totalPages=totalPages.split(".")
                	totalPages=parseInt(totalPages[0])
                	totalPages=totalPages+1;
                }
                _.addPaginationArray(0,9,1,2,totalPages,number_total,id_table)
                _.changePagiantionArray(0, 1)
                //console.log(tablePagination)
                _.addIdToTable(id_table)
                $("#load-registers").empty()
	      $("#load-registers").append('<label class="left">MOSTRANDO REGISTROS: 1 AL 10 DE '+tablePagination.total+'</label>');
			},
			orderTableFromHtml:function(string,id_table){
				_.resetArrayTable()
				var contPosJson=0;
				var jsonTdTemp=[],
				jsonMethodsTables={
					jsonPushTableTemp: function(rowData,tr){
						var obj={
						'row':rowData,
						tr
						}
						arrayTableHocol.push(obj)
						return this
					},
						jsonPushTdTemp:function(tr,td){
						jsonTdTemp.push(td)
						return this
					},
					resetJsonTd:function(){
						jsonTdTemp=[]
					}
				};
				var arr=string.replace('"', '');
				arr=arr.split('--tr--');
				for (var i=0; i<arr.length; i++){
					if(arr[i]!=""){
						var string_row=""
						jsonMethodsTables.resetJsonTd()
						var arr2=arr[i].split('--td--');
						for (var j=0; j<arr2.length; j++){
							var result=arr2[j]
			            	result=result.replace("\n", "")//para dejar solo la cadena
						    result=result.replace(/^\s+|\s+$/g, "")//para dejar solo la cadena
							result=result.replace("\n","")
							result=result.replace("[\n\r]", "");
							jsonMethodsTables.jsonPushTdTemp('tr',result);
							if(j==0){
								string_row=result
							}
	                		if(j==arr2.length-1){
	                			jsonMethodsTables.jsonPushTableTemp(string_row,jsonTdTemp);
	                		}
						}
					}
				}
				//console.log(arrayTableHocol)
				arrayTableHocol.sort(function(a,b){
					if (a.row > b.row) {
						return 1;
					}
					if (a.row < b.row) {
						return -1;
					}
					return 0;
				})
				var number_colums=arrayTableHocol.length,number_total=arrayTableHocol.length;
				var totalPages=""+number_colums/9, findFloat=0;
				findFloat=totalPages.indexOf(".")
				if(findFloat==1){
					//si es decimal se corta la cadena y se aproxima al numero siguiente
					totalPages=totalPages.split(".")
					totalPages=parseInt(totalPages[0])
					totalPages=totalPages+1;
				}
				_.addPaginationArray(0,9,1,2,totalPages,number_total,id_table)
				_.changePagiantionArray(0, 1)
				_.addListPagination()
				$("#load-registers").empty()
				$("#load-registers").append('<label class="left">MOSTRANDO REGISTROS: 1 AL 10 DE '+tablePagination.total+'</label>');
			},
			addPaginationArray:function(first, after, actual, next, last, total, id_table){
				tablePagination={
					'first':first,
					'after':after,
					'actual':actual,
					'next':next,
					'last':last,
					'total':total,
					'id':id_table,
				}
			},
			changePagiantion:function(pageActual, position){
				var positionLi=$( "#"+position).index()
				var liElement=pageActual
				var ifIsFirst=$( "#"+liElement.id ).prev()
				//console.log(ifIsFirst[0].id)
				var ulParent=liElement.parentElement
				var sizeUl=ulParent.getElementsByTagName("li").length
				var totalPagination=tablePagination.last;
				var ifMore=false;
				if(totalPagination>5){
					ifMore=true;
				}
				if(liElement.id=="after"){
					for(var i=1; i<=sizeUl-2; i++){
						if(ulParent.getElementsByTagName("li")[i].className=="color-blue-light-hocol"){
							var iBefore=i-2;
							var iActual=i-1;
							var iAfter=i;
							var iBefore1;
							var iActual1;
							//console.log("antes del conticional after: "+iAfter)
							//console.log(parseInt(ulParent.getElementsByTagName("li")[iActual].id))
							var lastRegister=(parseInt(ulParent.getElementsByTagName("li")[iActual].id))*10;
							var firstRegister=lastRegister-9;
							if(ulParent.getElementsByTagName("li")[iAfter].className=="color-blue-light-hocol" && iAfter>2){
								//console.log("aqui 1")
								if(iBefore==0 && parseInt(ulParent.getElementsByTagName("li")[iActual].id)==1){
									iBefore1=0
								}else if(iBefore==0){
									iBefore1=parseInt(ulParent.getElementsByTagName("li")[iActual-1].id)
								}else{
									iBefore1=parseInt(ulParent.getElementsByTagName("li")[iBefore].id)
								}
								iActual1=parseInt(ulParent.getElementsByTagName("li")[iActual].id)
								//console.log(iBefore1+"-----"+iActual1)
								$("#load-registers").empty();
								ulParent.getElementsByTagName("li")[iAfter].className="waves-effect color-blue-light-hocol-hover"
								ulParent.getElementsByTagName("li")[iActual].className="color-blue-light-hocol"
								ulParent.getElementsByTagName("li")[0].className="waves-effect color-blue-light-hocol-hover"
								ulParent.getElementsByTagName("li")[sizeUl-1].className="waves-effect color-blue-light-hocol-hover"
								//(console.log("aqui 1")
								_.addPaginationArray((tablePagination.first-9),(tablePagination.first),iActual1,iAfter,tablePagination.last,tablePagination.total,tablePagination.id)
								_.changePagiantionArray(iBefore1, iActual1)
								if((parseInt(ulParent.getElementsByTagName("li")[iAfter+1].id))==tablePagination.last){
									lastRegister=tablePagination.total
								}
								$("#load-registers").append('<label class="left">MOSTRANDO REGISTROS: '+firstRegister+' AL '+lastRegister+' DE '+tablePagination.total+'</label>');
								return;
							}else if(ulParent.getElementsByTagName("li")[iAfter].className=="color-blue-light-hocol" && iAfter==2){
								//console.log("aqui 22")
								if(iBefore==0 && parseInt(ulParent.getElementsByTagName("li")[iActual].id)==1){
									iBefore1=0
								}else if(iBefore==0){
									iBefore1=parseInt(ulParent.getElementsByTagName("li")[iActual].id)-1
								}else{
									iBefore1=parseInt(ulParent.getElementsByTagName("li")[iBefore].id)
								}
								iActual1=parseInt(ulParent.getElementsByTagName("li")[iActual].id)
								//console.log(iBefore1+"-----"+iActual1)
								$("#load-registers").empty();
								ulParent.getElementsByTagName("li")[iAfter].className="waves-effect color-blue-light-hocol-hover"
								ulParent.getElementsByTagName("li")[iActual].className="color-blue-light-hocol"
								ulParent.getElementsByTagName("li")[0].className="disabled"
								ulParent.getElementsByTagName("li")[sizeUl-1].className="waves-effect color-blue-light-hocol-hover"
								//(console.log("aqui 2")
								_.addPaginationArray((tablePagination.first-9),(tablePagination.after-9),iActual1,iAfter,tablePagination.last,tablePagination.total,tablePagination.id)
								if(ifMore==true && (parseInt(ulParent.getElementsByTagName("li")[iActual].id))>1){
									//console.log("aqui 22 1")
									ulParent.getElementsByTagName("li")[0].className="waves-effect color-blue-light-hocol-hover"
									_.changePagiantionArray(iBefore1, iActual1)
									_.addToFirst(ulParent)
								}else if(ifMore==false){
									//console.log("aqui 22 2")
									_.changePagiantionArray(iBefore1, iActual1)
								}else if(ifMore==true && (parseInt(ulParent.getElementsByTagName("li")[iActual].id))==1){
									//console.log("aqui 22 3")
									ulParent.getElementsByTagName("li")[0].className="disabled"
									_.changePagiantionArray(iBefore1, iActual1)
								}
								if(i-1==tablePagination.last){
									lastRegister=tablePagination.total
								}
								$("#load-registers").append('<label class="left">MOSTRANDO REGISTROS: '+firstRegister+' AL '+lastRegister+' DE '+tablePagination.total+'</label>');
								return;
							}
						}
					}
				}else if(liElement.id=="next"){
					for(var i=1; i<sizeUl-1; i++){
						if(ulParent.getElementsByTagName("li")[i].className=="color-blue-light-hocol"){
							var iBefore=i;
							var iActual=i+1;
							var iAfter=i+2;
							//console.log(iActual+" --- aqui "+i)
							//console.log(ulParent.getElementsByTagName("li")[iActual])
							//console.log(parseInt(ulParent.getElementsByTagName("li")[iActual].id))

							var lastRegister=(parseInt(ulParent.getElementsByTagName("li")[iActual].id))*10;
							var firstRegister=lastRegister-9;
							var iBefore1;
							var iActual1;
							if(i==tablePagination.last){
								lastRegister=tablePagination.total
							}
							if(ulParent.getElementsByTagName("li")[iBefore].className=="color-blue-light-hocol" && iBefore<sizeUl-3 && ulParent.getElementsByTagName("li")[iBefore].id!="next"){
								//console.log("aqui 11")
								$("#load-registers").empty();
								ulParent.getElementsByTagName("li")[iBefore].className="waves-effect color-blue-light-hocol-hover"
								ulParent.getElementsByTagName("li")[iActual].className="color-blue-light-hocol"
								ulParent.getElementsByTagName("li")[0].className="waves-effect color-blue-light-hocol-hover"
								ulParent.getElementsByTagName("li")[sizeUl-1].className="waves-effect color-blue-light-hocol-hover"
								//console.log("aqui 1")
								_.addPaginationArray((tablePagination.after),(tablePagination.after+9),iActual,iAfter,tablePagination.last,tablePagination.total,tablePagination.id)
								iBefore1=parseInt(ulParent.getElementsByTagName("li")[iBefore].id)
								iActual1=parseInt(ulParent.getElementsByTagName("li")[iActual].id)
								if(parseInt(ulParent.getElementsByTagName("li")[iActual].id)==iActual){
									_.changePagiantionArray(iBefore1, iActual1)
									////console.log("aqui 11 1")
								}else{
									_.changePagiantionArray(iBefore1, iActual1)
									////console.log("aqui 11 2")
								}
								if((parseInt(ulParent.getElementsByTagName("li")[iActual].id))==tablePagination.last){
									lastRegister=tablePagination.total
								}
								$("#load-registers").append('<label class="left">MOSTRANDO REGISTROS: '+firstRegister+' AL '+lastRegister+' DE '+tablePagination.total+'</label>');
								return;
							}else if(ulParent.getElementsByTagName("li")[iBefore].className=="color-blue-light-hocol" && iBefore<sizeUl-2){
								////console.log("aqui 22")
								$("#load-registers").empty();
								ulParent.getElementsByTagName("li")[iBefore].className="waves-effect color-blue-light-hocol-hover"
								ulParent.getElementsByTagName("li")[iActual].className="color-blue-light-hocol"
								ulParent.getElementsByTagName("li")[0].className="waves-effect color-blue-light-hocol-hover"
								ulParent.getElementsByTagName("li")[sizeUl-1].className="disabled"
								iBefore1=parseInt(ulParent.getElementsByTagName("li")[iBefore].id)
								iActual1=parseInt(ulParent.getElementsByTagName("li")[iActual].id)
								if(ifMore==true && (parseInt(ulParent.getElementsByTagName("li")[iActual].id))<(totalPagination)){
									//console.log("aqui 2")
									_.addPaginationArray((tablePagination.after),(tablePagination.after+9),iActual1,0,tablePagination.last,tablePagination.total,tablePagination.id)
									_.changePagiantionArray(iBefore1, iActual1)
								}else if(ifMore==false){
									//console.log("aqui 3")
									_.addPaginationArray((tablePagination.after),(tablePagination.after+9),iActual1,0,tablePagination.last,tablePagination.total,tablePagination.id)
									_.changePagiantionArray(iBefore1, iActual1)
								}else if(ifMore==true && (parseInt(ulParent.getElementsByTagName("li")[iActual].id))==(totalPagination)){
									//console.log("aqui 4")
									_.addPaginationArray((tablePagination.after),(tablePagination.after+9),iActual1,0,tablePagination.last,tablePagination.total,tablePagination.id)
									_.changePagiantionArray(iBefore1+1, iActual1+1)
								}
								if((parseInt(ulParent.getElementsByTagName("li")[iActual].id))==tablePagination.last){
									lastRegister=tablePagination.total
								}
								$("#load-registers").append('<label class="left">MOSTRANDO REGISTROS: '+firstRegister+' AL '+lastRegister+' DE '+tablePagination.total+'</label>');
								if(ifMore==true && (parseInt(ulParent.getElementsByTagName("li")[iActual].id))<(totalPagination)){
									//console.log("aqui 5")
									//console.log("entro 2 1")
									//console.log(tablePagination.first+"-----"+tablePagination.after)
									//_.addPaginationArray(1,iBefore+1,iActual+1,iAfter+1,tablePagination.last,tablePagination.total,tablePagination.id)
									_.addPaginationArray(tablePagination.first,tablePagination.after,iActual+1,iAfter+1,tablePagination.last,tablePagination.total,tablePagination.id)
									ulParent.getElementsByTagName("li")[sizeUl-1].className="waves-effect color-blue-light-hocol-hover"
									_.addToLast(ulParent)
								}
								return;
							}
						}
					}
				}else if(parseInt(liElement.id)==1 || positionLi==1){
					//console.log("entro 1")
					//console.log(positionLi)
					if(sizeUl>3){
						var iBefore=parseInt(liElement.id)-1;
						var iActual=parseInt(liElement.id);
						var iAfter=parseInt(liElement.id)+1;
						//console.log(iBefore+"----"+iActual+"---"+iAfter)
						ulParent.getElementsByTagName("li")[0].className="disabled"
						ulParent.getElementsByTagName("li")[sizeUl-1].className="waves-effect color-blue-light-hocol-hover"
						for(var i=1; i<sizeUl-1; i++){
							ulParent.getElementsByTagName("li")[i].className="waves-effect color-blue-light-hocol-hover"
						}
						var lastRegister=(liElement.id)*10;
						var firstRegister=lastRegister-9;
						$("#load-registers").empty();
						$("#load-registers").append('<label class="left">MOSTRANDO REGISTROS: '+firstRegister+' AL '+lastRegister+' DE '+tablePagination.total+'</label>');
						document.getElementById(liElement.id).className="color-blue-light-hocol"
						_.addPaginationArray((tablePagination.first-9),(tablePagination.first),1,2,tablePagination.last,tablePagination.total,tablePagination.id)
						console.log(tablePagination.first+"-----"+tablePagination.after+" aqui anterior")
						_.changePagiantionArray(iBefore, iActual)
						if(ifMore==true && (ifIsFirst[0].id=="after" && parseInt(liElement.id)>1)){
							ulParent.getElementsByTagName("li")[0].className="waves-effect color-blue-light-hocol-hover"
							_.addToFirst(ulParent)
						}
					}
				}
				else if(parseInt(liElement.id)==sizeUl-2 || positionLi==5){
					//console.log("entro 2")
					//console.log(positionLi)
					if(sizeUl>3){
						var iBefore=parseInt(ulParent.getElementsByTagName("li")[sizeUl-2].id)-1;
						var iActual=parseInt(ulParent.getElementsByTagName("li")[sizeUl-2].id);
						var iAfter=parseInt(ulParent.getElementsByTagName("li")[sizeUl-2].id)+1;
						//console.log(iBefore+"----"+iActual+"---"+iAfter)
						ulParent.getElementsByTagName("li")[0].className="waves-effect color-blue-light-hocol-hover"
						ulParent.getElementsByTagName("li")[sizeUl-1].className="disabled"
						for(var i=1; i<sizeUl-1; i++){
							ulParent.getElementsByTagName("li")[i].className="waves-effect color-blue-light-hocol-hover"
						}
						var lastRegister=(liElement.id)*10;
						var firstRegister=lastRegister-9;
						if(parseInt(liElement.id)==tablePagination.last){
							lastRegister=tablePagination.total
						}
						$("#load-registers").empty();
						$("#load-registers").append('<label class="left">MOSTRANDO REGISTROS: '+firstRegister+' AL '+lastRegister+' DE '+tablePagination.total+'</label>');
						document.getElementById(liElement.id).className="color-blue-light-hocol"
						_.addPaginationArray((tablePagination.after),(tablePagination.after+9),parseInt(liElement.id),0,tablePagination.last,tablePagination.total,tablePagination.id)
						_.changePagiantionArray(iBefore, iActual)
						if(ifMore==true && (parseInt(ulParent.getElementsByTagName("li")[sizeUl-2].id))<(totalPagination)){
							//console.log("entro 2 1")
							ulParent.getElementsByTagName("li")[sizeUl-1].className="waves-effect color-blue-light-hocol-hover"
							_.addToLast(ulParent)
						}
						//console.log(tablePagination)
					}
				}else{
					//console.log("entro 3")
					//console.log(positionLi)
					if(sizeUl>3){
						var iBefore=parseInt(liElement.id)-1;
						var iActual=parseInt(liElement.id);
						var iAfter=parseInt(liElement.id)+1;
						ulParent.getElementsByTagName("li")[0].className="waves-effect color-blue-light-hocol-hover"
						ulParent.getElementsByTagName("li")[sizeUl-1].className="waves-effect color-blue-light-hocol-hover"
						for(var i=1; i<sizeUl-1; i++){
							ulParent.getElementsByTagName("li")[i].className="waves-effect color-blue-light-hocol-hover"
						}
						var lastRegister=(liElement.id)*10;
						var firstRegister=lastRegister-9;
						if(parseInt(liElement.id)==tablePagination.last){
							lastRegister=tablePagination.total
						}
						$("#load-registers").empty();
						$("#load-registers").append('<label class="left">MOSTRANDO REGISTROS: '+firstRegister+' AL '+lastRegister+' DE '+tablePagination.total+'</label>');
						document.getElementById(liElement.id).className="color-blue-light-hocol"
						_.addPaginationArray(1,parseInt(liElement.id)-1,parseInt(liElement.id),parseInt(liElement.id)+1,tablePagination.last,tablePagination.total,tablePagination.id)
						_.changePagiantionArray(iBefore, iActual)
						//console.log(tablePagination)
					}else{
						ulParent.getElementsByTagName("li")[0].className="disabled"
						ulParent.getElementsByTagName("li")[sizeUl-1].className="disabled"
					}
				}
				//console.log(tablePagination)
				/*if(pageActual==-1){
					console.log(tablePagination.actual)
				}else if(pageActual==-2){
					console.log(tablePagination.actual)
				}*/
			},
			changePagiantionArray:function(start, end){
				console.log(tablePagination.first+"-----"+tablePagination.after)
				if(start>0){
					start=start*10;
				}
				if(end == tablePagination.last || end==0){
					end=tablePagination.total
				}else{
					end=end*10;
				}
				//console.log(arrayTableHocol)
				$("tbody").empty();
				for(var i=tablePagination.first; i<tablePagination.after; i++){
					var stringAddElement="";
					var tds="";
					var toCreateElement=arrayTableHocol[i].tr;
					for(var j=0; j<toCreateElement.length; j++){
						if(toCreateElement[j].indexOf('--func--')!=-1){
							var func=toCreateElement[j].split('--func--');
							var url=func[1].split('--url--');
							//console.log(url[1])
							stringAddElement="<tr onclick='window.parent.muestra_tabla(&quot;carga-tabla&quot;,&quot;"+url[1]+"&quot;)' >";
							if(func!=undefined){
								tds=tds+"<td>"+func[0]+"</td>";
							}
						}else{
							tds=tds+"<td>"+toCreateElement[j]+"</td>";
						}
					}
					stringAddElement=stringAddElement+tds+"</tr>";
					$("tbody").append(stringAddElement)
				}
				_.addIdToTable(tablePagination.id)
			},
			addListPagination:function(){
				var totalPagination=tablePagination.last;
				var ifMore=false;
				if(totalPagination>5){
					totalPagination=5;
					ifMore=true;
				}
				$("#list-pagination").empty();
				var li='<li class="disabled" id="after"><a onClick="_.changePagiantion(this.parentElement, 0)"><i class="material-icons">&#xE5CB;</i></a></li>';
				
				for(var i=0; i<totalPagination; i++){
					if(i==0){
						li+='<li class="color-blue-light-hocol" id="'+(i+1)+'"><a onClick="_.changePagiantion(this.parentElement, this.text)">'+(i+1)+'</a></li>'
					}else{
						li+='<li class="waves-effect color-blue-light-hocol-hover" id="'+(i+1)+'"><a onClick="_.changePagiantion(this.parentElement, this.text)">'+(i+1)+'</a></li>'
					}
				}
				if(tablePagination.last <= 1){
					li+='<li class="disabled" id="next"><a onClick="_.changePagiantion(this.parentElement, 6)"><i class="material-icons">&#xE315;</i></a>'
				}else{
					li+='<li class="waves-effect color-blue-light-hocol-hover" id="next"><a onClick="_.changePagiantion(this.parentElement, 6)"><i class="material-icons">&#xE315;</i></a>'
				}
				$("#list-pagination").append(li);
			},
			addToLast:function(ulParent){
				var idLast=ulParent.getElementsByTagName("li")[5].id
				var idNext=parseInt(idLast)+1;
				$("#"+(parseInt(idLast)-4)).remove();
				$("#"+idLast).after('<li class="waves-effect color-blue-light-hocol-hover" id="'+idNext+'"><a onClick="_.changePagiantion(this.parentElement, this.text)">'+idNext+'</i></a>')
				//var sizeUl=ulParent.getElementsByTagName("li").length
				//alert(idNext)
			},
			addToFirst:function(ulParent){
				var idLast=ulParent.getElementsByTagName("li")[1].id
				var idNext=parseInt(idLast)-1;
				$("#"+(parseInt(idLast)+4)).remove();
				$("#"+idLast).before('<li class="waves-effect color-blue-light-hocol-hover" id="'+idNext+'"><a onClick="_.changePagiantion(this.parentElement, this.text)">'+idNext+'</i></a>')
			},
			resetArrayTable:function(){
				arrayTableHocol=[];
			}
		};
		return hocolTables_methods;
	}
	if(typeof window.hocolTables_methods === 'undefined'){
		window.hocolTables_methods = window._ = hocolTables()
	}
})(window, document)