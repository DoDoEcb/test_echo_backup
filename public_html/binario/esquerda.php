
<html>
    <head>
        <!--conteudo do head-->
    </head>
    <body onload="carregado();">

<!--
We will create a family tree using just CSS(3)
The markup will be simple nested lists
-->

<div class="bubblingG load" style="width:100%;height:100%;background:orange;position:fixed;z-index:1000;">

<br><br><br><br><br>
	<span id="bubblingG_1">
	</span>
	<span id="bubblingG_2">
	</span>
	<span id="bubblingG_3">
	</span>
</div>
<div class="container">

<ul>

<div class="tree">
<?php



error_reporting(E_ALL);


			$get  = $_GET['get'];

?>

	<ul style="margin:auto;border:0 !important;position:absolute;top:-15px;left:-5px;z-index:999;">
	<li style="margin:auto;border:0 !important;">
<a class="btn btn-danger" href="javascript:window.history.go(-1)" style="background:#fff;">Anterior</a></li>
</ul>
		<li hexacode="" check-rede='no' perna="esquerda">
				<a ><?php echo $get;?></a>


			<ul>
				<li hexacode="<?php echo $get;?>" check-rede='no' perna="esquerda">
					<a href="#" id="centro" rel='<?php echo $get;?>' hexa-target="<?php echo $get;?>"  rel='<?php echo $get;?>'check-rede='no'>Esquerda</a>

				</li>

				<li hexacode="<?php echo $get;?>" check-rede='no' perna="direita">
					<a href="#" id="centro" rel='<?php echo $get;?>' hexa-target="<?php echo $get;?>"  rel='<?php echo $get;?>'check-rede='no'>Direita</a>

				</li>
			</ul>

		</li>
	</ul>

</div>
</div>

<style>
html,body,*{

    overflow-x: visible;
	overflow-y:visible;
}

/*Now the CSS*/
* {margin: 0; padding: 0;}
.tree{
float:left;
display:block;
}
.tree ul {
display:block;
	padding-top: 20px; position: relative;

	transition: all 0.5s;
	-webkit-transition: all 0.5s;
	-moz-transition: all 0.5s;
}

.tree li {
	float: left; text-align: center;
	list-style-type: none;
	position: relative;
	padding: 20px 5px 0 5px;

	transition: all 0.5s;
	-webkit-transition: all 0.5s;
	-moz-transition: all 0.5s;
}

/*We will use ::before and ::after to draw the connectors*/

.tree li::before, .tree li::after{
	content: '';
	position: absolute; top: 0; right: 50%;
	border-top: 1px solid #ccc;
	width: 50%; height: 20px;
}
.tree li::after{
	right: auto; left: 50%;
	border-left: 1px solid #ccc;
}

/*We need to remove left-right connectors from elements without
any siblings*/
.tree li:only-child::after, .tree li:only-child::before {
	display: none;
}

/*Remove space from the top of single children*/
.tree li:only-child{ padding-top: 0;}

/*Remove left connector from first child and
right connector from last child*/
.tree li:first-child::before, .tree li:last-child::after{
	border: 0 none;
}
/*Adding back the vertical connector to the last nodes*/
.tree li:last-child::before{
	border-right: 1px solid #ccc;
	border-radius: 0 5px 0 0;
	-webkit-border-radius: 0 5px 0 0;
	-moz-border-radius: 0 5px 0 0;
}
.tree li:first-child::after{
	border-radius: 5px 0 0 0;
	-webkit-border-radius: 5px 0 0 0;
	-moz-border-radius: 5px 0 0 0;
}

/*Time to add downward connectors from parents*/
.tree ul ul::before{
	content: '';
	position: absolute; top: 0; left: 50%;
	border-left: 1px solid #ccc;
	width: 0; height: 20px;
}

.tree li a{
	border: 1px solid #ccc;
	padding: 5px 10px;
	text-decoration: none;
	color: #666;
	font-family: arial, verdana, tahoma;
	font-size: 11px;
	display: inline-block;

	border-radius: 5px;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;

	transition: all 0.5s;
	-webkit-transition: all 0.5s;
	-moz-transition: all 0.5s;
}

/*Time for some hover effects*/
/*We will apply the hover effect the the lineage of the element also*/
.tree li a:hover, .tree li a:hover+ul li a {
	background: #c8e4f8; color: #000; border: 1px solid #94a0b4;
}
/*Connector styles on hover*/
.tree li a:hover+ul li::after,
.tree li a:hover+ul li::before,
.tree li a:hover+ul::before,
.tree li a:hover+ul ul::before{
	border-color:  #94a0b4;
}

