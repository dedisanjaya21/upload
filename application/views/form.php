<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Form Upload</title>  
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css"> 
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/css.css">    
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/toastr.min.css">   
    <link rel="stylesheet" href="<?php echo base_url();?>assets/font-awesome/css/font-awesome.min.css">
  </head>

  <body>   
  <div class="container">
    <div class="row">
      <div class="col-md-2"></div>

      <div class="col-md-8">
        <br>
       <p class="h4">Form Upload</p>
        <hr>
        <?php echo form_open_multipart('upload/saveGambar',' id="form"');?>
        <div class="form-group">
          <label for="gambar">Gambar</label>
          <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*">    
        </div>
        <div class="form-group">
        <button type="button" name="unggah" id="unggah" class="btn btn-sm btn-info float-right"><i class="icon-upload"></i> Unggah</button>
        </div>
        &nbsp;<hr>
        <div class="form-group">
            <button type="submit" name="save" id="save" class="btn btn-primary" disabled><i class="icon-save"></i> Simpan</button>   
        </div>
        <div class="progress" style="display: none;" id="upload_bar">
				              <div id="progress-bar" class="progress-bar progress-bar-success progress-bar-striped " 
					              role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: 20%;">
					                20%
				              </div>
			            </div>        
      </form>
     </div>

    </div>
</div>
<script src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
<script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>  
<script src="<?php echo base_url();?>assets/js/toastr.min.js"></script>
<script type="text/javascript">

    //input form
    $('#form').submit(function(e){
        e.preventDefault();        
         var formData = new FormData($("#form")[0]);                
         $.ajax({
           url: $("#form").attr('action'),
           type: 'post' ,
           data: formData,
           dataType: 'json',
           contentType : false,
           processData : false,
           success: function(response) {
             if(response.success === true) {
               $("#form")[0].reset();      
               toastr.success("File berhasil disimpan"); 
             } else {
               $.each(response.messages,function(key, value){
                toastr.error(value);
               });
             }
           }
        });
    });


    toastr.options = {
      "closeButton": true,
      "debug": false,
      "newestOnTop": false,
      "progressBar": false,
      "positionClass": "toast-bottom-right",
      "preventDuplicates": true,
      "onclick": null,
      "showDuration": "300",
      "hideDuration": "1000",
      "timeOut": "3000",
      "extendedTimeOut": "1000",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
    };
    
    

    $('#unggah').on('click', function(event) {      
      event.preventDefault();

      var progressBar = $('#progress-bar');

      var inputFile = $('input[name=gambar]');
      var fileToUpload = inputFile[0].files[0];
      if (fileToUpload != undefined) {
        var formData = new FormData();
        formData.append("gambar", fileToUpload);     
        $.ajax({
            url: "<?php echo base_url();?>index.php/upload/saveGambar",
            type: 'post' ,
            data: formData,
            dataType: 'json',
            contentType : false,
            processData : false,
            success: function(response) {
              if(response.success === true) {
                $("#gambar").val('');   
                $("#save").removeAttr('disabled');
                $('.progress').hide();
                toastr.success("Gambar berhasil di unggah");               
              } else {
                $.each(response.messages,function(key, value){
                  toastr.error(value);
                  $('.progress').hide();
                });
              }
            },
              xhr: function() {
                var xhr = new XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(event) {
                  if (event.lengthComputable) {
                    var percentComplete = Math.round( (event.loaded / event.total) * 100 );
                    // console.log(percentComplete);
                    
                    $('.progress').show();
                    progressBar.css({width: percentComplete + "%"});
                    progressBar.text(percentComplete + '%');
                  };
                }, false);

                return xhr;
              }
          });  
      }else{
        toastr.warning("Pilih Gambar yang akan di unggah dulu!!");
      }   
	  });

    </script>

  </body>
</html>