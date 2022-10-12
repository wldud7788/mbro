<?php

/**
* EAN 13 바코드 생성 클래스
* @author pjw
* @version 1.0
*/
class EAN13
{
	//바코드 생성 검사키
	protected $PARITY_KEY		= array(0 => "000000", 1 => "001011", 2 => "001101", 3 => "001110", 4 => "010011", 5 => "011001", 6 => "011100", 7 => "010101", 8 => "010110", 9 => "011010");
	protected $LEFT_PARITY	= array( 0 => array ( 0 => "0001101", 1 => "0011001", 2 => "0010011", 3 => "0111101", 4 => "0100011", 5 => "0110001", 6 => "0101111", 7 => "0111011", 8 => "0110111", 9 => "0001011" ), 1 => array ( 0 => "0100111", 1 => "0110011", 2 => "0011011", 3 => "0100001", 4 => "0011101", 5 => "0111001", 6 => "0000101", 7 => "0010001", 8 => "0001001", 9 => "0010111" ) );
	protected $RIGHT_PARITY	= array( 0 => "1110010", 1 => "1100110", 2 => "1101100", 3 => "1000010", 4 => "1011100", 5 => "1001110", 6 => "1010000", 7 => "1000100", 8 => "1001000", 9 => "1110100" );
	protected $GUARDS			= array( 'start' => "101", 'middle' => "01010", 'end' => "101", );
	
	//바코드 변수
	protected $_key;
	protected $_checksum; 
	protected $_bars;

	//바코드 이미지 변수
	protected $_image;
	protected $_width;
	protected $_height;

	public function __construct($number, $scale){

		$this->_key = $this->PARITY_KEY[substr($number,0,1)];

		// The checksum is appended to the 12 digit string
		$this->_checksum = $this->ean_checksum($number);

		if(strlen($number) > 12){
			$tmp_str = substr($number,0,11);
			$this->number = $tmp_str.$this->_checksum;
		}else{
			$this->number = $number.$this->_checksum;
		}		

		$this->scale = $scale;

		$this->_bars = $this->_encode();
		$this->_createImage();
		$this->_drawBars();
		//$this->_drawText();
	}
	
	//코드 정보를 ISBN 바코드로 변환
	protected function _encode(){

		$barcode[] = $this->GUARDS['start'];
		for($i=1;$i<=strlen($this->number)-1;$i++){
			if($i<7)	$barcode[] = $this->LEFT_PARITY[$this->_key[$i-1]][substr($this->number, $i, 1)];
			else		$barcode[] = $this->RIGHT_PARITY[substr($this->number, $i, 1)];
			if($i==6)	$barcode[] = $this->GUARDS['middle'];
		}
		$barcode[] = $this->GUARDS['end'];

		return $barcode;
	}

	//바코드 크기에 따라 이미지 생성
	protected function _createImage() {
		$this->_height = $this->scale;
		$this->_width  = 20 + strlen(implode($this->_bars));
		//$this->_width  = $this->_height + 85;

		$this->_image = imagecreate($this->_width, $this->_height);
		$bg_color=ImageColorAllocate($this->_image, 0xFF, 0xFF, 0xFF);
	}
	
	//코드 정보를 이미지에 그림
	protected function _drawBars(){
		$black = imagecolorallocate ($this->_image, 0, 0, 0);
		$white = imagecolorallocate ($this->_image, 255, 255, 255);

		$MAX	= $this->_height*0.025;
		$FLOOR	= $this->_height*0.9;
		//$FLOOR	= $this->_height*0.79;	//숫자 표시할 경우
		
		$location = 10;
		foreach($this->_bars as $bar){
			$tall = 0;

			if(strlen($bar)==3 || strlen($bar)==5){
				$tall = ($this->_height*0.15);
			}
			
			for($position = 1; $position <= strlen($bar); $position++){
				$tmp_code = substr($bar, $position - 1, 1);

				imagefilledrectangle($this->_image, $location, $MAX, $location + 0.9, $FLOOR+$tall, ($tmp_code == 0 ? $white : $black));
				$location++;
			}
		}
	}
	
	//코드 정보 텍스트를 삽입
	protected function _drawText(){
		$x = $this->_width*0.043;
		$y = $this->_height;

		$text_color=ImageColorAllocate($this->_image, 0x00, 0x00, 0x00);

		$font= $_SERVER['DOCUMENT_ROOT'].'/system/fonts/texb.ttf';
		$fontsize = $this->_width * 0.061;
		$kerning = $fontsize*1;

		for($i=0;$i<strlen($this->number);$i++){
			imagettftext($this->_image, $fontsize, 0, $x, $y, $text_color, $font, $this->number[$i]);
			if($i==0 || $i==6) {
				$x += $kerning*0.5;
			}
			$x += $kerning;
		}
	}
	
	//실제 이미지를 출력한다.
	public function display(){
		header("Content-Type: image/png; ");
		imagepng($this->_image);
		imagedestroy($this->_image);
	} 
	
	//체크섬 함수
	function ean_checksum($ean){
		$ean=(string)$ean;
		$even=true; $esum=0; $osum=0;

		for ($i=strlen($ean)-1;$i>=0;$i--){
			if ($even) $esum+=$ean[$i];	
			else $osum+=$ean[$i];

			$even=!$even;
		}

		return (10-((3*$esum+$osum)%10))%10;
	}
}
 