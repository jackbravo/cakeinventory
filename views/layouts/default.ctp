<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">

<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<meta name="author" content="Pavooou" />

	<?php echo $html->charset(); ?>
	<title>
		<?php echo "$title_for_layout - Sistema de Inventarios "; ?>
	</title>
	<?php
		echo $html->meta('icon');
		
		echo $javascript->link('jquery-1.4.2.min');
	 	echo $javascript->link('jquery.editable');
	 	echo $javascript->link('jquery.tablesorter.min.js');

		echo $html->css('cake.generic','stylesheet',array('media'=>'screen'));
		echo $html->css('default.axai','stylesheet',array('media'=>'screen'));
        echo $html->css('printer.axai','stylesheet',array('media'=>'print'));
		
		echo $scripts_for_layout;
	?>
	
<script type="text/javascript"> 
jQuery(function() {
  $(".tablesorter").tablesorter();
  $(".comment").editable("/ingresos/", { 
      saving : "<img src='/img/indicator.gif'>",
      type   : 'textarea',
      extraParams: { _method: "put" },
      //select : true,
      //submit : 'Guardar',
      //cancel : 'Cancelar',
      editClass : "editable"
  });
});
</script>	
</head>


<body>

	<div id="header">
		<div id="header_content">
			<a href="/pages/welcome"><img src="/img/logo.png" class="logo"/></a>
			<span class="version">v0.1</span>
			<ul>
				<li>
					<?php echo $html->link( $html->image("in_icon.png"), array('controller'=>'entradas', 'action' => 'index'), array('escape' => false)); ?>
					<?php echo $html->link('ENTRADAS', array('controller'=>'entradas', 'action' => 'index')); ?>						
				</li>
				<li>
					<?php echo $html->link( $html->image("out_icon.png"), array('controller'=>'salidas', 'action' => 'index'), array('escape' => false)); ?>
					<?php echo $html->link('SALIDAS', array('controller'=>'salidas', 'action' => 'index')); ?>	
				</li>
				<li>
					<?php echo $html->link( $html->image("inv_icon.png"), array('controller'=>'parts', 'action' => 'index'), array('escape' => false)); ?>
					<?php echo $html->link('INVENTARIO', array('controller'=>'parts', 'action' => 'index')); ?>	
				</li>
			</ul>
		</div>
	</div>
	<div id="content_wrapper">
		<div id="pre_content">
			
			
			<div id="sub_menus">
				<?php 
					switch($this->params['controller'])
					{
						case "receipts":
							?>
							<ul>
								<li class="left-round"></li>
								<li>
									<?php
										echo $html->link('NUEVA ENTRADA', array('action' => 'add'));
									?>
								</li>
								<li>
									<?php
										echo $html->link('LISTADO', array('action' => 'index'));
									?>
								</li>
								<li class="right-round"></li>
							</ul>
							<?php
						 	break;
				 		case "dispatches":
				 			?>
				 			<ul style="margin-left:130px;">
								<li class="left-round"></li>
								<li>
									<?php
										echo $html->link('NUEVA SALIDA', array('action' => 'preview'));
									?>
								</li>
								<li>
									<?php
										echo $html->link('LISTADO', array('action' => 'index'));
									?>
								</li>
								<li class="right-round"></li>
							</ul>
							<?php
				 			break;
			 			default:
			 				break;
					}
				?>
			</div>
		</div>
		<div id="content">
			<?php $session->flash(); ?>

			<?php echo $content_for_layout; ?>
		</div>
		
		<ul id="bottom_menu">
			<li>
				<?php
					echo $html->link('Entradas', array('controller' => 'entradas'));
				?>
			</li>
			<li>|</li>
			<li>
				<?php
					echo $html->link('Salidas', array('controller' => 'salidas'));
				?>
			</li>
			<li>|</li>
			<li>
				<?php
					echo $html->link('Inventario', array('controller' => 'parts'));
				?>
			</li>
		</ul>
		
	</div>
</body>
</html>