/*Thats all. I hope you enjoyed it.
Thanks :)*/
</style>
  <script type='text/javascript' src='js/jquery-1.9.1.js'></script>
    <script src='js/modernizr.min.js'></script>
  <script src='js/jquery-scrollable.js'></script>
  <script type="text/javascript">
    jQuery(function($) {
      if (!Modernizr.touch) { // if not a smartphone
        debiki.Utterscroll.enable();
      }
    });
  </script>

<script src='js/debiki-utterscroll.js'></script>
<script>

var direction = "",
    oldx = 0,
	oldy = 0,
    mousemovemethod = function (e) {

        if (e.pageX < oldx) {
            direction = "left"
        } else if (e.pageX > oldx) {
            direction = "right"
        }if (e.pageY < oldy) {
            direction = "top"
        } else if (e.pageY > oldy) {
            direction = "bottom"
        }

      //console.log(direction);

        oldx = e.pageX;
		oldy = e.pageY;

}

document.addEventListener('mousemove', mousemovemethod);
var clicked = false, clickY,clickX;
$(document).on({
    'mousemove': function(e) {
       // clicked && updateScrollPos(e);
    },
    'mousedown': function(e) {
        clicked = true;
        clickY = e.pageY;
    },
    'mouseup': function() {
        clicked = false;
        $('html').css('cursor', 'auto');
    }
});
$(document).on({
    'mousemove': function(e) {
      //  clicked && updateScrollPosX(e);
    },
    'mousedown': function(e) {
        clicked = true;
        clickX = e.pageX
    },
    'mouseup': function() {
        clicked = false;
        $('html').css('cursor', 'auto');
    }
});

var x, y;


$(document).on({
    'mousemove': function(e) {
       if(clicked == true){
		console.log(e);
		var offset = $('.tree').offset();
  var relativeX = (e.pageX - offset.left);
  var relativeY = (e.pageY - offset.top);

  console.log("X: " + relativeX + "  Y: " + relativeY + " dir:" + direction);
  if(direction == 'top'){
  var p = $( ".tree" );
var position = p.position();
var top = e.pageX;
  //console.log(top);
   //$('.teste').animate({ 'margin-top': top },0);
  }

			//$('.tree,.teste').css({'margin-left':(relativeY)});
	   }
    },
    'mousedown': function(e) {
        clicked = true;
        clickY = e.pageY;
    },
    'mouseup': function() {
        clicked = false;
        $('html').css('cursor', 'auto');
    }
});

function handleMouse(e) {
  // Verify that x and y already have some value
  if (x && y) {
    // Scroll window by difference between current and previous positions
    window.scrollBy(e.clientX - x, e.clientY - y);
  }

  // Store current position
  x = e.clientX;
  y = e.clientY;
}

// Assign handleMouse to mouse movement events
//document.onmousemove = handleMouse;
/*
var updateScrollPos = function(e) {
    $('html').css('cursor', 'row-resize');
    $(window).scrollTop($(window).scrollTop() + (clickY - e.pageY));
}

var updateScrollPosX = function(e) {
    $('html').css('cursor', 'row-resize');
    $(window).scrollTop($(window).scrollTop() + (clickX- e.pageX));
}*/

function disableselect(e){
return false
}
function reEnable(){
return true
}
document.onselectstart=new Function ("return false")
if (window.sidebar){
document.onmousedown=disableselect
//document.onclick=reEnable
}

