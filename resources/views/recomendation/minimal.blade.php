<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Recomendation system</title>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
		<!-- Latest compiled and minified JavaScript -->
		<link href="http://visjs.org/dist/vis-network.min.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="http://visjs.org/dist/vis.js"></script>
		<script type="text/javascript">
		var DIR = 'img/soft-scraps-icons/';
		var nodes = null;
		var edges = null;
		var network = null;
		function draw() {

		    nodes = {!! $nodes !!};

			edges = {!! $edges !!};

		    var container = document.getElementById('mynetwork');
		    var data = {
		        nodes: nodes,
		        edges: edges
		    };
		    var options = {
		        nodes: {
		            borderWidth: 1,
		            size: 50,
		            color: {
		                border: '#222222',
		                background: '#2196F3'
		            },
		            font: {
		                color: 'white'
		            }
		        },
		        edges: {
		            color: '#D50000'
		        }
		    };
		    network = new vis.Network(container, data, options);
		}
		</script>
		<style>
			#mynetwork{
				height: 500px;
				border: 1px solid;
				border-radius: 25px;
			}
			.push-down{
				margin-top: 10px;
			}
		</style>
	</head>
<body onload="draw()">
	<div class="container">
		<h1>Kruskal Manipulation</h1>
		<div id="mynetwork"></div>
		<div class="push-down"></div>
		<div class="row">
			<div class="col-md-8 col-md-offset-2" align="center">
				<h1>Arbre couvrant de poids minimal : {{$minimal}}</h1>
			</div>
		</div>
		<div class="push-down"></div>
	</div>
</body>
</html>
