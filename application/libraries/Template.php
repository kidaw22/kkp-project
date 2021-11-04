<?php
class Template {
    protected $_ci;
    public function __construct()
    {
        $this->_ci=& get_instance();
    }
    public function display($template, $data = null)
    {
        $this->_ci->load->view('partials/base_view', $data);
    }
}
?>