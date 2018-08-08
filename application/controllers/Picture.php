<?php

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    class Picture extends CI_Controller {

        private $_organization = array();

        public function __construct() {
            parent::__construct();
            $this->load->library('session');
            $organization = [
                'salt'				=> $this->session->userdata('salt'),
                'username'			=> $this->session->userdata('username'),
                'id'				=> $this->session->userdata('id'),
                'accesskey'			=> $this->session->userdata('accesskey'),
                'branch_id'			=> $this->session->userdata('branch_id'),
            ];

            if(empty($organization['id']) || empty($organization['salt']) || empty($organization['username']))
                redirect('/','refresh');

            $this->_organization = $organization;
        }


        public  function manage(){

            $uid = $this->_organization['id'];
            $accesskey = $this->_organization['accesskey'];
            $where = array('uid'=>$uid);
            $config_p = array('url'=>site_url('hotspot/users'),'table'=>'youtu','per_page'=>10,'uri_segment'=>4);
            $this->load->model('Member_model');
            $offset = $this->uri->segment(4) ? $this->uri->segment(4) : 0;
            $data['page'] = $this->Member_model->feiyeconfig($config_p,$where);
            $query = $this->Member_model->getall($config_p['per_page'],$offset,'youtu',$where,array('addtime'=>'DESC','id'=>'ASC'));

            $results = $query->result_array();

            $data['result'] = $results;

            $data['accesskey'] = $accesskey;
             $lang = $this->input->get('lang', TRUE);
            $this->load->library('Lang', array('lang'=>$lang), 'Switch');
            $data['menu'] = $this->Switch->init('menu'); 

            $this->load->library('twig');
            $this->twig->display('picture/index.php',$data);
        }


        public function upload(){

            $uid = $this->_organization['id'];
            if($this->input->post()){
                $file  = $_FILES['pic'];
                $path = "data/upload";
                if(!is_dir($path)) mkdir($path,0777);

                $_resource = explode('.',  $file['name']);
                $_suffix = $_resource[1];
                $time =mt_rand(100,999).time().mt_rand(100,999);
                $img_id = $time.'.'.$_suffix;
                $new = $path.'/'.$img_id;

                $flag = move_uploaded_file($file['tmp_name'],$new);

                if ($flag){
                    $imgdata = array(
                        'uid' =>$uid,
                        'img_id' => $new,
                        'url' => '/'.$new,
                        'api_url' =>$new,
                        'download_url' => $new,
                        'addtime' => time(),
                    );

                    $this->load->model('Member_model');
                    $last_id = $this->Member_model->insert('youtu', $imgdata);
                    $_data = array('file_name'=>$new,'img'=>"<img src='/".$imgdata['url']."'/>",'id'=>$last_id);
                    echo json_encode($_data);

                }
                exit();
            }


            $data['accesskey'] = $this->_organization['accesskey'];
             $lang = $this->input->get('lang', TRUE);
            $this->load->library('Lang', array('lang'=>$lang), 'Switch');
            $data['menu'] = $this->Switch->init('menu'); 

            $this->load->library('twig');
            $this->twig->display('picture/upload.php',$data);
        }


        public function picdel(){

            if(!$this->input->post()) exit();
            $uid = $this->_organization['id'];
            $this->load->model('Member_model');
            $id = $this->input->post('id');
            $pic = $this->Member_model->first('youtu',[],['id'=>$id,'uid'=>$uid]);
            if(!empty($pic)){
                $file = $pic['img_id'];
                if(file_exists($file))  unlink($file);
                $this->Member_model->delete(['id'=>$id,'uid'=>$uid,'img_id'=>$pic['img_id']],'youtu');
                echo json_encode(['status'=>'success']);
            }

        }

        public function component(){

            $ops = array('upload','display','del','add','init','test');
            $op = $this->uri->segment(3);
            $op = $op ? $op : 'display';
            $uid = $this->_organization['id'];
            if(!in_array($op, $ops)) return;

            $_dprefix = 'youtu';

            if($op=="upload"){


                $file  = $_FILES['pic'];//$this->getRequest()->getFiles('pic');
                $path = "data/upload";
                if(!is_dir($path)) mkdir($path,0777);

                $_resource = explode('.',  $file['name']);
                $_suffix = $_resource[1];
                $time = time().decbin(mt_rand(1,15));
                $img_id = $time.'.'.$_suffix;
                $new = $path.'/'.$img_id;

                move_uploaded_file($file['tmp_name'],$new);

                $imgdata = array(
                    'uid' =>$uid,
                    'img_id' => $new,
                    'url' =>'/'.$new,
                    'api_url' => '/'.$new,
                    'download_url' =>'/'.$new,
                    /* 'local_url' => $new,*/
                    'addtime' => time(),
                );
                $this->load->model('Member_model');
                $last_id = $this->Member_model->insert('youtu', $imgdata);
                $_data = array('file_name'=>'/'.$new,'img'=>"<img src='".'/'.$new."'/>",'id'=>$last_id);
                echo json_encode($_data);
                exit;


            }

            if($op=="display"){


                $table ='youtu';

                $where = array('uid'=>$uid);

                $model = new SampleModel();
                $url = BASE_URL.$this->getRequest()->getRequestUri();
                $total = $model->count($table,$where);
                $per_page = 12;
                $page_now = $this->getRequest()->getQuery('page');
                $page_now = $page_now ? $page_now : 1;

                $page = new Page($url,$total,$per_page,$page_now);
                $data['page'] = $page->get();

                $page_now = ($page_now-1)*$per_page; //起始数



                $fechwhere  = [
                    'uid'=>$uid,
                    'LIMIT'=>[$page_now,$per_page],
                    "ORDER" => ['addtime DESC', 'id DESC'],
                ];


                $data['results'] = $model->select($table,"*",$fechwhere);


                $data['prefix'] = $_dprefix;

                $twig = new Twig($this->ViewPath);
                $twig->display('manage/youtu/index.php', $data);
            }

            if($op=="add"){
                $data['prefix'] = $_dprefix;
                $twig = new Twig($this->ViewPath);
                $twig->display('manage/youtu/add.php',$data);


            }

            if($op=="del"){
                if(!$this->getRequest()->isPost()) exit();
                $model = new SampleModel();
                $id = $this->getRequest()->getPost('id');
                $pic = $model->first('youtu',"*",array("and"=>['id'=>$id,'uid'=>$uid]));
                if(!empty($pic)){
                    $file = 'upload/'.$pic['img_id'];
                    if(file_exists($file)){
                        unlink($file);
                        //echo json_encode(array('status'=>"success"));
                    }
                    $model = new SampleModel();
                    $model->delete('youtu',array('and'=>['id'=>$id,'uid'=>$uid,'img_id'=>$pic['img_id']]));
                    $yutu = new Yutu();
                    $tes = $yutu->youtu_delete($pic['img_id']);
                    echo json_encode(['status'=>'success']);
                }


            }


            if($op=='init'){

                $field = $this->input->get('field');

                $field_value = $this->input->get('field_value');              

                if(empty($field)){
                    $field = 'photo_field';

                }

                if(empty($field_value)){
                    $field_value = 'photo_value';

                }

                $data['field'] = $field;
                $data['field_value'] = $field_value;


                $table ='youtu';

                $where = array('uid'=>$uid);


                $ops = 'libs';


                $data['op'] = $ops;





                $where = array('uid'=>$uid);
                $config_p = array('url'=>site_url('hotspot/users'),'table'=>'youtu','per_page'=>10,'uri_segment'=>4);
                $this->load->model('Member_model');
                $offset = $this->uri->segment(4) ? $this->uri->segment(4) : 0;
                $data['page'] = $this->Member_model->feiyeconfig($config_p,$where);
                $query = $this->Member_model->getall($config_p['per_page'],$offset,'youtu',$where,array('addtime'=>'DESC','id'=>'ASC'));

                $results = $query->result_array();

                $data['results'] = $results;

                 $lang = $this->input->get('lang', TRUE);
                $this->load->library('Lang', array('lang'=>$lang), 'Switch');
                $data['menu'] = $this->Switch->init('menu'); 
                
                $this->load->library('twig');
                $this->twig->display('youtu/component.php',$data);

            }



        }

    }