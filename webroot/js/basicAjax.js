/**		Copyright: www.teporingo.com
*
*		BASIC AJAX v1.0.1
*		MADE BY: jpabluz
*		BASED ON: Sisco from Cristalab (www.cristalab.com)
*
*		This code is given "AS IS". 
*		It is published under the MIT License.
*		All upgrades should be notified to juanpablo@teporingo.com
*		Please, keep up the open source community alive.
*
*		Changes:
*		v1.0.1
*		- Now the xhr object is returned from the js function, so it can be aborted.
**/
function basicAjax (url, element, functionOnLoad)
{   
	 var pagina_requerida = false;    
	 if (window.XMLHttpRequest)    // Si es Mozilla, Safari etc      
     {          
	 	pagina_requerida = new XMLHttpRequest ();    
	 } 
	 else if (window.ActiveXObject)  // pero si es IE       
	 {        
	 	try
	    {           
	 		pagina_requerida = new ActiveXObject ("Msxml2.XMLHTTP");        
		} 
		catch (e)  // en caso que sea una versión antigua
		{                       
			try 
			{                
				pagina_requerida = new ActiveXObject ("Microsoft.XMLHTTP"); 
   			} 
   			catch (e)  { }   
		} 
      }     
	  else    return false;    
			  
	  pagina_requerida.onreadystatechange = function ()    // función de respuesta
	  {                
	  		cargarpagina (pagina_requerida, element, functionOnLoad);   
      }    
			   
      pagina_requerida.open ('GET', url, true); // asignamos los métodos open y send 
      pagina_requerida.send (null);
      return pagina_requerida;
}

  
function cargarpagina (pagina_requerida, element, functionOnLoad)
{   
    if (pagina_requerida.readyState == 4 && (pagina_requerida.status == 200 || window.location.href.indexOf ("http") == - 1))
	{ 
	  if (element != null && element != undefined)
	  {
      	element.innerHTML = pagina_requerida.responseText;
      }
      if (functionOnLoad != undefined)
      {
      	functionOnLoad(pagina_requerida.responseText);
      }
 	}
}