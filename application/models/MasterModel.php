<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MasterModel extends CI_Model
{
   	public function getAll($table)
	{
		return $this->db->get($table);
	}
	
	public function getBy($table, $where)
	{
		return $this->db->get_where($table, $where);
	}
 
	public function add($table, $data)
	{
		$this->db->insert($table, $data);
	}
 
	public function edit($table, $where, $data){
		$this->db->where($where);
		$this->db->update($table, $data);
	}
	
	public function delete($table, $where)
	{
		$this->db->where($where);
		$this->db->delete($table);
	}
	
	public function getByCondition($where)
	{
		$this->db->select('target.*, pelanggan.noreg_pelanggan, pelanggan.nama_pelanggan, user.nama_user, pelanggan.alamat_pelanggan, pelanggan.tarif, pelanggan.daya, status.ket_status');
        $this->db->from('target');
        $this->db->join('pelanggan', 'pelanggan.id_pelanggan = target.id_pelanggan');
		$this->db->join('status', 'status.id_status = target.id_status', 'left');
		$this->db->join('user', 'user.id_user = target.id_user', 'left');
		$this->db->where($where);
        
		return $this->db->get();
	}
	
	public function getHarmet($where)
	{
		$this->db->select('harmet.*, pelanggan.noreg_pelanggan, pelanggan.nama_pelanggan, user.nama_user, pelanggan.alamat_pelanggan, pelanggan.tarif, pelanggan.daya');
        $this->db->from('harmet');
        $this->db->join('pelanggan', 'pelanggan.id_pelanggan = harmet.id_pelanggan');
		$this->db->join('user', 'user.id_user = harmet.id_user', 'left');
		$this->db->where($where);
		$this->db->order_by('harmet.tanggal_penggantian_harmet', 'DESC');
		$this->db->limit(1);
        
		return $this->db->get();
	}
	
	public function getHarmetDetail($where)
	{
		$this->db->select('harmet.*, pelanggan.noreg_pelanggan, pelanggan.nama_pelanggan, user.nama_user, pelanggan.alamat_pelanggan, pelanggan.tarif, pelanggan.daya');
        $this->db->from('harmet');
        $this->db->join('pelanggan', 'pelanggan.id_pelanggan = harmet.id_pelanggan');
		$this->db->join('user', 'user.id_user = harmet.id_user', 'left');
		$this->db->where($where);
		$this->db->order_by('harmet.tanggal_penggantian_harmet', 'DESC');
        
		return $this->db->get();
	}
}