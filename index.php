<!DOCTYPE html>
<html>
<head>
<meta charset=utf-8>
<meta name=viewport content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>Парсер интернет магазинов</title>
<meta name=robots content="noindex,nofollow">
<meta http-equiv=X-UA-Compatible content="IE=edge,chrome=1">
<link rel="stylesheet" type="text/css" href="css/reset.min.css?1">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css?1">
<link rel="stylesheet" type="text/css" href="css/style.min.css?1">
</head>
<body>

<div class="container main">

	<h1 class="text-center">Парсер товаров из интернет магазинов</h1>
	<div class="indent-bottom clearfix"></div>

	<h4>Доступные интернет магазины: <a href="http://hotline.ua/">hotline.ua</a>, <a href="http://rozetka.ua/">rozetka.ua</a>, <a href="https://market.yandex.ua/">market.yandex.ua</a></h4>

	<div class="input-group">
		<span class="input-group-addon">URL</span>
		<input type="text" class="form-control" placeholder="http://hotline.ua/computer/processory/">
		<span class="input-group-addon">
			<input class="btn btn-default" type="checkbox">
			<small>Все страницы</small>
		</span>
		<span class="input-group-btn">
			<button class="btn btn-default" type="button">Go!</button>
		</span>
	</div>

	<div class="indent-bottom clearfix"></div>
	<div class="progress hidden">
		<div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
		</div>
	</div>

	<div class="bs-callout bs-callout-danger hidden">
		<h4>Лог парсера</h4>
		<div class="element-counter">Обработано <span class="badge">0</span></div>

		<div class="container-fluid"></div>
	</div>

</div>

<script type="text/javascript" src="js/jquery.min.js?1"></script>
<script type="text/javascript" src="js/bootstrap.min.js?1"></script>
<script type="text/javascript">
	$('.main button').on('click', function() {
		$( '.main .hidden' ).removeClass( 'hidden' );
		$('.progress-bar').width('10%');
		send( getSiteName( $( '.main input' ).val() ) + '.php', $( '.main input' ).val() );
	});

	function send( where, what ) {
		$.ajax({
			url: where,
			method: 'POST',
			data: { url: what },
		}).done(function( data ) {
			products = $.parseJSON( data );
			if ( products[0].link ) {
				$.each( products, function( key, value ) {
					//$('.progress-bar').width( ( $('.progress-bar').width() / $('.progress-bar').parent().width() * 100 ) + ( 90 * 100 / products.length / 100 ) + '%' );
					$('.progress-bar').width('100%');

					$( '.bs-callout .container-fluid' ).append( '<div class="row" data-attr="' + value.link + '"><div class="col-xs-6">' + value.name + '</div><div class="col-xs-6"><span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span></div></div>' );
//Функция для поиска какой следующий продукт парсить
//Функция для поиска следующей страницы категории
				});
			} else {
				
				$( '.element-counter .badge' ).text( ( $( '.element-counter .badge' ).text() * 1 ) + 1 );

			}
		});
	}

	function getSiteName( url ) {
		return url.toString().replace( /https?:\/\/([^\/]+)\/.+$/i, "$1" ).replace( /\.com|\.ua|\.ru/gi, '' ).replace( /.+\.(.+)/, '$1' );
	}
</script>
</body>
</html>