<?php $this->load->view('show_status_messages_view'); ?>
<div class="card">
                <div class="card-block">
                    <div class="card-body">
                        <div>
                            <h2>List of All Persons</h2>
                            <div style="margin-bottom:70px;">
                                <a href="<?php echo base_url('index.php/betaface/search');?>" class="btn btn-primary float-right" style="margin-left:20px;">Search</a>
                                <a href="<?php echo base_url('index.php/betaface/upload');?>" class="btn btn-primary float-right">Add</a>
                            </div>
                            
                        </div>
                        <table class="table">
                        <thead>
                          <tr>
                            <th>Name</th>
                            <th>Image</th>
                          </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($persons as $person){?>
                          <tr>
                            <td><?php echo $person['name'];?></td>
                            <td><img src="<?php echo base_url('assets/images/persons/'.$person['photo']);?>" style="height: 200px;width: 200px"></td>
                          </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                        
                 </div>
                </div>
            </div>

