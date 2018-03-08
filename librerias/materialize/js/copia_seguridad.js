else if(liElement.id=="next"){
					for(var i=1; i<sizeUl-1; i++){
						var iBefore=parseInt(ulParent.getElementsByTagName("li")[i].id);
						var iActual=parseInt(ulParent.getElementsByTagName("li")[i].id)+1;
						var iAfter=parseInt(ulParent.getElementsByTagName("li")[i].id)+2;
						console.log(iBefore+"----"+(sizeUl-3))
						var lastRegister=(parseInt(ulParent.getElementsByTagName("li")[iActual].id))*10;
						var firstRegister=lastRegister-9;
						
						if(i==tablePagination.last){
							lastRegister=tablePagination.total
						}
						if(ulParent.getElementsByTagName("li")[iBefore].className=="color-blue-light-hocol" && iBefore<sizeUl-3){
							console.log("entro 1")
							$("#load-registers").empty();
							ulParent.getElementsByTagName("li")[iBefore].className="waves-effect color-blue-light-hocol-hover"
							ulParent.getElementsByTagName("li")[iActual].className="color-blue-light-hocol"
							ulParent.getElementsByTagName("li")[0].className="waves-effect color-blue-light-hocol-hover"
							ulParent.getElementsByTagName("li")[sizeUl-1].className="waves-effect color-blue-light-hocol-hover"
							_.addPaginationArray(1,iBefore,iActual,iAfter,tablePagination.last,tablePagination.total,tablePagination.id)
							_.changePagiantionArray(tablePagination.after, tablePagination.actual)
							if((parseInt(ulParent.getElementsByTagName("li")[iActual].id))==tablePagination.last){
								lastRegister=tablePagination.total
							}
							//console.log(parseInt(ulParent.getElementsByTagName("li")[iActual].id))
							$("#load-registers").append('<label class="left">MOSTRANDO REGISTROS: '+firstRegister+' AL '+lastRegister+' DE '+tablePagination.total+'</label>');
							//console.log(tablePagination)
							return;
						}else if(ulParent.getElementsByTagName("li")[iBefore].className=="color-blue-light-hocol" && iBefore<sizeUl-2){
							console.log("entro 2")
							$("#load-registers").empty();
							ulParent.getElementsByTagName("li")[iBefore].className="waves-effect color-blue-light-hocol-hover"
							ulParent.getElementsByTagName("li")[iActual].className="color-blue-light-hocol"
							ulParent.getElementsByTagName("li")[0].className="waves-effect color-blue-light-hocol-hover"
							ulParent.getElementsByTagName("li")[sizeUl-1].className="disabled"
							if(ifMore==true && (parseInt(ulParent.getElementsByTagName("li")[iActual].id))<(totalPagination)){
								_.addPaginationArray(1,iBefore,iActual,0,tablePagination.last,tablePagination.total,tablePagination.id)
							}
							//console.log(parseInt(ulParent.getElementsByTagName("li")[iActual].id))
							_.changePagiantionArray(tablePagination.after, tablePagination.actual)
							if((parseInt(ulParent.getElementsByTagName("li")[iActual].id))==tablePagination.last){
								lastRegister=tablePagination.total
							}
							$("#load-registers").append('<label class="left">MOSTRANDO REGISTROS: '+firstRegister+' AL '+lastRegister+' DE '+tablePagination.total+'</label>');
							//console.log(i+"---"+sizeUl-2)
							if(ifMore==true && (parseInt(ulParent.getElementsByTagName("li")[iActual].id))<(totalPagination)){
								_.addPaginationArray(1,iBefore+1,iActual+1,iAfter+1,tablePagination.last,tablePagination.total,tablePagination.id)
								ulParent.getElementsByTagName("li")[sizeUl-1].className="waves-effect color-blue-light-hocol-hover"
								_.addToLast(ulParent)
								console.log(tablePagination)
								//console.log(arrayTable)
							}
							return;
						}
					}
				}