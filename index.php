<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Gallery Chotot.vn</title>
		<link rel="stylesheet" type="text/css" href="css/normalize.css">
		<link rel="stylesheet" type="text/css" href="css/jquery-ui.css">

		<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="css/style.css">

		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
		<div class="content">
			<div class="container">
				<div class="img-head"></div>
				<div class="img-box">
					<div class="img-content">
						<div class="img-row">
							<div class="img-temp"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="control">
			<form role="form">
				<div class="form-group">
					<label for="timeUpdate">Time update</label>
					<input id="inputTime" type="number" class="form-control" id="timeUpdate" placeholder="Enter value" value="50000">
				</div>
				<button id="btnRun" type="button" class="btn btn-success">Run</button>
				<button id="btnStop" type="button" class="btn btn-danger">Stop</button>
			</form>
		</div>
		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script type="text/javascript" src="js/jquery-ui.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/jquery.nicescroll.js"></script>
		<script type="text/javascript">
			var $btnStop = $("#btnStop"), $btnRun = $("#btnRun"), $inputTime = $("#inputTime"), load = true, _data, i = 0, updateTime = $inputTime.val();
			$(document).ready(function() {
				$("html").niceScroll();
				loadImage();

				$inputTime.change(function() {
					$btnStop.hide();
					$btnRun.show();
					load = false;
				});

				$inputTime.keydown(function() {
					$btnStop.hide();
					$btnRun.show();
					load = false;
				});

				$inputTime.keyup(function() {
					updateTime = $inputTime.val();
				});

				$btnStop.click(function() {
					$btnStop.hide();
					$btnRun.show();
					load = false;
				});

				$btnRun.click(function() {
					$btnRun.hide();
					$btnStop.show();
					load = true;
					loadImage();
				});
			});

			function loadImage() {
				if (load) {
					$.ajax({
						type: "POST",
						url: "create_json.php",
						data: {image: "true"},
						dataType: "json", 
						success: function(data) {
							i = 0;
							_data = data;
							animateItem(_data[0]);
						},
					});
				};
			};

			function animateItem(data) {
				if (data != "" && i < _data.length && load) {
					var $content = $(".img-head"), offsetNewItem = $(".img-temp").offset(), positionNewItem = $(".img-temp").position();
					$content.append("<div class='img-block img-animate'><img src='" + data + "'></div>");
					$content.find(".img-block")
						.css({position: "absolute", left: positionNewItem.left, top: 0,})
						.animate({top: offsetNewItem.top}, 1500, function() {
							i++;
							addItem(data);
							animateItem(_data[i]);
						});
				} else {
					setTimeout("loadImage()", updateTime);
				};
			};

			function addItem(data) {
				var $box = $(".img-content"), firstRow = ".img-row:first-child", imgTemp = "<div class='img-temp'></div>";
				var lItem = $box.find(firstRow).find("div").nextAll().length;
				$box.find(".img-temp").after("<div class='img-block'><img src='" + data + "'></div>");

				$(".img-temp").remove();
				$(".img-animate").remove();
				if (lItem <= 10) {
					$box.find(firstRow).append(imgTemp);
					$(".img-temp").hide().fadeIn(500);
				} else {
					$box.find(firstRow).before("<div class='img-row'></div>");
					$box.find(firstRow).append(imgTemp);
					$("html").getNiceScroll().resize();
				};
				$box.find(".img-row")
				.sortable({
					connectWith: ".img-row",
					placeholder: "ui-state-highlight",
					activate: function( event, ui ) {
						$btnStop.hide();
						$btnRun.show();
						load = false;
						//sortTable();
					},
				})
				.disableSelection();
			};

			function sortTable() {
				var $imgContent = $(".img-content"), itemRow = $imgContent.find(".img-row").length;
				for (i = 0; i < itemRow; i++) {
					itemRow = itemRow - 1;
					var elem = $imgContent.find(".img-row").eq(itemRow);
					if (elem.find(".img-block").length < 11) {
						elem.addClass(itemRow);
						alert("this");
					}
				};
			};
		</script>
	</body>
</html>