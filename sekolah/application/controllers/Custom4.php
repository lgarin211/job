<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Custom4 extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Custom4_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', true));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'custom4/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'custom4/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'custom4/index.html';
            $config['first_url'] = base_url() . 'custom4/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = true;
        $config['total_rows'] = $this->Custom4_model->total_rows($q);
        $custom4 = $this->Custom4_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'custom4_data' => $custom4,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
   
    
        // Untuk memanggil fungsi2 untuk berinteraksi kedalam database (CRUD)
        $this->load->model('MSudi');
        // Untuk memanggil nama table dan seleksi pada saat pemanggilan data
        $itms = $this->MSudi->GetDataWhere('item', 'status', 1);
        // Untuk menjalankan fungsi Getcooking dan membuat data array kedalam templates/halaman website
        $data['Getitm'] = $itms->result();
        // Untuk memanggil atau menjalankan layout/file tampilan dan memasukan data array

        $this->load->view('controlhead', $data);
     
        $this->load->view('custom4/custom4_list', $data);
        $this->load->view('controlfoot');
    }

    public function read($id)
    {
        $row = $this->Custom4_model->get_by_id($id);
        if ($row) {
            $data = array(
        'id' => $row->id,
        'status' => $row->status,
        'angka' => $row->angka,
        'teks' => $row->teks,
        );
       
        
        
            $this->load->view('custom4/custom4_read', $data);
            $this->load->view('controlfoot');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('custom4'));
        }
    }

    public function create()
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('custom4/create_action'),
        'id' => set_value('id'),
        'status' => set_value('status'),
        'angka' => set_value('angka'),
        'teks' => set_value('teks'),
    );
   
    
    
    
    
    
    
        $this->load->view('controlfoot');
        $this->load->view('custom4/custom4_form', $data);
    }
    
    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == false) {
            $this->create();
        } else {
            $data = array(
        'status' => $this->input->post('status', true),
        'angka' => $this->input->post('angka', true),
        'teks' => $this->input->post('teks', true),
        );

            $this->Custom4_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('custom4'));
        }
    }
    
    public function update($id)
    {
        $row = $this->Custom4_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('custom4/update_action'),
        'id' => set_value('id', $row->id),
        'status' => set_value('status', $row->status),
        'angka' => set_value('angka', $row->angka),
        'teks' => set_value('teks', $row->teks),
        );
       
        
        
            $this->load->view('custom4/custom4_form', $data);
            $this->load->view('controlfoot');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('custom4'));
        }
    }
    
    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == false) {
            $this->update($this->input->post('id', true));
        } else {
            $data = array(
        'status' => $this->input->post('status', true),
        'angka' => $this->input->post('angka', true),
        'teks' => $this->input->post('teks', true),
        );

            $this->Custom4_model->update($this->input->post('id', true), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('custom4'));
        }
    }
    
    public function delete($id)
    {
        $row = $this->Custom4_model->get_by_id($id);

        if ($row) {
            $this->Custom4_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('custom4'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('custom4'));
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('status', 'status', 'trim|required');
        $this->form_validation->set_rules('angka', 'angka', 'trim|required');
        $this->form_validation->set_rules('teks', 'teks', 'trim|required');

        $this->form_validation->set_rules('id', 'id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
}

/* End of file Custom4.php */
/* Location: ./application/controllers/Custom4.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-08-11 11:16:43 */
/* http://harviacode.com */
