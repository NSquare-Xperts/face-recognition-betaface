<?php $this->load->view('show_status_messages_view'); ?>
<div style="margin-top: 20px;"></div>
        <div class="card">
            <div class="card-block">
                <div class="card-body">
                    <div class="card-header">
                        <h2 class="card-title">Search Faces</h2> 
                    </div>
                    <form action="search" method="post" enctype="multipart/form-data">
                       <!-- <div class="form-group">
                            <label for="searchInputName">Name</label>
                            <input type="text" name="name" class="form-control" id="searchInputName" placeholder="Enter Name" required="true">
                            <small id="nameHelp" class="form-text text-muted">Enter name of person.</small>
                        </div> -->
                        <div class="form-group">
                            <label for="searchInputPhoto">Photo</label>
                            <input type="file" name="search_image" class="form-control-file" id="searchFileImage"  required="true">
                            <small id="namePhoto" class="form-text text-muted">Choose Person Image.</small>
                        </div>
                        <input type="submit" name="search" value="Search" class="btn btn-primary">
                    </form>
                </div>
            </div>
        </div>