$(function(){




	//busca_rede();

	<?php

@mysql_connect('localhost','root','vertrigo')or die(mysql_error());

@mysql_select_db('system_data')or die(mysql_error());

$teste = "";
error_reporting(E_ALL);

$pessoa = mysql_query("SELECT * FROM rede_binaria WHERE personal_id = '$get' and log_perna = 'direita' ")or die(mysql_error());

			if(mysql_num_rows($pessoa) > 0){

				while($res = mysql_fetch_object($pessoa)){
					$teste .= "{".$res->indicado_id." : ".$res->personal_id."},";
				}

			}
?>
hexa = [<?php echo $teste;?>];

	for(var i in hexa){

		for(var u in hexa[i]){
			filho = u;
			pai = hexa[i][u];

			console.log($('li hexa-code['+pai+'] ').find('ul').size());
			target =$('li[hexacode='+pai+'][perna=direita]');
			if(target.find('ul').size() <= 0){
				console.log(target);

				target.append('<ul><li hexacode="'+filho+'"><a target="'+pai+'" rel="'+filho+'">'+filho+'</a><ul><li class="buscar"  ok="false" perna="esquerda" pessoa="'+filho+'"><a>esquerda</a></li><li class="buscar"   ok="false"  perna="direita" pessoa="'+filho+'"><a>direita</a></li></ul></li></ul>');
				//aumenta();
			}else{
				target.find('ul').append('<li hexacode="'+filho+'"><a target="'+pai+'" rel="'+filho+'">'+filho+'</a><ul><li class="buscar"  ok="false" perna="esquerda" pessoa="'+filho+'"><a>esquerda</a></li><li class="buscar"  ok="false"   perna="direita" pessoa="'+filho+'"><a>direita</a></li></ul></li>');
				//aumenta();
			}

		}

	}


	<?php

$teste = "";
error_reporting(E_ALL);

$pessoa = mysql_query("SELECT * FROM rede_binaria WHERE personal_id = '$get' and log_perna = 'esquerda' ")or die(mysql_error());

			if(mysql_num_rows($pessoa) > 0){

				while($res = mysql_fetch_object($pessoa)){
					$teste .= "{".$res->indicado_id." : ".$res->personal_id."},";
				}

			}
?>
hexa = [<?php echo $teste;?>];

	for(var i in hexa){

		for(var u in hexa[i]){
			filho = u;
			pai = hexa[i][u];

			console.log($('li hexa-code['+pai+'] ').find('ul').size());
			target =$('li[hexacode='+pai+'][perna=esquerda]');
			if(target.find('ul').size() <= 0){
				console.log(target);

				target.append('<ul><li hexacode="'+filho+'"><a target="'+pai+'" rel="'+filho+'">'+filho+'</a><ul><li class="buscar"  ok="false" perna="esquerda" pessoa="'+filho+'"><a>esquerda</a></li><li class="buscar"   ok="false"  perna="direita" pessoa="'+filho+'"><a>direita</a></li></ul></li></ul>');
				//aumenta();
			}else{
				target.find('ul').append('<li hexacode="'+filho+'"><a target="'+pai+'" rel="'+filho+'">'+filho+'</a><ul><li class="buscar"  ok="false" perna="esquerda" pessoa="'+filho+'"><a>esquerda</a></li><li class="buscar"  ok="false"   perna="direita" pessoa="'+filho+'"><a>direita</a></li></ul></li>');
				//aumenta();
			}

		}

	}
	$('a[check-rede=no] ').click(function(){
		__this = $(this);
		target = __this.attr('hexa-target');
		console.log(target);
				$.ajax({
				url : 'busca_rede.php?target='+target,
				success : function(retorno){

					__this.attr('check-rede','ok');

					if(retorno != ''){

						$('li[hexa-code='+target+']').append(retorno);
						//busca_rede();
					}

					//busca_rede();
				}}
				);
	});


	function aumenta(){
	quant = $('.tree a').size();
	var i = 0;
			$('.tree a').each(function(){
			i++;
					var target = $(this).attr('target');
					if(target >= 0){
					var posicao_pai = $('a[rel='+target+']');
					var posicao_pai = posicao_pai.offset();

					var posicao_filho = $(this);
					var posicao_filho = posicao_filho.offset();

					if(posicao_filho.top-posicao_pai.top >= 100){
						$('.teste').width($('.teste').width()+$(this).width());
					}


					}

					if(i == quant){
					//console.log(i +'tanto ' + quant);
					$('body').delay(0).show(function(){
					//aumenta();
					});
					}

			});

	}
	function busca_rede(){


	}

	function busca_subrede(){
		$('body').delay(500).show(function(){

			$('.buscar[ok=false]').each(function(){
				_this = $(this);
				//__this.attr('ok','ok');
				perna = $(this).attr('perna');
				id = $(this).attr('pessoa');

				console.log('dusca ' +perna + ' de '+ id );
				buscar_de(perna,id,_this);
				//busca_subrede();

			});

		});
	}
	$('.buscar').each(function(){
				_this = $(this);
				//__this.attr('ok','ok');
				perna = $(this).attr('perna');
				id = $(this).attr('pessoa');

				console.log('dusca ' +perna + ' de '+ id );
				buscar_de(perna,id,_this);
				//busca_subrede();

			});

	 busca_subrede();
	function buscar_de(perna,id,__this){
		$.ajax({
					url : 'buscar_rede.php?id='+id+'&perna='+perna,
					success : function(retorno){
						__this.removeClass('buscar');
						__this.html(retorno);
						$('.buscar2').find('a').click(function(){
							_this = $(this);
							//__this.attr('ok','ok');
							perna = _this.attr('perna');
							id = _this.attr('rel');

							window.location = '?get='+id;
							//busca_subrede();

						});

					}
				});

	}
	function alinha(){
		$('.container').css({

        //'left' : '50%',
       // 'top' : '50%',
       // 'margin-left' : $('.container').width()/2,
       // 'margin-top' : -$('ul:first').height()/2
		});
	}
	var myVar = setInterval(function(){ myTimer() }, 1000);

function myTimer() {
   // busca_subrede();
  // busca_subrede();
}

function myStopFunction() {
    clearInterval(myVar);
}


	//$('ul:first').center();
});
function carregado(){
	$('.load').delay(2000).show(500,function(){
		$('.load').fadeOut(500);
	});
}
</script>

