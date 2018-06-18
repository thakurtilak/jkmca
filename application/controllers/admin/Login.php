<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('common_model');

    }
    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function index()
    {
        if($this->session->userdata('systemAdmin'))
        {
            redirect('admin/dashboard');
        }
        $this->load->view('admin/login');
    }


    public function process()
    {
        $post = $this->input->post();
        if($post) {
            $this->form_validation->set_rules('username', 'Username', 'trim|required');
            $this->form_validation->set_rules('password', 'Password' , 'trim|required');
            if ($this->form_validation->run()) {

                $email = $this->input->post('username');
                $password = $this->input->post('password');
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

                    $where = array(
                        'email' => $email,
                        'password' => md5($password),
                        'status' => '1'
                    );
                    $userRecord = $this->common_model->getRecord(TBL_ADMIN_MASTER, '*', $where);
                    if ($userRecord) {
                        if ($userRecord) {
                            $this->session->set_userdata(array('systemAdmin' => $userRecord));
                            redirect('admin/dashboard');
                        } else {
                            $this->session->set_flashdata('error', $this->lang->line('NOT_AUTHORIZE_USER'));
                            redirect('admin/login');
                        }

                    } else {
                        $this->session->set_flashdata('error', $this->lang->line('NOT_AUTHORIZE_USER'));
                        redirect('admin/login');
                    }
                } else {
                    $this->session->set_flashdata('error', $this->lang->line('NOT_AUTHORIZE_USER'));
                    redirect('admin/login');
                }

            } else{
                $this->session->set_flashdata('error',validation_errors());
                //echo "YES"; die;
                redirect('admin/login');
            }
        } else {
            echo "Error"; exit;
        }
    }

    public function logout()
    {
        $array_items = array('systemAdmin');
        $this->session->unset_userdata($array_items);
        $this->session->set_flashdata('success',  $this->lang->line('LOGOUT_SUCCESS'));
        redirect('admin/login');
    }

    /*ldapauth
    */
    private function _ldapauth($email , $password)
    {
        /*** Connect via Ldap ***/
        $this->config->load('ldap');
        $ldap_config = $this->config->item('ldap');
        $LDAP_HOST_IP = $ldap_config['LDAP_HOST_IP'];
        $LDAP_PORT = $ldap_config['LDAP_PORT'];
        $ldapconfig = new stdClass();
        $ldapconfig->host = $LDAP_HOST_IP;//"52.76.39.100";//"172.31.16.14";//host name of server
        $ldapconfig->port = $LDAP_PORT;//used port for LDAP
        $ldapconfig->dn = "dc=ldap,dc=webdunia,dc=net";
        $user_email = $email;
        $user_passwd = $password;
        //$domain=   $_REQUEST['host'];

        $ds= ldap_connect($ldapconfig->host, $ldapconfig->port);

        if($ds){
            //bind with ldap server
            ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);//set protocol version to 3
            ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);
            $bind=ldap_bind($ds);//, $ldapconfig->basedn, $ldapconfig->password);
            if ($bind) {
                //search for the user
                $dn =$ldapconfig->dn; //"dc=ldap,dc=webdunia,dc=net";
                $filter="(&(mail=$user_email)(ou=webdunia))";
                $sr=ldap_search($ds, $dn, $filter);
                $info = ldap_get_entries($ds, $sr);

                if ($info[0]) {
                    if (@ldap_bind( $ds, $info[0]['dn'], "$user_passwd") ) {
                        //Successful LDAP Authentication
                        // echo "success";exit;
                        $res = $info[0]['cn'][0];
                        $result = "1#^^#".$res;
                        return $result;

                        exit;
                    }
                    else{
                        //Invalid User
                        echo 0;
                        return 0;
                    }
                }
                /*** Connection End ***/
            } else {
                //Connection Error
                return 0;
            }
        }
        else {
            //Connection Error
            return 0;
        }

    }
}
