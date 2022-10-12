<?php 
/**
 * smartucc 관련 클래스
 *
 */
class tpl_object_smartucc 
{
    public $CI;
   
    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->helper('form');
    }
    
    /**
     * smartucc-인코딩 품질 select box tag를 반환한다.
     * @param string $name
     * @param string $selected
     * @param string|array $extra
     * @return string
     */
    function form_encoding_speed($name = 'encoding_speed', $selected = '400', $extra = '') {
        $options = array(
            '200' => '200',
            '400' => '400',
            '600' => '600',
            '800' => '800',
            '1000' => '1000',
        );
        if(!in_array($selected, array_keys($options))) {
            $selected = '400';
        }
        return form_dropdown($name, $options, $selected, $extra);
    }
    
    /**
     * smartucc-인코딩 크기 select box tag를 반환한다.
     * @param string $name
     * @param string $selected
     * @param string|array $extra
     * @return string
     */
    function form_encoding_screen($name = 'encoding_screen', $selected = '400|300', $extra = '') {
        $options = array(
            '320|240' => '320x240',
            '400|300' => '400x300',
            '640|480' => '640x480',
            '720|480' => '720x480',
        );
        if(!in_array($selected, array_keys($options))) {
            $selected = '400|300';
        }
        return form_dropdown($name, $options, $selected, $extra);
    }
}