<style>
body{
	overflow:hidden;
}
.container {
	width : 31000000px;
border:#aeaeae 0px solid;
float:left;
overflow:hidden;
padding:10px;
}

.bubblingG {
	text-align: center;
	width:78px;
	height:49px;
	margin: auto;
}

.bubblingG span {
	display: inline-block;
	vertical-align: middle;
	width: 10px;
	height: 10px;
	margin: 24px auto;
	background: rgb(0,0,0);
	border-radius: 49px;
		-o-border-radius: 49px;
		-ms-border-radius: 49px;
		-webkit-border-radius: 49px;
		-moz-border-radius: 49px;
	animation: bubblingG 1.5s infinite alternate;
		-o-animation: bubblingG 1.5s infinite alternate;
		-ms-animation: bubblingG 1.5s infinite alternate;
		-webkit-animation: bubblingG 1.5s infinite alternate;
		-moz-animation: bubblingG 1.5s infinite alternate;
}

#bubblingG_1 {
	animation-delay: 0s;
		-o-animation-delay: 0s;
		-ms-animation-delay: 0s;
		-webkit-animation-delay: 0s;
		-moz-animation-delay: 0s;
}

#bubblingG_2 {
	animation-delay: 0.45s;
		-o-animation-delay: 0.45s;
		-ms-animation-delay: 0.45s;
		-webkit-animation-delay: 0.45s;
		-moz-animation-delay: 0.45s;
}

#bubblingG_3 {
	animation-delay: 0.9s;
		-o-animation-delay: 0.9s;
		-ms-animation-delay: 0.9s;
		-webkit-animation-delay: 0.9s;
		-moz-animation-delay: 0.9s;
}



@keyframes bubblingG {
	0% {
		width: 10px;
		height: 10px;
		background-color:rgb(0,0,0);
		transform: translateY(0);
	}

	100% {
		width: 23px;
		height: 23px;
		background-color:rgb(255,255,255);
		transform: translateY(-20px);
	}
}

@-o-keyframes bubblingG {
	0% {
		width: 10px;
		height: 10px;
		background-color:rgb(0,0,0);
		-o-transform: translateY(0);
	}

	100% {
		width: 23px;
		height: 23px;
		background-color:rgb(255,255,255);
		-o-transform: translateY(-20px);
	}
}

@-ms-keyframes bubblingG {
	0% {
		width: 10px;
		height: 10px;
		background-color:rgb(0,0,0);
		-ms-transform: translateY(0);
	}

	100% {
		width: 23px;
		height: 23px;
		background-color:rgb(255,255,255);
		-ms-transform: translateY(-20px);
	}
}

@-webkit-keyframes bubblingG {
	0% {
		width: 10px;
		height: 10px;
		background-color:rgb(0,0,0);
		-webkit-transform: translateY(0);
	}

	100% {
		width: 23px;
		height: 23px;
		background-color:rgb(255,255,255);
		-webkit-transform: translateY(-20px);
	}
}

@-moz-keyframes bubblingG {
	0% {
		width: 10px;
		height: 10px;
		background-color:rgb(0,0,0);
		-moz-transform: translateY(0);
	}

	100% {
		width: 23px;
		height: 23px;
		background-color:rgb(255,255,255);
		-moz-transform: translateY(-20px);
	}
}


</style>
    </body>
</html>

