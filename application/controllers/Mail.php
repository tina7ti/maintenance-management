<?php
class Mail extends CI_Controller
{
	public function index()
	{
		$this->sendMail();
		/*$this->load->view("mpOublie", $mail['email']);*/
  	}

	public function createPass()
	{
		$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		$pass = array();
		$alphaLength = strlen($alphabet) - 1;
		for ($i = 0; $i < 8; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}

		return (implode($pass));

	}

	public function createMsg()
	{
		$msg = ("Votre nouveau mot de passe est : ");
		return $msg;
	}

	public function sendMail()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules("username" , "Username" ,'required');

		if($this->form_validation->run()) {
			$config = array(
				'protocol' => 'smtp',
				'smtp_host' => 'ssl://smtp.googlemail.com',
				'smtp_port' => 465,
				'smtp_user' => 'maintenancem31@gmail.com',
				'smtp_pass' => '',
				'mail_type' => 'html',
				'charset' => 'iso-8859-1',
				'wordwrap' => TRUE
			);
			$this->load->library('email',$config);
			$this->load->model("RecupMail");
			$mail = $this->RecupMail->retrive($this->input->post('username'));
			if ($mail->num_rows() > 0)
			{
				foreach ($mail->result() as $v) {
					$msg = $this->createMsg();
					$pass = $this->createPass();
					$msgPASS = $msg.$pass;
					$this->email->set_newline("\r\n");
					$this->email->from('maintenancem31@gmail.com');
					$this->email->to($v->email);
					$this->email->subject("Mot de passe");
					$this->email->message($msgPASS);
					if($this->email->send())
					{
						$data['password'] = $pass;
						$this->RecupMail->updateMP($data,$this->input->post('username'));
						$data['msg'] = "<div class=\"alert alert-success\">Veuillez vérifier votre mail pour obtenir votre nouveau mot de passe. <i class=\"fas fa-smile fa-lg\"></i> </div>";
						$this->load->view('login',$data);
					}
					else
					{
						$data['msg'] = '<div class="alert alert-danger">Echec d\'envoie de mail. <i class="fas fa-meh fa-lg"></i> </div> ' ;
						$this->load->view('login',$data);
					}

				}

			}
			else
			{
				$data['error'] = "Invalid Username ";
				$data['info'] = "veuillez postuler auprès de service de travail";
				$this->load->view('mpOublie',$data);
			}
		}
		else
		{
			$this->load->view('mpOublie');
		}


	}

}
?>
