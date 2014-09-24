<?php
	/**
	* �������ƥ��ִ���
	* code by С־
	*/
	class Segment
	{
		
		const SEPERATE = "/"; //����ָ�������
		function __construct()
		{
			# code...
		}
		
		
		/*
		 * ��ȡ�����ַ�������
		* @param string $str �ַ���
		* @parma integer @mylen ����
		* return string �ַ���
		*/
		static function substr_CN($str,$mylen){
			$len=strlen($str);
			$content='';
			$count=0;
			for($i=0;$i<$len;$i++){
				if(ord(substr($str,$i,1))>127){
					$content.=substr($str,$i,2);
					$i++;
				}else{
					$content.=substr($str,$i,1);
				}
				if(++$count==$mylen){
					break;
				}
			}
			return $content;
		}
		
		/*
		 * ��ʼ���ִʴʵ亯��
		 * @param string $dictPath �ʵ��ļ�·��
		 * return array() ���شʵ����飨ÿ������Ԫ��Ϊһ���ʣ�
		 */
		static function dictinit($dictPath){

			if ($dictPath!="") {
				
				$result = preg_replace('/\r|\n/', '', file($dictPath));
				return $result;
			}else
			{
				return "Read dict failed";
			}
		}
		
		/*�ִ�������
		 * @param string $s1 ���ִ��ĵ��ַ���
		 * @param string $s2 �ִʽ���ַ���
		 * @param string $w �������ƥ���ѡ�ַ������ø��ַ�������ȥ���ʵ�ȶ�
		 * @param array() $dict �ʵ�����
		 * @param integer $maxLength ���ʳ�
		 * return string $s2 �зֽ������
		 */
		static function seg($s1,$s2,$w,$dict,$maxLength){
			
			$len = strlen($s1);
			if ($maxLength<$len)
			{
				$len = $maxLength;
			}
			echo "���ʳ�len:".$len."<br><br>";
			echo "�ִʹ��̣�<br><br>";
			while ($s1!="")
			{
				echo "s1:".$s1."<br>";
				$w = self::substr_CN($s1, $len);
				while (!in_array($w, $dict))
				{
					$len -= 1;
					$w = self::substr_CN($s1, $len);
					if (strlen($w)==2)
					{
						break;
					}
				}
				echo "w:".$w."<br>";
				$s1 = str_replace($w, "", $s1);
				$s2 .= $w.self::SEPERATE;
				$len = $maxLength;
				
			}
			echo "<br>���շִʽ��:".$s2."<br>";
			return $s2;
			
		}
	}
?>