<%
		
de = Request.ServerVariables("HTTP_HOST")

us_local = request.servervariables("LOGON_USER")

response.Write("ip cliente: "&request.servervariables("REMOTE_ADDR")&" "&us_local)
%>