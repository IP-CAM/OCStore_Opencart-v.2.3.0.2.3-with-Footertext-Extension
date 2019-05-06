<?php

class ControllerExtensionModuleFirstModule extends Controller {
    
    private $error = array();

    
    
    public function index() {
        
        $this->load->language('extension/module/first_module');
        
        $this->document->setTitle($this->language->get('heading_title'));
        
        $this->load->model('setting/setting');
        
        if ($this->request->server['REQUEST_METHOD'] == 'POST')  {
        
            $this->model_setting_setting->editSetting('first_module', $this->request->post);
           
            $this->session->data['success'] = $this->language->get('text_success');
            
            $this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], true));
        }
        
        $data['heading_title'] = $this->language->get('heading_title');
 
        $data['text_edit'] = $this->language->get('text_edit');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
 
        $data['entry_status'] = $this->language->get('entry_status');
 
        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');
    
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
     
        $data['breadcrumbs'] = array();
       
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
        );
 
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_module'),
            'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], true)
        );
 
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/module/first_module', 'token=' . $this->session->data['token'], true)
        );
        
        $data['action'] = $this->url->link('extension/module/first_module/form', 'token=' . $this->session->data['token'], true);
        
        $data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'], true);
        

        $data['footertext'] = $this->config->get('config_footertext');
    
    
// UPDATE `oc_setting` SET `value`=[value-5] WHERE `key`="config_footertext"



        $data['header'] = $this->load->controller('common/header');
        
        $data['column_left'] = $this->load->controller('common/column_left');
       
        $data['footer'] = $this->load->controller('common/footer');
        
        $this->response->setOutput($this->load->view('extension/module/first_module', $data));
    }

    public function form() {
        
        $query = $this->request->post['out_text'];
        if ($this->config->get('config_footertext')) {
        	$this->db->query("UPDATE `oc_setting` SET `value`='" . $query . "' WHERE `key`='config_footertext'"); }
        else {
        	$this->db->query("INSERT INTO `oc_setting`(`setting_id`, `store_id`, `code`, `key`, `value`, `serialized`) VALUES (NULL,0,'config','config_footertext','" . $query . "',0)");
        }
       
        $link =  $this->url->link('extension/extension', 'token=' . $this->session->data['token'], true);
        header('Location:' . $link);
        
        die();
    }
    
}