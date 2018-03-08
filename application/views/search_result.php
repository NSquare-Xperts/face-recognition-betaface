<?php $this->load->view('show_status_messages_view');
      $this->load->database();?>
<div class="card">
                <div class="card-block">
                    <div class="card-body">
                        <div class="card-header">
                            <h2 class="card-title">Search Results</h2>
                            
                            <a href="<?php echo base_url('index.php/betaface/search');?>" class="btn btn-primary float-right" style="margin-left: 20px;">Back</a>
                            <a href="<?php echo base_url('index.php/betaface/index');?>" class="btn btn-primary float-right">All Persons</a>
                            
                            <label></label><p></p>
                            <label><b>For Photo:</b></label><img src="<?php echo base_url('assets/images/persons/'.$persons['search_photo']);?>" style="height: 200px;width: 200px;">
                        </div>
                        <table class="table">
                        <thead>
                          <tr>
                            <th>Name</th>
                            <th>Match(%)</th>
                            <th>Image</th>
                          </tr>
                        </thead>
                        <tbody>
                            <?php
//                                echo "<pre>";
//                                print_r($persons['persons']['faces_matches'][0]['matches']);
//                                exit;
                                if(!empty($persons['persons']['faces_matches'][0]['matches']))
                                {
                                
                                foreach ($persons['persons']['faces_matches'][0]['matches'] as $person){
                                    
                                    if($person['confidence'] >= 0.60){?>
                          <tr>
                            <td><?php 
                                 $exploded_name = explode('@',$person['person_name']);
                                  echo $exploded_name[0] ?>
                            </td>
                            <td><?php echo number_format((float) $person['confidence']*100,2,'.','');?></td>
                            <td><?php $row = $this->db->select('photo')->from('person')->where('face_uid',$person['face_uid'])->get()->row();?>
                                    <?php if(!empty($row)){?>
                                     <img src="<?php echo base_url('assets/images/persons/'.$row->photo);?>" style="height: 200px;width: 200px;">
                                    <?php }else {?>
                                     Photo Not Found    
                                    <?php } ?>
                                     
                            </td>
                          </tr>
                                    <?php }}}else{echo 'No Match Found';} ?>
                        </tbody>
                      </table>
                        
                 </div>
                </div>
            </div>



