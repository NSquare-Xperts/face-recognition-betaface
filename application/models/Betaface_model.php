<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Betaface_model extends CI_Model {

     function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function insert($insert_arr)
    {
        if($this->db->insert('person',$insert_arr))
            return TRUE;
        else 
            return false;
    
    }
    
    public function get_persons()
    {
        return $this->db->select('*')
                        ->from('person')
                         ->order_by('u_date','desc')
                         ->get()->result_array();
    }
    
    public function get_img_uid($img_uid)
    {
        $arr = $this->db->select('*')
                ->from('person')
                ->where('img_uid',$img_uid)
                ->get()->result_array();
        
        if(empty($arr))
        {
            return true;
        }else{
            return false;
        }
    }
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

