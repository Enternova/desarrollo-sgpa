<script>
fixMozillaZIndex=true; //Fixes Z-Index problem  with Mozilla browsers but causes odd scrolling problem, toggle to see if it helps
_menuCloseDelay=700;
_menuOpenDelay=250;
_subOffsetTop=2;
_subOffsetLeft=-2;




with(XPMainStyle=new mm_style()){
styleid=4;
bordercolor="#4491BF";
borderstyle="solid";
borderwidth=1;
fontfamily="'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif, Tahoma,Arial, Helvetica, sans-serif";
fontsize="110%";
fontstyle="normal";
fontweight="bold";
offbgcolor="#4491BF";
offcolor="#ffffff";
onbgcolor="#ffffff";
onborder="1px solid #1A293C";
oncolor="#1A293C";
padding=9;
rawcss="padding-left:5px;padding-right:5px";
}

with(XPMenuStyle=new mm_style()){
bordercolor="#4491BF";
borderstyle="solid";
borderwidth=1;
fontfamily="'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif, Tahoma,Arial, Helvetica, sans-serif";
fontsize="100%";
fontstyle="normal";
fontweight="normal";
image="../librerias/jquery/menu1/xpblank.gif";
imagepadding=3;
menubgimage="../librerias/jquery/menu1/winxp_menu.gif";
offbgcolor="transparent";
offcolor="#000000";
onbgcolor="#4491BF";
onborder="1px solid #4491BF";
oncolor="#ffffff";
outfilter="randomdissolve(duration=0.3)";
overfilter="Fade(duration=0.2);Alpha(opacity=90);Shadow(color=#1A293C, Direction=135, Strength=5)";
padding=4;
separatoralign="right";
separatorcolor="#4491BF";
separatorpadding=1;
separatorwidth="80%";
subimage="../librerias/jquery/menu1/arrow.gif";
subimagepadding=3;
menubgcolor="#ffffff";
}



with(milonic=new menuname("Main Menu")){
alwaysvisible=1;
margin=2;
orientation="horizontal";
style=XPMainStyle;	
aI("text=Administración de proveedores;showmenu=proveedores;");
aI("text=Administración de procesos;showmenu=procesos;");
aI("text=Lista de precios acordados;showmenu=lista_precios;");
aI("text=Reportes;showmenu=reportes");
aI("text=Panel de Control;showmenu=panel;");
aI("text=Salir;url=../");
}


with(milonic=new menuname("proveedores")){
margin=2;
style=XPMenuStyle;
aI("image=../librerias/jquery/menu1/separador.gif;text=Historico de proveedores;url=javascript:ajax_carga('../aplicaciones/historico_proveedores.php','contenidos');");
}


with(milonic=new menuname("procesos")){
margin=2;
style=XPMenuStyle;
aI("image=../librerias/jquery/menu1/separador.gif;text=Crear nuevo procesos;url=javascript:ajax_carga('../aplicaciones/crea_proceso.php','contenidos');");
aI("image=../librerias/jquery/menu1/separador.gif;text=Historico de procesos;url=javascript:ajax_carga('../aplicaciones/historico_procesos.php?tipo_ingreso_alerta=0','contenidos');");
aI("image=../librerias/jquery/menu1/separador.gif;text=Administración de categorias juridicas;url=javascript:ajax_carga('kpi/crea_kpi.php','contenidos');");
aI("image=../librerias/jquery/menu1/separador.gif;text=Administración de categorias técnicas;url=javascript:ajax_carga('kpi/crea_kpi.php','contenidos');");
}

with(milonic=new menuname("lista_precios")){
margin=2;
style=XPMenuStyle;
aI("image=../librerias/jquery/menu1/separador.gif;text=Crear solicitud;url=javascript:ajax_carga('../aplicaciones/lista_precios/crea_solicitudes.php','contenidos');");
aI("image=../librerias/jquery/menu1/separador.gif;text=historico de solicitudes;url=javascript:ajax_carga('../aplicaciones/lista_precios/historico_solicitudes.php','contenidos');");
aI("image=../librerias/jquery/menu1/separador.gif;text=Configurar usuarios;url=javascript:ajax_carga('../aplicaciones/lista_precios/usuarios.php','contenidos');");
}

with(milonic=new menuname("reportes")){
margin=2;
style=XPMenuStyle;
aI("image=../librerias/jquery/menu1/separador.gif;text=Reporte de accesos al sistema;url=javascript:ajax_carga('kpi/crea_kpi.php','contenidos');");
aI("image=../librerias/jquery/menu1/separador.gif;text=Reporte procesos;url=javascript:ajax_carga('kpi/crea_kpi.php','contenidos');");
aI("image=../librerias/jquery/menu1/separador.gif;text=Reporte solicitudes de pedidos;url=javascript:ajax_carga('kpi/crea_kpi.php','contenidos');");
}

with(milonic=new menuname("panel")){
margin=2;
style=XPMenuStyle;
aI("image=../librerias/jquery/menu1/separador.gif;text=Administración de usuarios;url=javascript:ajax_carga('kpi/crea_kpi.php','contenidos');");
aI("image=../librerias/jquery/menu1/separador.gif;text=Administración de idiomas;url=javascript:ajax_carga('kpi/crea_kpi.php','contenidos');");
aI("image=../librerias/jquery/menu1/separador.gif;text=Administración de maestras;url=javascript:ajax_carga('kpi/crea_kpi.php','contenidos');");
}


</script>