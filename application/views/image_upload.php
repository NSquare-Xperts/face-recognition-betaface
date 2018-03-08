
            <div class="card">
                <div class="card-block">
                    <div class="card-body">
                        <div class="card-header">
                            <h2 class="card-title">Upload Photo</h2>
                        </div>
                        <form action="<?php echo base_url('index.php/betaface/upload');?>" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="uploadInputName">Name</label>
                                <input type="text" name="name" class="form-control" id="uploadInputName" placeholder="Enter Name" required="true">
                                <small id="nameHelp" class="form-text text-muted">Enter name of person.</small>
                            </div>
                            <div class="form-group">
                                <label for="uploadInputPhoto">Photo</label>
                                <input type="file" name="image" class="form-control-file" id="uploadFileImage"  required="true">
                                <small id="namePhoto" class="form-text text-muted">Choose Person Image.</small>
                            </div>

                            <input type="submit" name="submit" value="Submit" class="btn btn-primary">
                        </form>
                 </div>
                </div>
            </div>
        
    </div>
    <script>
        
        $(document).ready(function(){
            
                $('#btn-submit-click').click(function(){
                    $.ajax({
                     url: 'http://www.betafaceapi.com/service_json.svc/GetImageFileInfo',
                     crossDomain: true,
                     contentType: "application/json; charset=utf-8",
                     data:{image_uid: "3f1d2dc1-42d2-4182-8a59-613436f14f85",api_key:"d45fd466-51e2-4701-8da8-04351c872236",api_secret:"171e8465-f548-401d-b63b-caf0dc28df5f"},
                     method: 'POST',
                     success: function(data){
                        console(data);
                    }
                });
            });
        });
    </script>