<?php

class Login extends CI_Controller {


	public function index()
	{
		$this->load->view('login');

	}
/*        $data['title'] = "Login";
        $this->load->view('login',$data);
    }*/
    public function login_validation(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules("username" , "Username" ,'required');
        $this->form_validation->set_rules("password" , "Password" ,'required');
        if($this->form_validation->run())
        {
            $username = $this->input->post("username") ;
            $password = $this->input->post("password");
            $this->load->model('mod');
            if ($this->mod->can_log($username,$password) != false)
            {
            	$matr = $this->mod->can_log($username,$password)->result();
            	foreach ($matr as $v) {
					$session_data = array(
						'username' => $username,
						'mat' => $v->mat
                );
                }
                $this->session->set_userdata($session_data);
                redirect(base_url().'Login/enter');
            }
            else
			{
				$this->session->set_flashdata('error','Invalid Username and Password');
				redirect(base_url());
			}
        }
        else
        {
            $this->index();
        }
    }
    function enter()
	{
		if ($this->session->userdata('username') != ''){
			$this->load->model('mod');
			if ($this->mod->retRes($this->session->userdata('mat'))) {
				redirect(base_url().'Res/');
			}
			else
			{
				if ($this->mod->retRep($this->session->userdata('mat'))) {
					redirect(base_url().'Rep/');
				}
				else
				{
					if ($this->mod->retGes($this->session->userdata('mat'))) {
						redirect(base_url().'Ges/');
					}elseif ($this->session->userdata('username') == "admin")
					{
                        redirect(base_url().'AdminC/');
					}else
					{
                        redirect(base_url().'Di/');
					}
				}
			}


			/*echo '<h2> Welcome dear -'.$this->session->userdata('username').'</h2>' ;
			echo '<label><a href="'.base_url().'login/logout">Logout</a></label>';*/
		}
		else
		{
			redirect(base_url());
		}
	}
	function logout()
	{
		$this->session->unset_userdata('username');
        $this->session->unset_userdata('mat');
		redirect(base_url());
	}

    public function menu()
	{
		$this->load->view('menu');
	}
	public function motOublie()
	{
		$this->load->view('mpOublie');
	}
    public function pdPriv()
    {
        $this->load->view('pdPriv');
    }
}
?>
