<!-- jQuery 3 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>

<!-- Bootstrap 5.3.0 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Select2 -->
<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- DataTables -->
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- DataTables responsive -->
<script src="https://cdn.datatables.net/fixedheader/3.3.2/js/dataTables.fixedHeader.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- CK Editor -->
<script src="https://cdn.ckeditor.com/ckeditor5/29.2.0/classic/ckeditor.js"></script>


<script>
	//CK Editor
	CKEDITOR.replace('editor1')

	ClassicEditor.create(document.querySelector('#editor1'), {
			toolbar: {
				items: []
			},
			shouldNotGroupWhenFull: true
		})
		.then(editor => {
			// Editor instance
		})
		.catch(error => {
			console.error(error);
		});
</script>

<script>
	$(document).ready(function() {
		$('#navbarSearchInput').on('input', function() {
			var keyword = $(this).val();
			if (keyword.length >= 2) {
				$.ajax({
					url: 'search.php',
					method: 'POST',
					data: {
						keyword: keyword
					},
					success: function(response) {
						var dropdown = '';
						$.each(response, function(index, item) {
							var photo = item.photo ? 'images/' + item.photo : 'images/noimage.jpg';
							dropdown += '<li><a class="text-black" href="product.php?product=' + item.slug + '" data-id="' + item.id + '"><img width="60px" height="90px" src="' + photo + '" alt="Product Photo">  ' + item.name + '</a></li>';
						});
						$('#searchResults').html(dropdown);
						$('#searchResults').addClass('show'); // Add the 'show' class to display the dropdown
					}
				});
			} else {
				$('#searchResults').html('');
				$('#searchResults').removeClass('show'); // Remove the 'show' class to hide the dropdown
			}
		});
	});
</script>

<script>
  
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false,
      'responsive'  : true
    })
  $(document).ready(function() {
    var table = $('#example1').DataTable( {
        responsive: true
    } );
 
    new $.fn.dataTable.FixedHeader( table );
});
</script>

<!-- Custom Scripts -->
<script>
	
	$(document).ready(function() {
		// Toggle search input on icon click
		$('#btnSearchToggle').click(function() {
			$('#navbarSearchInput').toggle().focus();
		});
	});

	$(function() {
		$('#btnSignin').click(function() {
			$('#modalSignin').modal();
		});
	});

	$(function() {
		$('#btnMaincom').click(function() {
			$('#modalmaincom').modal();
		});
	});

	$(function() {
		$('#btnsubcom').click(function() {
			$('#modalsubcom').modal();
		});
	});

	$(function() {
		$('.nav-tabs a[href="#tab1"]').tab('show');
	});
	$(function() {


		getCart();

		$('#productForm').submit(function(e) {
			e.preventDefault();
			var product = $(this).serialize();
			$.ajax({
				type: 'POST',
				url: 'cart_add.php',
				data: product,
				dataType: 'json',
				success: function(response) {
					$('#callout').show();
					$('.message').html(response.message);
					if (response.error) {
						$('#callout').removeClass('callout-success').addClass('callout-danger');
					} else {
						$('#callout').removeClass('callout-danger').addClass('callout-success');
						getCart();
					}
				}
			});
		});

		$(document).on('click', '.close', function() {
			$('#callout').hide();
		});

	});

	function getCart() {
		$.ajax({
			type: 'POST',
			url: 'cart_fetch.php',
			dataType: 'json',
			success: function(response) {
				$('#cart_menu').html(response.list);
				$('.cart_count').html(response.count);
			}
		});
	}
</script>