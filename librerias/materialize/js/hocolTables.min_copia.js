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
		arrayTable=[],
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
							arrayTable.push(obj)
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
                arrayTable.sort(function(a,b){
                	if (a.row > b.row) {
						return 1;
					}
					if (a.row < b.row) {
						return -1;
					}
					return 0;
                })
                var number_colums=arrayTable.length,number_total=arrayTable.length;
                var totalPages=""+number_colums/10, findFloat=0;
                findFloat=totalPages.indexOf(".")
                if(findFloat==1){
                	//si es decimal se corta la cadena y se aproxima al numero siguiente
                	totalPages=totalPages.split(".")
                	totalPages=parseInt(totalPages[0])
                	totalPages=totalPages+1;
                }
                _.addPaginationArray(1,0,1,2,totalPages,number_total,id_table)
                _.changePagiantionArrayNext(0, 1)
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
							arrayTable.push(obj)
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
                arrayTable.sort(function(b,a){
                	if (a.row > b.row) {
						return 1;
					}
					if (a.row < b.row) {
						return -1;
					}
					return 0;
                })
                var number_colums=arrayTable.length,number_total=arrayTable.length;
                var totalPages=""+number_colums/10, findFloat=0;
                findFloat=totalPages.indexOf(".")
                if(findFloat==1){
                	//si es decimal se corta la cadena y se aproxima al numero siguiente
                	totalPages=totalPages.split(".")
                	totalPages=parseInt(totalPages[0])
                	totalPages=totalPages+1;
                }
                _.addPaginationArray(1,0,1,2,totalPages,number_total,id_table)
                _.changePagiantionArrayBefore(0, 1)
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
							arrayTable.push(obj)
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
                arrayTable.sort(function(b,a){
                	if (a.row > b.row) {
						return 1;
					}
					if (a.row < b.row) {
						return -1;
					}
					return 0;
                })
                var number_colums=arrayTable.length,number_total=arrayTable.length;
                var totalPages=""+number_colums/10, findFloat=0;
                findFloat=totalPages.indexOf(".")
                if(findFloat==1){
                	//si es decimal se corta la cadena y se aproxima al numero siguiente
                	totalPages=totalPages.split(".")
                	totalPages=parseInt(totalPages[0])
                	totalPages=totalPages+1;
                }
                _.addPaginationArray(1,0,1,2,totalPages,number_total,id_table)
                _.changePagiantionArrayNext(0, 1)
                //console.log(tablePagination)
                _.addIdToTable(id_table)
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
			changePagiantion:function(pageActual){
				var liElement=pageActual
				var ulParent=liElement.parentElement
				var sizeUl=ulParent.getElementsByTagName("li").length
				var totalPagination=tablePagination.last;
				var ifMore=false;
				if(totalPagination>5){
					//totalPagination=5;
					ifMore=true;
				}
				if(liElement.id=="after"){
					for(var i=sizeUl-2; i>=1; i--){
						console.log(parseInt(ulParent.getElementsByTagName("li")[i].id))
						var iBefore=parseInt(ulParent.getElementsByTagName("li")[i].id)-2;
						var iActual=parseInt(ulParent.getElementsByTagName("li")[i].id)-1;
						var iAfter=parseInt(ulParent.getElementsByTagName("li")[i].id);
						console.log(iBefore+"----"+iActual+"---"+iAfter)
						var lastRegister=(parseInt(ulParent.getElementsByTagName("li")[iActual].id))*10;
						var firstRegister=lastRegister-9;
						if(ulParent.getElementsByTagName("li")[iAfter].className=="color-blue-light-hocol" && iAfter>2){
							//console.log("entro 1")
							$("#load-registers").empty();
							ulParent.getElementsByTagName("li")[iAfter].className="waves-effect color-blue-light-hocol-hover"
							ulParent.getElementsByTagName("li")[iActual].className="color-blue-light-hocol"
							ulParent.getElementsByTagName("li")[0].className="waves-effect color-blue-light-hocol-hover"
							ulParent.getElementsByTagName("li")[sizeUl-1].className="waves-effect color-blue-light-hocol-hover"
							_.addPaginationArray(1,iBefore,iActual,iAfter,tablePagination.last,tablePagination.total,tablePagination.id)
							_.changePagiantionArrayBefore(tablePagination.actual, tablePagination.after)
							if((parseInt(ulParent.getElementsByTagName("li")[iAfter+1].id))==tablePagination.last){
								lastRegister=tablePagination.total
							}
							$("#load-registers").append('<label class="left">MOSTRANDO REGISTROS: '+firstRegister+' AL '+lastRegister+' DE '+tablePagination.total+'</label>');
							console.log(tablePagination)
							return;
						}else if(ulParent.getElementsByTagName("li")[iAfter].className=="color-blue-light-hocol" && iAfter==2){
							console.log("entro 2")
							$("#load-registers").empty();
							ulParent.getElementsByTagName("li")[iAfter].className="waves-effect color-blue-light-hocol-hover"
							ulParent.getElementsByTagName("li")[iActual].className="color-blue-light-hocol"
							ulParent.getElementsByTagName("li")[0].className="disabled"
							ulParent.getElementsByTagName("li")[sizeUl-1].className="waves-effect color-blue-light-hocol-hover"
							_.addPaginationArray(1,iBefore,iActual,iAfter,tablePagination.last,tablePagination.total,tablePagination.id)
							_.changePagiantionArrayBefore(tablePagination.actual, tablePagination.after)
							if(i-1==tablePagination.last){
								lastRegister=tablePagination.total
							}
							$("#load-registers").append('<label class="left">MOSTRANDO REGISTROS: '+firstRegister+' AL '+lastRegister+' DE '+tablePagination.total+'</label>');
							//console.log(tablePagination)
							return;
						}
					}
				}else if(liElement.id=="next"){
					for(var i=1; i<sizeUl-1; i++){
						var iBefore=parseInt(ulParent.getElementsByTagName("li")[i].id);
						var iActual=parseInt(ulParent.getElementsByTagName("li")[i].id)+1;
						var iAfter=parseInt(ulParent.getElementsByTagName("li")[i].id)+2;
						//console.log(iBefore+"----"+(sizeUl-3))
						var lastRegister=(parseInt(ulParent.getElementsByTagName("li")[iActual].id))*10;
						var firstRegister=lastRegister-9;
						
						if(i==tablePagination.last){
							lastRegister=tablePagination.total
						}
						if(ulParent.getElementsByTagName("li")[iBefore].className=="color-blue-light-hocol" && iBefore<sizeUl-3){
							//console.log("entro 1")
							$("#load-registers").empty();
							ulParent.getElementsByTagName("li")[iBefore].className="waves-effect color-blue-light-hocol-hover"
							ulParent.getElementsByTagName("li")[iActual].className="color-blue-light-hocol"
							ulParent.getElementsByTagName("li")[0].className="waves-effect color-blue-light-hocol-hover"
							ulParent.getElementsByTagName("li")[sizeUl-1].className="waves-effect color-blue-light-hocol-hover"
							_.addPaginationArray(1,iBefore,iActual,iAfter,tablePagination.last,tablePagination.total,tablePagination.id)
							_.changePagiantionArrayNext(tablePagination.after, tablePagination.actual)
							if((parseInt(ulParent.getElementsByTagName("li")[iActual].id))==tablePagination.last){
								lastRegister=tablePagination.total
							}
							//console.log(parseInt(ulParent.getElementsByTagName("li")[iActual].id))
							$("#load-registers").append('<label class="left">MOSTRANDO REGISTROS: '+firstRegister+' AL '+lastRegister+' DE '+tablePagination.total+'</label>');
							//console.log(tablePagination)
							return;
						}else if(ulParent.getElementsByTagName("li")[iBefore].className=="color-blue-light-hocol" && iBefore<sizeUl-2){
							//console.log((parseInt(ulParent.getElementsByTagName("li")[iActual].id))+"-----"+(totalPagination))
							$("#load-registers").empty();
							ulParent.getElementsByTagName("li")[iBefore].className="waves-effect color-blue-light-hocol-hover"
							ulParent.getElementsByTagName("li")[iActual].className="color-blue-light-hocol"
							ulParent.getElementsByTagName("li")[0].className="waves-effect color-blue-light-hocol-hover"
							ulParent.getElementsByTagName("li")[sizeUl-1].className="disabled"
							if(ifMore==true && (parseInt(ulParent.getElementsByTagName("li")[iActual].id))<(totalPagination)){
								_.addPaginationArray(1,iBefore,iActual,0,tablePagination.last,tablePagination.total,tablePagination.id)
								//console.log("1")
							}else if(ifMore==false){
								_.addPaginationArray(1,iBefore,iActual,0,tablePagination.last,tablePagination.total,tablePagination.id)
								//console.log("1")
							}
							//console.log(parseInt(ulParent.getElementsByTagName("li")[iActual].id))
							_.changePagiantionArrayNext(tablePagination.after, tablePagination.actual)
							if((parseInt(ulParent.getElementsByTagName("li")[iActual].id))==tablePagination.last){
								lastRegister=tablePagination.total
							}
							$("#load-registers").append('<label class="left">MOSTRANDO REGISTROS: '+firstRegister+' AL '+lastRegister+' DE '+tablePagination.total+'</label>');
							//console.log(i+"---"+sizeUl-2)
							if(ifMore==true && (parseInt(ulParent.getElementsByTagName("li")[iActual].id))<(totalPagination)){
								_.addPaginationArray(1,iBefore+1,iActual+1,iAfter+1,tablePagination.last,tablePagination.total,tablePagination.id)
								ulParent.getElementsByTagName("li")[sizeUl-1].className="waves-effect color-blue-light-hocol-hover"
								_.addToLast(ulParent)
								//console.log(tablePagination)
								//console.log("2")
								//console.log(arrayTable)
							}
							return;
						}
					}
				}else if(liElement.id==1){
					if(sizeUl>3){
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
						_.addPaginationArray(1,0,1,2,tablePagination.last,tablePagination.total,tablePagination.id)
						_.changePagiantionArrayNext(tablePagination.after, tablePagination.actual)
						//console.log(tablePagination)
					}
				}
				else if(liElement.id==sizeUl-2){
					if(sizeUl>3){
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
						_.addPaginationArray(1,parseInt(liElement.id)-1,parseInt(liElement.id),0,tablePagination.last,tablePagination.total,tablePagination.id)
						_.changePagiantionArrayNext(tablePagination.after, tablePagination.actual)
						//console.log(tablePagination)
					}
				}else{
					if(sizeUl>3){
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
						_.changePagiantionArrayNext(tablePagination.after, tablePagination.actual)
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
			changePagiantionArrayNext:function(start, end){
				if(start>0){
					start=start*10;
				}
				if(end == tablePagination.last || end==0){
					end=tablePagination.total
				}else{
					end=end*10;
				}
				//console.log(arrayTable)
				$("tbody").empty();
				for(var i=start; i<end; i++){
					var stringAddElement="<tr>";
					var toCreateElement=arrayTable[i].tr;
					for(var j=0; j<toCreateElement.length; j++){
						stringAddElement=stringAddElement+"<td>"+toCreateElement[j]+"</td>";
					}
					stringAddElement=stringAddElement+"</tr>";
					$("tbody").append(stringAddElement)
				}
				_.addIdToTable(tablePagination.id)
			},
			changePagiantionArrayBefore:function(start, end){
				if(start>0){
					start=start*10;
				}
				if(end == tablePagination.last || end==0){
					end=tablePagination.total
				}else{
					end=end*10;
				}
				//console.log(arrayTable)
				$("tbody").empty();
				for(var i=start; i>end; i--){
					var stringAddElement="<tr>";
					var toCreateElement=arrayTable[i].tr;
					for(var j=0; j<toCreateElement.length; j++){
						stringAddElement=stringAddElement+"<td>"+toCreateElement[j]+"</td>";
					}
					stringAddElement=stringAddElement+"</tr>";
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
				var li='<li class="disabled" id="after"><a onClick="_.changePagiantion(this.parentElement)"><i class="material-icons">&#xE5CB;</i></a></li>';
				
				for(var i=0; i<totalPagination; i++){
					if(i==0){
						li+='<li class="color-blue-light-hocol" id="'+(i+1)+'"><a onClick="_.changePagiantion(this.parentElement)">'+(i+1)+'</a></li>'
					}else{
						li+='<li class="waves-effect color-blue-light-hocol-hover" id="'+(i+1)+'"><a onClick="_.changePagiantion(this.parentElement)">'+(i+1)+'</a></li>'
					}
				}
				if(tablePagination.last <= 1){
					li+='<li class="disabled" id="next"><a onClick="_.changePagiantion(this.parentElement)"><i class="material-icons">&#xE315;</i></a>'
				}else{
					li+='<li class="waves-effect color-blue-light-hocol-hover" id="next"><a onClick="_.changePagiantion(this.parentElement)"><i class="material-icons">&#xE315;</i></a>'
				}
				$("#list-pagination").append(li);
			},
			addToLast:function(ulParent){
				var idLast=ulParent.getElementsByTagName("li")[5].id
				var idNext=parseInt(idLast)+1;
				$("#"+(parseInt(idLast)-4)).remove();
				$("#"+idLast).after('<li class="waves-effect color-blue-light-hocol-hover" id="'+idNext+'"><a onClick="_.changePagiantion(this.parentElement)">'+idNext+'</i></a>')
				//var sizeUl=ulParent.getElementsByTagName("li").length
				//alert(idNext)
			}
		};
		return hocolTables_methods;
	}
	if(typeof window.hocolTables_methods === 'undefined'){
		window.hocolTables_methods = window._ = hocolTables()
	}
})(window, document)