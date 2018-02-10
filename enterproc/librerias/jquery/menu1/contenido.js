fixMozillaZIndex=true; //Fixes Z-Index problem  with Mozilla browsers but causes odd scrolling problem, toggle to see if it helps
_menuCloseDelay=700;
_menuOpenDelay=250;
_subOffsetTop=2;
_subOffsetLeft=-2;




with(XPMainStyle=new mm_style()){
styleid=4;
bordercolor="#1A293C";
borderstyle="solid";
borderwidth=1;
fontfamily="'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif, Tahoma,Arial, Helvetica, sans-serif";
fontsize="110%";
fontstyle="normal";
fontweight="bold";
offbgcolor="#C7422F";
offcolor="#ffffff";
onbgcolor="#ffffff";
onborder="1px solid #1A293C";
oncolor="#1A293C";
padding=9;
rawcss="padding-left:5px;padding-right:5px";
}

with(XPMenuStyle=new mm_style()){
bordercolor="#1A293C";
borderstyle="solid";
borderwidth=1;
fontfamily="'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif, Tahoma,Arial, Helvetica, sans-serif";
fontsize="100%";
fontstyle="normal";
fontweight="normal";
image="../librerias/dhtml/menu1/xpblank.gif";
imagepadding=3;
menubgimage="../librerias/dhtml/menu1/winxp_menu.gif";
offbgcolor="transparent";
offcolor="#000000";
onbgcolor="#1A293C";
onborder="1px solid #1A293C";
oncolor="#ffffff";
outfilter="randomdissolve(duration=0.3)";
overfilter="Fade(duration=0.2);Alpha(opacity=90);Shadow(color=#1A293C, Direction=135, Strength=5)";
padding=4;
separatoralign="right";
separatorcolor="#1A293C";
separatorpadding=1;
separatorwidth="80%";
subimage="http://img.milonic.com/arrow.gif";
subimagepadding=3;
menubgcolor="#ffffff";
}



with(milonic=new menuname("Main Menu")){
alwaysvisible=1;
margin=2;
orientation="horizontal";
style=XPMainStyle;	
aI("text=Requerimientos Proyectos;url=mr/index.php;");
aI("text=KPI Expediting MECL;url=kpi/index.php;");
aI("text=Seguimiento Expediting MECL;url=gestion/index.php;");
aI("text=Administración;url=javascript:ajax_carga_menu_g('minuta/reportes/reporte.asp','contenidos')");
}

