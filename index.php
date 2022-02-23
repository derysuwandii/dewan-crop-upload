<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />    
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <link rel="icon" href="dk.png">
  	<title>Dewan Bootstrap - Crop Image</title>
  	<link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/croppie.css">
</head>
<body>
	<nav class="navbar navbar-dark bg-danger">
	  <a class="navbar-brand text-white" href="index.php">
	    Dewan Komputer
	  </a>
	</nav>

	<h3 class="mb-5 mt-3" align="center">Crop and Upload Menggunakan Ajax pada PHP</h3>
	<div class="row">
		<div class="col-sm-6 offset-sm-3">
			<div class="form-group">
				<label>Pilih Gambar</label><br>
				<input type="file" name="upload_image" id="upload_image" accept="image/*" />
			</div>
				
			<div id="uploaded_image"></div>
     	</div>
    </div>

    <div id="uploadimageModal" class="modal" role="dialog">
	   <div class="modal-dialog">
	      <div class="modal-content">
	         <div class="modal-header">
	            <h4 class="modal-title" id="myModalLabel">Crop &amp; Upload Gambar</h4>
	            <button type="button" class="close" data-dismiss="modal" >
	                <span aria-hidden="true">&times;</span>
	                <span class="sr-only">Close</span>
	            </button>
	         </div>
	         <div class="modal-body">
	            <div class="row">
	               <div class="col-md-12 text-center">
	                  <div id="image_demo"></div>
	               </div>
	            </div>
	         </div>
	         <div class="modal-footer">
	            <button class="btn btn-success crop_image">Crop &amp; Upload</button>
	         </div>
	      </div>
	   </div>
	</div>

	<div class="navbar bg-dark fixed-bottom">
		<div style="color: #fff;">© <?php echo date('Y'); ?> Copyright:
		    <a href="https://dewankomputer.com/"> Dewan Komputer</a>
		</div>
	</div>

  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/croppie.min.js"></script>

  <script>  
    $(document).ready(function(){
      $image_crop = $('#image_demo').croppie({
        enableExif: true,
        viewport: {
          width:250,
          height:200,
          type:'square' //circle
        },
        boundary:{
          width:300,
          height:300
        }
      });

      $('#upload_image').on('change', function(){
        var reader = new FileReader();
        reader.onload = function (event) {
          $image_crop.croppie('bind', {
            url: event.target.result
          }).then(function(){
            console.log('jQuery bind complete');
          });
        }
        reader.readAsDataURL(this.files[0]);
        $('#uploadimageModal').modal('show');
      });

      $('.crop_image').click(function(event){
        $image_crop.croppie('result', {
          type: 'canvas',
          size: 'viewport'
        }).then(function(response){
          $.ajax({
            url:"upload.php",
            type: "POST",
            data:{"image": response},
            success:function(data)
            {
              $('#uploadimageModal').modal('hide');
              $('#uploaded_image').html(data);
            }
          });
        })
      });
    });  
  </script>
</body>
</html>