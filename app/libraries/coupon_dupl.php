<?php 
/**
 * order/calculate 에서 쿠폰의 중복 사용을 체크하기 위해 만든 클래스
 * 2019-10-30
 * @author Sunha Ryu
 */
class coupon_dupl
{
    /** 
     * @var 쿠폰 form 데이터
     */
    protected $data;
    
    /**
     * @var 쿠폰의 종류 (download | shipping)
     */
    protected $type;
    
    
    /**
     * 생성자
     * @param array $data
     * @param string $type : download | shipping
     */
    public function __construct($data, $type = 'download')
    {
        $this->data = $data;
        if(in_array($type, array('download', 'shipping')) !== true) {
            $this->type = 'download';
        } else {
            $this->type = $type;
        }
    }
    
    /**
     * form 데이터에서 중복 시퀀스를 배열로 반환한다.
     * @return boolean
     */
    public function getDuplSeqByForm()
    {
        $duplMethod = ucfirst($this->type);
        $duplData = $this->{'getDuplBy' . $duplMethod}();
        
        if(empty($duplData) || !is_array($duplData) || count($duplData) < 1) return array();
        
        return array_values($duplData);
    }
    
    /**
     * 데이터베이스에서 중복 시퀀스/쿠폰명을 배열로 반환한다.
     * @param Resource $handler
     * @param array|int $download_seq
     */
    public function getDuplData($handler, $download_seq)
    {
        $duplSeqList = array();
        if(empty($download_seq)) {
            return $duplSeqList;
        }
        
        if(empty($handler)) {
            return $duplSeqList;
        }
        
        if(!is_array($download_seq)) {
            $download_seq = array($download_seq);
        }
        
        $query = $handler->select("download_seq, coupon_name", false)
        ->from("fm_download")
        ->where_in("download_seq", $download_seq)
        ->where("duplication_use", "0")
        ->get();
        $result = $query->result_array();
        if(count($result)>0) {
            foreach($result as $row) {
                $duplSeqList[$row['download_seq']] = $row['coupon_name'];
            }
        }
        return $duplSeqList;
    }
    
    
    /**
     * 다운로드 쿠폰의 중복 seq를 반환한다.
     * @return array[]
     */
    protected function getDuplByDownload()
    {
        $couponList = array();
        $duplList = array();
        foreach($this->data as $cart_seq => $elem) {
            
            if(count($elem) < 1) continue;
            
            foreach($elem as $cart_option_seq => $download_seq) {
                if(in_array($download_seq, $couponList) === true) {
                    $duplList[$download_seq] = $download_seq;
                } else {
                    $couponList[] = $download_seq;
                }
                
            }
        }
        return $duplList;
    }
    
    /**
     * 배송비 쿠폰의 중복 seq를 반환한다.
     * @return array[]
     */
    protected function getDuplByShipping()
    {
        $couponList = array();
        $duplList = array();
       
        foreach($this->data as $shipping_group => $download_seq) {
            if(in_array($download_seq, $couponList) === true) {
                $duplList[$download_seq] = $download_seq;
            } else {
                $couponList[] = $download_seq;
            }
            
        }
        return $duplList;
    }
    
    
}

// EOF