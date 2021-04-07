<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CategoryModel extends CI_Model
{
	var $act_order   = array('category_id', 'category_code', 'category_desc');
    var $act_search  = array('category_code', 'category_desc');

	private function mainQuery()
    {
        $this->db->select('*')->from('category');
        // $this->db->join('modul_bkpp_instansi', 'modul_bkpp_instansi.bnba_id = bkpp_pns_bnba.instansi', 'left');
        $i = 0;
        foreach($this->act_search as $item)
		{
            if(isset($_POST['search']['value']))
			{
                if($i === 0)
				{
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
				
                if(count($this->act_search) - 1 == $i)
				{
                    $this->db->group_end();
				}
            }
            $i++;
        }
		
        if(isset($_POST['order']))
		{
            $this->db->order_by($this->act_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if(isset($this->act_default))
		{
            $order = $this->act_default;
            $this->db->order_by(key($order), $order[key($order)]);
        }
		
        // $this->db->where('tahun', $_SESSION["thn_data"]);
    }

   	public function getAll()
    {
        $this->mainQuery();
        if($_POST['length'] != -1)
		{
            $this->db->limit($_POST['length'], $_POST['start']);
        }
		
        $result = $this->db->get();
        return $result->result();
    }
	
	public function countFilter()
    {
        $this->mainQuery();
        $result =  $this->db->get();
        return $result->num_rows();
    }

    public function countAll()
    {
        $this->mainQuery();
        return $this->db->count_all_results();
    }
}