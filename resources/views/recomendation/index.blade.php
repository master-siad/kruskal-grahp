<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Recomendation system</title>
		<link rel="stylesheet" href="{{asset('css/app.css')}}">
		<link rel="stylesheet" href="{{asset('css/vis.css')}}">
		<script type="text/javascript" src="{{asset('js/vis.js')}}"></script>
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
				<a href = "{{url('/minimal')}}" class="btn btn-primary form-control">Le poids minimal</a>
			</div>
		</div>
		<div class="push-down"></div>
	</div>
</body>
</html>
