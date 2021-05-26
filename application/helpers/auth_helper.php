<?php

function authentication()
{
    $CI = get_instance();

    if(!$CI->session->userdata('user_id') || $CI->session->userdata('user_level') == 2){
		$CI->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show">Silakan login terlebih dahulu !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		
        redirect('auth');
    }
}
