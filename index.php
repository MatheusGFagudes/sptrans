<!DOCTYPE html>
<html>

<head>
	<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
	<script type="text/javascript" src="jquery-ui.js"></script>
	<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDTMFxl13bsoNkjwGYIR9AhCOIS86GyFxk&&callback=initMap">
	</script>
	<style>
		dsds html {
			height: 100%;
		}

		body {
			background-image: url(fundo.jpeg);
			color: #F3EDED;


		}

		h5 {
			color: #000;
			margin: 0px;
			padding: 0px;
		}

		#map {
			height: 100%;
			width: 100%;

		}

		#centro {
			clear: both;
			width: 85%;
			height: 520px;
			max-width: 1300px;
			margin: auto;
			margin-bottom: 0;
			margin-top: -18px;


		}

		#aviso {
			width: 200px;
			display: none;
			background-color: #ECECE8;
			position: fixed;
			top: 0.5%;
			left: 45%;


		}

		#aviso p {
			margin: 3px;
			font-size: 20px;
			color: #808080;
			text-align: center;

		}



		#pesquisa {
			width: 72%;
			height: 140px;
			padding-top: 10px;
			float: left;
			font-size: 18px;


		}

		#pesquisa h3 {
			color: #F6F6F6;
			;


		}

		#grupo {
			margin-left: 15px;
			margin-top: 25px;
			float: left;
			font-weight: bold;
			width: 26%;
			margin-bottom: 15px;
		}

		#grupo p {

			height: 5px;


		}

		#grupo h3 {
			height: 5px;

			margin-top: 0px;
		}

		#pesquisa input {
			background-color: #F6F6F6;
			width: 80%;
			height: 25px;

		}

		#pesquisa button {
			height: 30px;
			width: 10%;

		}

		#atualizar {
			height: 20px;
			display: none;

		}

		#opcoes {
			height: 20px;
			display: none;
			margin-top: 6px;

		}

		#opcoes input {
			width: 15px;
			height: 15px;




		}


		.ui-autocomplete {


			cursor: pointer;
			font: 15px 'Open Sans', Arial;
			width: 300px;

			position: fixed;
		}

		.ui-autocomplete .ui-menu-item {
			background: #fff;
			margin-left: -38px;
			list-style: none outside none;
			width: 100.7%;
			height: 20px;

			padding-top: 5px;
		}

		.ui-autocomplete .ui-menu-item:hover {
			background: #eee
		}

		.ui-autocomplete .ui-corner-all {
			color: #666 !important;
			display: block;
		}
	</style>


	<script>
		var map;
		var geocoder;
		var marker;
		var markers = [];
		var markers1 = [];
		var locationbusca = null;
		var infowindow = null;





		function initMap() {

			infowindow = new google.maps.InfoWindow({
				content: "holding..."
			});
			var image = 'parada.png';

			var latitude = -23.5875291;
			var longitude = -46.6795128;
			var image = "boy.png"

			map = new google.maps.Map(document.getElementById('map'), {
				zoom: 18,
				center: {
					lat: latitude,
					lng: longitude
				}
			});
			marker = new google.maps.Marker({
				map: map,
				icon: image


			});

			map.addListener('dragend', function() {
				getPO();
				getOnibus();
			});
			map.addListener('zoom_changed', function() {
				getPO();
				getOnibus();
			});



		}

		function myFunction() {
			geocoder = new google.maps.Geocoder();
			var name = document.getElementById("txtEndereco").value;
			if (name != "") {
				geocoder.geocode({

					'address': name + ', São Paulo, SP',
					'country': 'BR',
				}, function(results, status) {
					if (status == google.maps.GeocoderStatus.OK) {
						if (results[0]) {
							var latitude = results[0].geometry.location.lat();
							var longitude = results[0].geometry.location.lng();


							var location = new google.maps.LatLng(latitude, longitude);
							$("#opcoes").show();
							marker.setPosition(location);
							map.setCenter(location);
							map.setZoom(18);
							getPO();
						}

					} else {
						alert(" Endereço nao existe");
					}
				});
			} else {
				alert("Insira algum endereço");
			}

		}

		//autocomplete
		$(document).ready(function() {
			$("#txtEndereco").autocomplete({
				source: function(request, response) {
					geocoder = new google.maps.Geocoder();
					geocoder.geocode({
						'address': request.term + ', São Paulo - SP',
						'region': 'BR'
					}, function(results, status) {
						response($.map(results, function(item) {
							return {
								label: item.formatted_address,
								value: item.formatted_address,
								latitude: item.geometry.location.lat(),
								longitude: item.geometry.location.lng()
							}
						}));
					})
				},
				select: function(event, ui) {
					var location = new google.maps.LatLng(ui.item.latitude, ui.item.longitude);
					$("#opcoes").show();
					marker.setPosition(location);
					map.setCenter(location);
					map.setZoom(18);
					getPO();
				}
			});
		});









		//AJax




		function getPO() {
			if (parada.checked) {


				for (i = 0; i < markers.length; i++) {
					markers[i].setMap(null);
				}
				markers = [];

				var latmax = map.getBounds().getNorthEast().lat();
				var lngmax = map.getBounds().getNorthEast().lng();
				var latmin = map.getBounds().getSouthWest().lat();
				var lngmin = map.getBounds().getSouthWest().lng();






				// ajax obter paradas onibus 
				$.ajax({
					data: {
						latmin: latmin,
						latmax: latmax,
						lngmin: lngmin,
						lngmax: lngmax
					},
					type: 'post', //Definimos o método HTTP usado
					dataType: 'json', //Definimos o tipo de retorno
					url: 'getDados.php', //Definindo o arquivo onde serão buscados os dados
					success: function(dados) {

						for (var i = 0; dados.length > i; i++) {
							var image = 'parada.png';
							var marker1;
							var markerbusca;
							var nome = null;
							var location = new google.maps.LatLng(dados[i].stop_lat, dados[i].stop_lon);

							var markerbusca = new google.maps.Marker({
								map: map,
								icon: image,
								html: nome
							});
							markerbusca.setPosition(location);

							markerbusca.setPosition(null);






							marker1 = new google.maps.Marker({
								map: map,
								icon: image,
								html: nome
							});




							google.maps.event.addListener(marker1, 'click', function() {
								geocoder.geocode({
									'latLng': this.getPosition()
								}, function(results, status) {
									if (status == google.maps.GeocoderStatus.OK) {
										if (results[0]) {
											alert(results[0].formatted_address);

										}
									}
								});




							});


							marker1.setPosition(location);



							markers.push(marker1);




						}
					},
					error: function(erro) {
						alert('deu erro não acesso aos dados');
					}


				});

			} else {
				for (i = 0; i < markers.length; i++) {
					markers[i].setMap(null);
				}
				markers = [];



			}

		}








		function getOnibus() {
			if (onibus.checked) {
				$("#aviso").show();

				$("#atualizar").show();

				for (i = 0; i < markers1.length; i++) {
					markers1[i].setMap(null);
				}
				markers1 = [];


				var latmax = map.getBounds().getNorthEast().lat();
				var lngmax = map.getBounds().getNorthEast().lng();
				var latmin = map.getBounds().getSouthWest().lat();
				var lngmin = map.getBounds().getSouthWest().lng();




				// ajax obter  onibus 
				$.ajax({
					// data: {latmin: latmin ,latmax: latmax, lngmin: lngmin, lngmax : lngmax },
					type: 'POST', //Definimos o método HTTP usado
					dataType: 'json', //Definimos o tipo de retorno
					url: 'getBus.php', //Definindo o arquivo onde serão buscados os dados
					success: function(dados) {
						if (dados != null) {
							for (var i = 0; dados.l.length > i; i++) {
								var nome = "";
								nome += ' <h4 style="color:#D7B610; margin:0; ">Ônibus </h4> <hr> <h5> Letreiro Completo:' + dados.l[i].c +
									'</h5> </br>';
								nome += '<h5> Linha:' + dados.l[i].cl + '</h5> </br>';
								if (dados.l[i].sl == 1) {
									nome += '<h5> Sentido:' + dados.l[i].lt0 + '</h5> </br>';

								} else {
									nome += '<h5> Sentido:' + dados.l[i].lt1 + '</h5> </br>';
								}



								for (var j = 0; dados.l[i].vs.length > j; j++) {




									if (dados.l[i].vs[j].py >= latmin && dados.l[i].vs[j].py <= latmax && dados.l[i].vs[j].px >= lngmin &&
										dados.l[i].vs[j].px <= lngmax) {
										var veiculo;
										veiculo = nome + '<h5> Veiculo:' + dados.l[i].vs[j].p + '</h5>';

										var image = 'Transport-School-Bus.ico';
										var marker1;


										var location = new google.maps.LatLng(dados.l[i].vs[j].py, dados.l[i].vs[j].px);
										var infowindow = new google.maps.InfoWindow({
											content: "holding..."
										});







										marker1 = new google.maps.Marker({
											map: map,
											icon: image,
											html: veiculo
										});




										google.maps.event.addListener(marker1, 'click', function() {

											infowindow.setContent(this.html);
											infowindow.open(map, this);

										});


										marker1.setPosition(location);



										markers1.push(marker1);




									}

									$("#aviso").hide();

								}

								nome = "";
							}
						} else {
							$("#aviso").hide();
							alert('Erro ao receber os parametros do sptrans, Tente Novamente');
						}


					},
					error: function(erro) {
						$("#aviso").hide();
						alert(erro);
					}


				});

			} else {
				$("#atualizar").hide();
				for (i = 0; i < markers1.length; i++) {
					markers1[i].setMap(null);
				}
				markers1 = [];



			}

		}
	</script>




</head>

<body>
	<div id="centro">


		<div id="pesquisa">
			<div id="aviso">
				<p> Carregando, aguarde ! </p>

			</div>



			<h3>Soluções Web 2017 </h3>
			<input type="text" id="txtEndereco" name="txtEndereco" onkeydown="if(event.keyCode == 13) myFunction();" />
			<button onclick="myFunction();"> Buscar</button>


			<div id="opcoes">
				<input id="onibus" type="checkbox" name="vehicle" value="Onibus" onchange="getOnibus()"> Ônibus Perto
				<input id="parada" type="checkbox" name="vehicle" value="parada" onchange="getPO()"> Paradas de Ônibus
				<button id="atualizar" onclick="getOnibus();"> Atualizar</button>
			</div>

		</div>
		
		<div id="map"></div>

	</div>
</body>

</html>