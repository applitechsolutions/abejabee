$(document).ready(function () {
	$('#upload_csv').on('submit', function (event) {
		event.preventDefault();

		swal({
			title: '¿Estás Seguro?',
			text: 'Se modificarán todos los balances de los clientes',
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Sí, Cargar!',
			cancelButtonText: 'Cancelar',
		}).then((result) => {
			swal({
				title: 'Cargando pagos, por favor espere...',
			});
			swal.showLoading();
			$.ajax({
				url: 'BLL/import.php',
				method: 'POST',
				data: new FormData(this),
				dataType: 'json',
				contentType: false,
				cache: false,
				processData: false,
				success: function (data) {
					console.log(data);
					$('#csv_file').val('');
					$('#data-table').DataTable({
						bDestroy: true,
						data: data,
						columns: [
							{
								data: 'CODIGO',
							},
							{
								data: 'MONTO',
							},
							{
								data: 'FECHA',
							},
							{
								data: 'DOCUMENTO',
							},
							{
								data: 'ESTADO',
								render: function (data, type, row, meta) {
									if (data == 'Correcto!') {
										return (
											'<div class="alert alert-success align-self-stretch" role="alert">' +
											data +
											'</div>'
										);
									} else {
										return (
											'<div class="alert alert-danger" role="alert">' +
											data +
											'</div>'
										);
									}
								},
							},
						],
						paging: true,
						lengthChange: true,
						aLengthMenu: [
							[10, 25, 50, -1],
							[10, 25, 50, 'Todos'],
						],
						searching: true,
						ordering: true,
						info: true,
						autoWidth: true,
						language: {
							paginate: {
								next: 'Siguiente',
								previous: 'Anterior',
								first: 'Primero',
								last: 'Último',
							},
							info: 'Mostrando _START_-_END_ de _TOTAL_ registros',
							empyTable: 'No hay registros',
							infoEmpty: '0 registros',
							lengthChange: 'Mostrar ',
							infoFiltered: '(Filtrado de _MAX_ total de registros)',
							lengthMenu: 'Mostrar _MENU_ registros',
							loadingRecords: 'Cargando...',
							processing: 'Procesando...',
							search: 'Buscar:',
							zeroRecords: 'Sin resultados encontrados',
						},
					});
					swal.close();
					swal(
						'Exito!',
						'¡Pagos ingresados, por favor verifique el listado',
						'success'
					);
				},
				error: function (request, status, error) {
					alert(request.responseText);
				},
			});
		});
	});
});
